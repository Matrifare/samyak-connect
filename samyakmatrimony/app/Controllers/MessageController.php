<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Security;
use App\Models\Message;
use App\Models\User;
use App\Models\Interest;

class MessageController extends Controller
{
    private Message $messageModel;
    private User $userModel;
    private Interest $interestModel;

    public function __construct()
    {
        parent::__construct();
        $this->messageModel = new Message();
        $this->userModel = new User();
        $this->interestModel = new Interest();
    }

    /**
     * Inbox - list all conversations
     */
    public function inbox(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $conversations = $this->messageModel->getConversations($userId);
        $unreadCount = $this->messageModel->getUnreadCount($userId);

        $this->render('messages/inbox', [
            'title' => 'Messages - Samyak Matrimony',
            'conversations' => $conversations,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * View conversation with a specific user
     */
    public function conversation(int $otherUserId): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        
        // Check if interest is accepted between these users
        $canMessage = $this->interestModel->isAcceptedBetween($userId, $otherUserId);
        
        if (!$canMessage) {
            Session::setFlash('error', 'You can only message users who have accepted your interest.');
            $this->redirect('/messages');
            return;
        }

        // Get the other user's details
        $otherUser = $this->userModel->findById($otherUserId);
        
        if (!$otherUser) {
            Session::setFlash('error', 'User not found.');
            $this->redirect('/messages');
            return;
        }

        // Get messages
        $messages = $this->messageModel->getConversation($userId, $otherUserId);
        
        // Mark messages as read
        $this->messageModel->markAsRead($otherUserId, $userId);

        $this->render('messages/conversation', [
            'title' => 'Chat with ' . $otherUser['name'] . ' - Samyak Matrimony',
            'otherUser' => $otherUser,
            'messages' => $messages
        ]);
    }

    /**
     * Send message
     */
    public function send(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $toUserId = (int)($_POST['to_user_id'] ?? 0);
        $content = Validator::sanitizeString($_POST['message'] ?? '');

        if ($toUserId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid recipient']);
            return;
        }

        if (empty($content)) {
            $this->jsonResponse(['success' => false, 'message' => 'Message cannot be empty']);
            return;
        }

        if (strlen($content) > 2000) {
            $this->jsonResponse(['success' => false, 'message' => 'Message too long (max 2000 characters)']);
            return;
        }

        // Check if interest is accepted
        $canMessage = $this->interestModel->isAcceptedBetween($userId, $toUserId);
        
        if (!$canMessage) {
            $this->jsonResponse(['success' => false, 'message' => 'You can only message users who have accepted your interest']);
            return;
        }

        // Send message
        $messageId = $this->messageModel->send($userId, $toUserId, $content);
        
        if ($messageId) {
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Message sent',
                'data' => [
                    'id' => $messageId,
                    'content' => Security::escapeOutput($content),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to send message']);
        }
    }

    /**
     * Delete message
     */
    public function delete(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $messageId = (int)($_POST['message_id'] ?? 0);

        if ($messageId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid message']);
            return;
        }

        // Verify the message belongs to this user
        $message = $this->messageModel->findById($messageId);
        if (!$message || ($message['from_user_id'] != $userId && $message['to_user_id'] != $userId)) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($this->messageModel->softDelete($messageId, $userId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Message deleted']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to delete message']);
        }
    }

    /**
     * Get unread count (AJAX)
     */
    public function getUnreadCount(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $count = $this->messageModel->getUnreadCount($userId);
        
        $this->jsonResponse(['success' => true, 'count' => $count]);
    }

    /**
     * Get new messages (AJAX for real-time updates)
     */
    public function getNewMessages(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $otherUserId = (int)($_GET['other_user_id'] ?? 0);
        $lastMessageId = (int)($_GET['last_message_id'] ?? 0);

        if ($otherUserId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $messages = $this->messageModel->getNewMessages($userId, $otherUserId, $lastMessageId);
        
        // Mark as read
        if (!empty($messages)) {
            $this->messageModel->markAsRead($otherUserId, $userId);
        }

        $this->jsonResponse(['success' => true, 'messages' => $messages]);
    }
}
