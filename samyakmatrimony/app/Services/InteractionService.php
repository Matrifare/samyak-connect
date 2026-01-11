<?php
/**
 * Interaction Service
 * Handles interests, shortlists, messages, and profile views
 */

namespace App\Services;

use App\Core\Database;
use App\Core\Session;

class InteractionService
{
    private Database $db;
    private Session $session;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
    }

    // ==========================================
    // INTERESTS
    // ==========================================

    /**
     * Send interest to a profile
     */
    public function sendInterest(string $fromId, string $toId, string $message = ''): array
    {
        // Check if already sent
        $existing = $this->db->selectOne(
            "SELECT id FROM interests WHERE sender_id = ? AND receiver_id = ?",
            [$fromId, $toId]
        );

        if ($existing) {
            return [
                'success' => false,
                'message' => 'You have already sent interest to this profile.'
            ];
        }

        try {
            $this->db->insert(
                "INSERT INTO interests (sender_id, receiver_id, message, status, created_at) 
                 VALUES (?, ?, ?, 'pending', NOW())",
                [$fromId, $toId, $message]
            );

            return [
                'success' => true,
                'message' => 'Interest sent successfully!'
            ];
        } catch (\Exception $e) {
            error_log("Send interest failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send interest. Please try again.'
            ];
        }
    }

    /**
     * Accept interest
     */
    public function acceptInterest(int $interestId, string $userId): array
    {
        $interest = $this->db->selectOne(
            "SELECT * FROM interests WHERE id = ? AND receiver_id = ?",
            [$interestId, $userId]
        );

        if (!$interest) {
            return [
                'success' => false,
                'message' => 'Interest not found.'
            ];
        }

        $this->db->update(
            "UPDATE interests SET status = 'accepted', updated_at = NOW() WHERE id = ?",
            [$interestId]
        );

        return [
            'success' => true,
            'message' => 'Interest accepted! You can now message each other.'
        ];
    }

    /**
     * Decline interest
     */
    public function declineInterest(int $interestId, string $userId): array
    {
        $this->db->update(
            "UPDATE interests SET status = 'declined', updated_at = NOW() 
             WHERE id = ? AND receiver_id = ?",
            [$interestId, $userId]
        );

        return [
            'success' => true,
            'message' => 'Interest declined.'
        ];
    }

    /**
     * Get received interests
     */
    public function getReceivedInterests(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $interests = $this->db->select(
            "SELECT i.*, r.username as name, r.matri_id as profile_id, r.photo1 as photo,
                    r.city, TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
             FROM interests i
             JOIN register r ON i.sender_id = r.matri_id
             WHERE i.receiver_id = ? AND i.status = 'pending'
             ORDER BY i.created_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        );

        $total = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM interests WHERE receiver_id = ? AND status = 'pending'",
            [$userId]
        );

        return [
            'data' => $interests,
            'total' => (int) $total['count']
        ];
    }

    /**
     * Get sent interests
     */
    public function getSentInterests(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $interests = $this->db->select(
            "SELECT i.*, r.username as name, r.matri_id as profile_id, r.photo1 as photo,
                    r.city, TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
             FROM interests i
             JOIN register r ON i.receiver_id = r.matri_id
             WHERE i.sender_id = ?
             ORDER BY i.created_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        );

        $total = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM interests WHERE sender_id = ?",
            [$userId]
        );

        return [
            'data' => $interests,
            'total' => (int) $total['count']
        ];
    }

    /**
     * Get accepted interests
     */
    public function getAcceptedInterests(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $interests = $this->db->select(
            "SELECT i.*, 
                    CASE WHEN i.sender_id = ? THEN r2.username ELSE r1.username END as name,
                    CASE WHEN i.sender_id = ? THEN r2.matri_id ELSE r1.matri_id END as profile_id,
                    CASE WHEN i.sender_id = ? THEN r2.photo1 ELSE r1.photo1 END as photo
             FROM interests i
             JOIN register r1 ON i.sender_id = r1.matri_id
             JOIN register r2 ON i.receiver_id = r2.matri_id
             WHERE (i.sender_id = ? OR i.receiver_id = ?) AND i.status = 'accepted'
             ORDER BY i.updated_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $userId, $userId, $userId, $userId, $limit, $offset]
        );

        return ['data' => $interests];
    }

    // ==========================================
    // SHORTLIST
    // ==========================================

    /**
     * Add to shortlist
     */
    public function addToShortlist(string $userId, string $profileId): array
    {
        $existing = $this->db->selectOne(
            "SELECT id FROM shortlist WHERE user_id = ? AND profile_id = ?",
            [$userId, $profileId]
        );

        if ($existing) {
            return [
                'success' => false,
                'message' => 'Profile already in shortlist.',
                'action' => 'already_exists'
            ];
        }

        $this->db->insert(
            "INSERT INTO shortlist (user_id, profile_id, created_at) VALUES (?, ?, NOW())",
            [$userId, $profileId]
        );

        return [
            'success' => true,
            'message' => 'Added to shortlist!',
            'action' => 'added'
        ];
    }

    /**
     * Remove from shortlist
     */
    public function removeFromShortlist(string $userId, string $profileId): array
    {
        $this->db->delete(
            "DELETE FROM shortlist WHERE user_id = ? AND profile_id = ?",
            [$userId, $profileId]
        );

        return [
            'success' => true,
            'message' => 'Removed from shortlist.',
            'action' => 'removed'
        ];
    }

    /**
     * Toggle shortlist
     */
    public function toggleShortlist(string $userId, string $profileId): array
    {
        $existing = $this->db->selectOne(
            "SELECT id FROM shortlist WHERE user_id = ? AND profile_id = ?",
            [$userId, $profileId]
        );

        if ($existing) {
            return $this->removeFromShortlist($userId, $profileId);
        }

        return $this->addToShortlist($userId, $profileId);
    }

    /**
     * Check if shortlisted
     */
    public function isShortlisted(string $userId, string $profileId): bool
    {
        $result = $this->db->selectOne(
            "SELECT id FROM shortlist WHERE user_id = ? AND profile_id = ?",
            [$userId, $profileId]
        );

        return $result !== null;
    }

    /**
     * Get shortlist
     */
    public function getShortlist(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $profiles = $this->db->select(
            "SELECT s.*, r.username as name, r.matri_id as profile_id, r.photo1 as photo,
                    r.city, r.height, TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
             FROM shortlist s
             JOIN register r ON s.profile_id = r.matri_id
             WHERE s.user_id = ?
             ORDER BY s.created_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        );

        return ['data' => $profiles];
    }

    // ==========================================
    // PROFILE VIEWS
    // ==========================================

    /**
     * Record profile view
     */
    public function recordView(string $viewerId, string $viewedId): void
    {
        if ($viewerId === $viewedId) {
            return;
        }

        // Check if already viewed today
        $existing = $this->db->selectOne(
            "SELECT id FROM profile_views 
             WHERE viewer_id = ? AND viewed_id = ? AND DATE(viewed_at) = CURDATE()",
            [$viewerId, $viewedId]
        );

        if (!$existing) {
            $this->db->insert(
                "INSERT INTO profile_views (viewer_id, viewed_id, viewed_at) VALUES (?, ?, NOW())",
                [$viewerId, $viewedId]
            );
        }
    }

    /**
     * Get who viewed my profile
     */
    public function getProfileViewers(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $viewers = $this->db->select(
            "SELECT pv.*, r.username as name, r.matri_id as profile_id, r.photo1 as photo,
                    r.city, TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
             FROM profile_views pv
             JOIN register r ON pv.viewer_id = r.matri_id
             WHERE pv.viewed_id = ?
             ORDER BY pv.viewed_at DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        );

        return ['data' => $viewers];
    }

    /**
     * Get view count
     */
    public function getViewCount(string $userId): int
    {
        $result = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM profile_views WHERE viewed_id = ?",
            [$userId]
        );

        return (int) ($result['count'] ?? 0);
    }

    // ==========================================
    // MESSAGES
    // ==========================================

    /**
     * Send message
     */
    public function sendMessage(string $senderId, string $receiverId, string $message): array
    {
        // Check if they can message (interest accepted)
        $canMessage = $this->db->selectOne(
            "SELECT id FROM interests 
             WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
             AND status = 'accepted'",
            [$senderId, $receiverId, $receiverId, $senderId]
        );

        if (!$canMessage) {
            return [
                'success' => false,
                'message' => 'You need accepted interest to send messages.'
            ];
        }

        $this->db->insert(
            "INSERT INTO messages (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())",
            [$senderId, $receiverId, $message]
        );

        return [
            'success' => true,
            'message' => 'Message sent!'
        ];
    }

    /**
     * Get conversation
     */
    public function getConversation(string $userId, string $otherUserId, int $limit = 50): array
    {
        return $this->db->select(
            "SELECT * FROM messages 
             WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
             ORDER BY created_at ASC
             LIMIT ?",
            [$userId, $otherUserId, $otherUserId, $userId, $limit]
        );
    }

    /**
     * Get inbox (conversations list)
     */
    public function getInbox(string $userId): array
    {
        return $this->db->select(
            "SELECT m.*, r.username as name, r.matri_id as profile_id, r.photo1 as photo,
                    (SELECT COUNT(*) FROM messages WHERE sender_id = other_id AND receiver_id = ? AND is_read = 0) as unread_count
             FROM (
                 SELECT 
                     CASE WHEN sender_id = ? THEN receiver_id ELSE sender_id END as other_id,
                     MAX(id) as last_msg_id
                 FROM messages
                 WHERE sender_id = ? OR receiver_id = ?
                 GROUP BY other_id
             ) latest
             JOIN messages m ON m.id = latest.last_msg_id
             JOIN register r ON r.matri_id = latest.other_id
             ORDER BY m.created_at DESC",
            [$userId, $userId, $userId, $userId]
        );
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount(string $userId): int
    {
        $result = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0",
            [$userId]
        );

        return (int) ($result['count'] ?? 0);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(string $userId, string $senderId): void
    {
        $this->db->update(
            "UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ?",
            [$userId, $senderId]
        );
    }
}
