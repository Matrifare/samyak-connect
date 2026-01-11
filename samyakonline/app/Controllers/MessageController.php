<?php
/**
 * Message Controller
 * Handles inbox, sent, compose messages
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    private Message $messageModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->messageModel = new Message();
        $this->userModel = new User();
    }

    /**
     * Show inbox
     */
    public function inbox(): void
    {
        $this->requireAuth();
        
        $page = (int)($_GET['page'] ?? 1);
        $messages = $this->messageModel->getInbox($_SESSION['user_id'], $page);
        $unreadCount = $this->messageModel->getUnreadCount($_SESSION['user_id']);

        $this->render('messages/inbox', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
            'currentPage' => $page,
            'pageTitle' => 'Inbox'
        ]);
    }

    /**
     * Show sent messages
     */
    public function sent(): void
    {
        $this->requireAuth();
        
        $page = (int)($_GET['page'] ?? 1);
        $messages = $this->messageModel->getSent($_SESSION['user_id'], $page);

        $this->render('messages/sent', [
            'messages' => $messages,
            'currentPage' => $page,
            'pageTitle' => 'Sent Messages'
        ]);
    }

    /**
     * View conversation with a user
     */
    public function conversation(string $profileId): void
    {
        $this->requireAuth();
        
        $profileId = $this->sanitize($profileId);
        $messages = $this->messageModel->getConversation($_SESSION['user_id'], $profileId);
        $otherUser = $this->userModel->findByMatriId($profileId);

        if (!$otherUser) {
            $this->redirect('messages/inbox');
            return;
        }

        $this->render('messages/conversation', [
            'messages' => $messages,
            'otherUser' => $otherUser,
            'pageTitle' => 'Conversation with ' . $otherUser['username']
        ]);
    }

    /**
     * Compose new message form
     */
    public function compose(?string $toId = null): void
    {
        $this->requireAuth();
        
        $recipient = null;
        if ($toId) {
            $recipient = $this->userModel->findByMatriId($this->sanitize($toId));
        }

        $this->render('messages/compose', [
            'recipient' => $recipient,
            'pageTitle' => 'Compose Message'
        ]);
    }

    /**
     * Send a message
     */
    public function send(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('messages/compose');
            return;
        }

        $this->validateCsrf();

        $toId = $this->sanitize($_POST['to'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validation
        if (empty($toId) || empty($subject) || empty($message)) {
            $this->session->flash('error', 'All fields are required');
            $this->redirect('messages/compose/' . $toId);
            return;
        }

        // Check if can message
        $canMessage = $this->messageModel->canMessage($_SESSION['user_id'], $toId);
        if (!$canMessage['allowed']) {
            $this->session->flash('error', $canMessage['reason']);
            $this->redirect('messages/inbox');
            return;
        }

        // Send message
        $messageId = $this->messageModel->send(
            $_SESSION['user_id'],
            $toId,
            htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
        );

        if ($messageId) {
            $this->session->flash('success', 'Message sent successfully');
            $this->redirect('messages/sent');
        } else {
            $this->session->flash('error', 'Failed to send message');
            $this->redirect('messages/compose/' . $toId);
        }
    }

    /**
     * Mark message as read
     */
    public function read(int $messageId): void
    {
        $this->requireAuth();
        
        $this->messageModel->markAsRead($messageId, $_SESSION['user_id']);
        
        // Return JSON for AJAX requests
        if ($this->isAjax()) {
            $this->json(['success' => true]);
            return;
        }

        $this->redirect('messages/inbox');
    }

    /**
     * Delete message
     */
    public function delete(int $messageId): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('messages/inbox');
            return;
        }

        $this->validateCsrf();

        $type = $_POST['type'] ?? 'receiver';
        $this->messageModel->deleteForUser($messageId, $_SESSION['user_id'], $type);

        if ($this->isAjax()) {
            $this->json(['success' => true]);
            return;
        }

        $this->session->flash('success', 'Message deleted');
        $this->redirect('messages/inbox');
    }

    /**
     * Get unread count (AJAX)
     */
    public function unreadCount(): void
    {
        $this->requireAuth();
        
        $count = $this->messageModel->getUnreadCount($_SESSION['user_id']);
        $this->json(['count' => $count]);
    }

    /**
     * Check if request is AJAX
     */
    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
