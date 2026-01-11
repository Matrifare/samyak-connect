<?php
/**
 * API Controller
 * Handles AJAX requests and provides JSON responses
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\ProfileService;
use App\Services\InteractionService;

class ApiController extends Controller
{
    private ProfileService $profileService;
    private InteractionService $interactionService;

    public function __construct()
    {
        parent::__construct();
        $this->profileService = new ProfileService();
        $this->interactionService = new InteractionService();
    }

    /**
     * Get castes by religion
     */
    public function getCastes(): void
    {
        $religionId = (int) $this->getQuery('religion_id', 1);

        $castes = $this->db->select(
            "SELECT caste_id, caste_name FROM caste WHERE religion_id = ? ORDER BY caste_name",
            [$religionId]
        );

        $this->json(['success' => true, 'data' => $castes]);
    }

    /**
     * Get cities by state
     */
    public function getCities(): void
    {
        $stateId = (int) $this->getQuery('state_id');

        $cities = $this->db->select(
            "SELECT id, city_name FROM cities WHERE state_id = ? ORDER BY city_name",
            [$stateId]
        );

        $this->json(['success' => true, 'data' => $cities]);
    }

    /**
     * Get states
     */
    public function getStates(): void
    {
        $states = $this->db->select(
            "SELECT id, state_name FROM state ORDER BY state_name"
        );

        $this->json(['success' => true, 'data' => $states]);
    }

    /**
     * Check if email exists
     */
    public function checkEmail(): void
    {
        $email = $this->getQuery('email');
        $exceptId = $this->getQuery('except');

        if (empty($email)) {
            $this->json(['success' => false, 'exists' => false]);
            return;
        }

        $query = "SELECT matri_id FROM register WHERE email = ?";
        $params = [$email];

        if ($exceptId) {
            $query .= " AND matri_id != ?";
            $params[] = $exceptId;
        }

        $result = $this->db->selectOne($query, $params);

        $this->json([
            'success' => true,
            'exists' => $result !== null,
            'message' => $result ? 'Email already registered' : 'Email available'
        ]);
    }

    /**
     * Check if mobile exists
     */
    public function checkMobile(): void
    {
        $mobile = $this->getQuery('mobile');
        $exceptId = $this->getQuery('except');

        if (empty($mobile)) {
            $this->json(['success' => false, 'exists' => false]);
            return;
        }

        $query = "SELECT matri_id FROM register WHERE mobile = ?";
        $params = [$mobile];

        if ($exceptId) {
            $query .= " AND matri_id != ?";
            $params[] = $exceptId;
        }

        $result = $this->db->selectOne($query, $params);

        $this->json([
            'success' => true,
            'exists' => $result !== null,
            'message' => $result ? 'Mobile already registered' : 'Mobile available'
        ]);
    }

    /**
     * Search profiles (AJAX)
     */
    public function searchProfiles(): void
    {
        $filters = [
            'gender' => $this->getQuery('gender'),
            'age_from' => $this->getQuery('age_from'),
            'age_to' => $this->getQuery('age_to'),
            'caste' => $this->getQuery('caste'),
            'm_status' => $this->getQuery('m_status'),
            'education' => $this->getQuery('education'),
            'state' => $this->getQuery('state'),
            'city' => $this->getQuery('city')
        ];

        $page = (int) $this->getQuery('page', 1);
        $perPage = (int) $this->getQuery('per_page', 20);

        $results = $this->profileService->search($filters, $page, $perPage);

        $this->json(['success' => true, 'data' => $results]);
    }

    /**
     * Send interest (AJAX)
     */
    public function sendInterest(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $toId = $this->getPost('profile_id');
        $message = $this->getPost('message', '');
        $user = $this->session->getUser();

        $result = $this->interactionService->sendInterest($user['matri_id'], $toId, $message);

        $this->json($result);
    }

    /**
     * Accept interest (AJAX)
     */
    public function acceptInterest(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $interestId = (int) $this->getPost('interest_id');
        $user = $this->session->getUser();

        $result = $this->interactionService->acceptInterest($interestId, $user['matri_id']);

        $this->json($result);
    }

    /**
     * Decline interest (AJAX)
     */
    public function declineInterest(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $interestId = (int) $this->getPost('interest_id');
        $user = $this->session->getUser();

        $result = $this->interactionService->declineInterest($interestId, $user['matri_id']);

        $this->json($result);
    }

    /**
     * Toggle shortlist (AJAX)
     */
    public function toggleShortlist(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $profileId = $this->getPost('profile_id');
        $user = $this->session->getUser();

        $result = $this->interactionService->toggleShortlist($user['matri_id'], $profileId);

        $this->json($result);
    }

    /**
     * Send message (AJAX)
     */
    public function sendMessage(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $receiverId = $this->getPost('receiver_id');
        $message = $this->getPost('message');
        $user = $this->session->getUser();

        if (empty($message)) {
            $this->json(['success' => false, 'message' => 'Message cannot be empty']);
            return;
        }

        $result = $this->interactionService->sendMessage($user['matri_id'], $receiverId, $message);

        $this->json($result);
    }

    /**
     * Get conversation messages (AJAX)
     */
    public function getMessages(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $otherUserId = $this->getQuery('user_id');
        $user = $this->session->getUser();

        $messages = $this->interactionService->getConversation($user['matri_id'], $otherUserId);

        // Mark as read
        $this->interactionService->markAsRead($user['matri_id'], $otherUserId);

        $this->json(['success' => true, 'data' => $messages]);
    }

    /**
     * Upload photo (AJAX)
     */
    public function uploadPhoto(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->json(['success' => false, 'message' => 'No file uploaded or upload error']);
            return;
        }

        $user = $this->session->getUser();
        $photoField = $this->getPost('field', 'photo1');

        $result = $this->profileService->uploadPhoto($user['matri_id'], $_FILES['photo'], $photoField);

        if ($result['success']) {
            $this->session->set('user_photo', $result['filename']);
        }

        $this->json($result);
    }

    /**
     * Get dashboard stats (AJAX)
     */
    public function getDashboardStats(): void
    {
        if (!$this->isAuthenticated()) {
            $this->json(['success' => false, 'message' => 'Please login first'], 401);
            return;
        }

        $user = $this->session->getUser();
        $matriId = $user['matri_id'];

        $stats = [
            'profile_views' => $this->interactionService->getViewCount($matriId),
            'interests_received' => $this->db->selectOne(
                "SELECT COUNT(*) as count FROM interests WHERE receiver_id = ? AND status = 'pending'",
                [$matriId]
            )['count'] ?? 0,
            'interests_sent' => $this->db->selectOne(
                "SELECT COUNT(*) as count FROM interests WHERE sender_id = ?",
                [$matriId]
            )['count'] ?? 0,
            'unread_messages' => $this->interactionService->getUnreadCount($matriId)
        ];

        $this->json(['success' => true, 'data' => $stats]);
    }
}
