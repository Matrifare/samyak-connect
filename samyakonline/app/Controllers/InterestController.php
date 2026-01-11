<?php
/**
 * Interest Controller
 * Handles express interest functionality
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\NotificationService;

class InterestController extends Controller
{
    private User $userModel;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->userModel = new User();
    }

    /**
     * Send interest
     */
    public function send(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $toId = $this->getPost('to_id');

        if (empty($toId)) {
            $this->json(['error' => 'Invalid profile'], 400);
        }

        // Check if profile exists
        $toProfile = $this->userModel->findByMatriId($toId);
        if (!$toProfile || $toProfile['status'] !== 'APPROVED') {
            $this->json(['error' => 'Profile not found'], 404);
        }

        // Can't send interest to yourself
        if ($toId === $this->user['matri_id']) {
            $this->json(['error' => 'Cannot send interest to yourself'], 400);
        }

        // Check if already sent
        $existing = $this->db->selectOne(
            "SELECT * FROM express_interest WHERE from_id = ? AND to_id = ?",
            [$this->user['matri_id'], $toId]
        );

        if ($existing) {
            $this->json(['error' => 'Interest already sent', 'status' => $existing['status']], 400);
        }

        // Send interest
        $this->db->insert(
            "INSERT INTO express_interest (from_id, to_id, status, created_at) VALUES (?, ?, 'PENDING', NOW())",
            [$this->user['matri_id'], $toId]
        );

        // Send notification
        $this->sendInterestNotification($toProfile, $this->user);

        $this->json([
            'success' => true,
            'message' => 'Interest sent successfully'
        ]);
    }

    /**
     * Accept interest
     */
    public function accept(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $fromId = $this->getPost('from_id');

        $interest = $this->db->selectOne(
            "SELECT * FROM express_interest WHERE from_id = ? AND to_id = ? AND status = 'PENDING'",
            [$fromId, $this->user['matri_id']]
        );

        if (!$interest) {
            $this->json(['error' => 'Interest not found'], 404);
        }

        // Update status
        $this->db->update(
            "UPDATE express_interest SET status = 'ACCEPTED', updated_at = NOW() WHERE id = ?",
            [$interest['id']]
        );

        // Send notification to sender
        $fromProfile = $this->userModel->findByMatriId($fromId);
        $this->sendAcceptNotification($fromProfile, $this->user);

        $this->json([
            'success' => true,
            'message' => 'Interest accepted'
        ]);
    }

    /**
     * Decline interest
     */
    public function decline(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $fromId = $this->getPost('from_id');

        $interest = $this->db->selectOne(
            "SELECT * FROM express_interest WHERE from_id = ? AND to_id = ? AND status = 'PENDING'",
            [$fromId, $this->user['matri_id']]
        );

        if (!$interest) {
            $this->json(['error' => 'Interest not found'], 404);
        }

        // Update status
        $this->db->update(
            "UPDATE express_interest SET status = 'DECLINED', updated_at = NOW() WHERE id = ?",
            [$interest['id']]
        );

        $this->json([
            'success' => true,
            'message' => 'Interest declined'
        ]);
    }

    /**
     * List received interests
     */
    public function received(): void
    {
        $this->requireAuth();

        $page = max(1, (int) ($this->getQuery('page') ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $interests = $this->db->select(
            "SELECT ei.*, r.matri_id, r.username, r.photo1, r.city, r.occupation,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    c.caste_name, ct.city_name
             FROM express_interest ei
             JOIN register r ON ei.from_id = r.matri_id
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             WHERE ei.to_id = ?
             ORDER BY ei.created_at DESC
             LIMIT ? OFFSET ?",
            [$this->user['matri_id'], $perPage, $offset]
        );

        $total = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM express_interest WHERE to_id = ?",
            [$this->user['matri_id']]
        )['count'];

        $this->render('interest/received', [
            'title' => 'Interests Received - Samyak Matrimony',
            'interests' => $interests,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage),
                'total' => $total
            ]
        ]);
    }

    /**
     * List sent interests
     */
    public function sent(): void
    {
        $this->requireAuth();

        $page = max(1, (int) ($this->getQuery('page') ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $interests = $this->db->select(
            "SELECT ei.*, r.matri_id, r.username, r.photo1, r.city, r.occupation,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    c.caste_name, ct.city_name
             FROM express_interest ei
             JOIN register r ON ei.to_id = r.matri_id
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             WHERE ei.from_id = ?
             ORDER BY ei.created_at DESC
             LIMIT ? OFFSET ?",
            [$this->user['matri_id'], $perPage, $offset]
        );

        $total = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM express_interest WHERE from_id = ?",
            [$this->user['matri_id']]
        )['count'];

        $this->render('interest/sent', [
            'title' => 'Interests Sent - Samyak Matrimony',
            'interests' => $interests,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage),
                'total' => $total
            ]
        ]);
    }

    /**
     * Send interest notification
     */
    private function sendInterestNotification(array $toProfile, array $fromUser): void
    {
        // Implement SMS/Email notification
    }

    /**
     * Send acceptance notification
     */
    private function sendAcceptNotification(array $toProfile, array $fromUser): void
    {
        // Implement SMS/Email notification
    }
}
