<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Security;
use App\Models\Interest;
use App\Models\User;

class InterestController extends Controller
{
    private Interest $interestModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->interestModel = new Interest();
        $this->userModel = new User();
    }

    /**
     * View received interests
     */
    public function received(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $interests = $this->interestModel->getReceived($userId, $perPage, $offset);
        $totalInterests = $this->interestModel->getReceivedCount($userId);
        $totalPages = ceil($totalInterests / $perPage);

        $this->render('interests/received', [
            'title' => 'Received Interests - Samyak Matrimony',
            'interests' => $interests,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalInterests' => $totalInterests
        ]);
    }

    /**
     * View sent interests
     */
    public function sent(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $interests = $this->interestModel->getSent($userId, $perPage, $offset);
        $totalInterests = $this->interestModel->getSentCount($userId);
        $totalPages = ceil($totalInterests / $perPage);

        $this->render('interests/sent', [
            'title' => 'Sent Interests - Samyak Matrimony',
            'interests' => $interests,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalInterests' => $totalInterests
        ]);
    }

    /**
     * View accepted interests
     */
    public function accepted(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $interests = $this->interestModel->getAccepted($userId, $perPage, $offset);
        $totalInterests = $this->interestModel->getAcceptedCount($userId);
        $totalPages = ceil($totalInterests / $perPage);

        $this->render('interests/accepted', [
            'title' => 'Accepted Interests - Samyak Matrimony',
            'interests' => $interests,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalInterests' => $totalInterests
        ]);
    }

    /**
     * Send interest
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
        $message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');

        if ($toUserId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid profile']);
            return;
        }

        if ($toUserId === $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Cannot send interest to yourself']);
            return;
        }

        // Check if interest already exists
        $existingStatus = $this->interestModel->getStatus($userId, $toUserId);
        if ($existingStatus) {
            $this->jsonResponse(['success' => false, 'message' => 'Interest already sent']);
            return;
        }

        // Send interest
        if ($this->interestModel->send($userId, $toUserId, $message)) {
            $this->jsonResponse(['success' => true, 'message' => 'Interest sent successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to send interest']);
        }
    }

    /**
     * Accept interest
     */
    public function accept(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $interestId = (int)($_POST['interest_id'] ?? 0);

        if ($interestId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid interest']);
            return;
        }

        // Verify the interest belongs to this user
        $interest = $this->interestModel->findById($interestId);
        if (!$interest || $interest['to_user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($this->interestModel->accept($interestId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Interest accepted']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to accept interest']);
        }
    }

    /**
     * Decline interest
     */
    public function decline(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $interestId = (int)($_POST['interest_id'] ?? 0);

        if ($interestId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid interest']);
            return;
        }

        // Verify the interest belongs to this user
        $interest = $this->interestModel->findById($interestId);
        if (!$interest || $interest['to_user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($this->interestModel->decline($interestId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Interest declined']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to decline interest']);
        }
    }

    /**
     * Cancel sent interest
     */
    public function cancel(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $interestId = (int)($_POST['interest_id'] ?? 0);

        if ($interestId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid interest']);
            return;
        }

        // Verify the interest was sent by this user
        $interest = $this->interestModel->findById($interestId);
        if (!$interest || $interest['from_user_id'] != $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        if ($this->interestModel->cancel($interestId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Interest cancelled']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to cancel interest']);
        }
    }
}
