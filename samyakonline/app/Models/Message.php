<?php
/**
 * Message Model
 * Handles inbox, sent messages, and conversations
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Message extends Model
{
    protected string $table = 'inbox';
    protected array $fillable = [
        'msg_from', 'msg_to', 'subject', 'message', 'msg_date', 
        'msg_status', 'read_status', 'deleted_by_sender', 'deleted_by_receiver'
    ];

    /**
     * Get inbox messages for user
     */
    public function getInbox(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT i.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id
                  FROM {$this->table} i
                  LEFT JOIN register r ON i.msg_from = r.matri_id
                  WHERE i.msg_to = ? AND i.deleted_by_receiver = 0
                  ORDER BY i.msg_date DESC
                  LIMIT ?, ?";
        
        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get sent messages for user
     */
    public function getSent(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT i.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id
                  FROM {$this->table} i
                  LEFT JOIN register r ON i.msg_to = r.matri_id
                  WHERE i.msg_from = ? AND i.deleted_by_sender = 0
                  ORDER BY i.msg_date DESC
                  LIMIT ?, ?";
        
        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get conversation between two users
     */
    public function getConversation(string $userId, string $otherId, int $limit = 50): array
    {
        $query = "SELECT i.*, 
                         CASE WHEN i.msg_from = ? THEN 'sent' ELSE 'received' END as direction,
                         r.username, r.photo1, r.gender
                  FROM {$this->table} i
                  LEFT JOIN register r ON (CASE WHEN i.msg_from = ? THEN i.msg_to ELSE i.msg_from END) = r.matri_id
                  WHERE (i.msg_from = ? AND i.msg_to = ?) OR (i.msg_from = ? AND i.msg_to = ?)
                  ORDER BY i.msg_date ASC
                  LIMIT ?";
        
        return $this->db->select($query, [$userId, $userId, $userId, $otherId, $otherId, $userId, $limit]);
    }

    /**
     * Send a new message
     */
    public function send(string $from, string $to, string $subject, string $message): int
    {
        $query = "INSERT INTO {$this->table} (msg_from, msg_to, subject, message, msg_date, msg_status, read_status)
                  VALUES (?, ?, ?, ?, NOW(), 'sent', 'unread')";
        
        return $this->db->insert($query, [$from, $to, $subject, $message]);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(int $messageId, string $userId): bool
    {
        $query = "UPDATE {$this->table} SET read_status = 'read' WHERE msg_id = ? AND msg_to = ?";
        return $this->db->update($query, [$messageId, $userId]) > 0;
    }

    /**
     * Delete message (soft delete)
     */
    public function deleteForUser(int $messageId, string $userId, string $type = 'receiver'): bool
    {
        $field = $type === 'sender' ? 'deleted_by_sender' : 'deleted_by_receiver';
        $userField = $type === 'sender' ? 'msg_from' : 'msg_to';
        
        $query = "UPDATE {$this->table} SET {$field} = 1 WHERE msg_id = ? AND {$userField} = ?";
        return $this->db->update($query, [$messageId, $userId]) > 0;
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE msg_to = ? AND read_status = 'unread' AND deleted_by_receiver = 0";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    /**
     * Check if users can message each other
     */
    public function canMessage(string $fromId, string $toId): array
    {
        // Check if blocked
        $blockQuery = "SELECT COUNT(*) as count FROM block_profile 
                       WHERE (block_by = ? AND block_to = ?) OR (block_by = ? AND block_to = ?)";
        $blocked = $this->db->selectOne($blockQuery, [$fromId, $toId, $toId, $fromId]);
        
        if (($blocked['count'] ?? 0) > 0) {
            return ['allowed' => false, 'reason' => 'User is blocked'];
        }

        // Check membership/message limits here if needed
        return ['allowed' => true];
    }
}
