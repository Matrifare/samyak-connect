<?php
/**
 * Message Model
 * Handles inbox, sent, and conversation messaging
 */

namespace App\Models;

use App\Core\Model;

class Message extends Model
{
    protected string $table = 'messages';
    protected array $fillable = [
        'from_id', 'to_id', 'subject', 'message', 'is_read', 
        'deleted_by_sender', 'deleted_by_receiver', 'created_at'
    ];

    public function getInbox(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT m.*, r.username, r.photo1, r.matri_id
                  FROM {$this->table} m
                  LEFT JOIN register r ON m.from_id = r.matri_id
                  WHERE m.to_id = ? AND m.deleted_by_receiver = 0
                  ORDER BY m.created_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    public function getSent(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT m.*, r.username, r.photo1, r.matri_id
                  FROM {$this->table} m
                  LEFT JOIN register r ON m.to_id = r.matri_id
                  WHERE m.from_id = ? AND m.deleted_by_sender = 0
                  ORDER BY m.created_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    public function getConversation(string $userId, string $otherId, int $limit = 50): array
    {
        $query = "SELECT m.*, 
                         CASE WHEN m.from_id = ? THEN 'sent' ELSE 'received' END as direction
                  FROM {$this->table} m
                  WHERE (m.from_id = ? AND m.to_id = ? AND m.deleted_by_sender = 0)
                     OR (m.from_id = ? AND m.to_id = ? AND m.deleted_by_receiver = 0)
                  ORDER BY m.created_at ASC
                  LIMIT ?";

        return $this->db->select($query, [$userId, $userId, $otherId, $otherId, $userId, $limit]);
    }

    public function send(string $from, string $to, string $subject, string $message): int
    {
        $query = "INSERT INTO {$this->table} (from_id, to_id, subject, message, is_read, created_at)
                  VALUES (?, ?, ?, ?, 0, NOW())";
        
        return $this->db->insert($query, [$from, $to, $subject, $message]);
    }

    public function markAsRead(int $messageId, string $userId): bool
    {
        $query = "UPDATE {$this->table} SET is_read = 1 WHERE id = ? AND to_id = ?";
        return $this->db->update($query, [$messageId, $userId]) > 0;
    }

    public function deleteForUser(int $messageId, string $userId, string $type = 'receiver'): bool
    {
        $column = $type === 'sender' ? 'deleted_by_sender' : 'deleted_by_receiver';
        $idColumn = $type === 'sender' ? 'from_id' : 'to_id';
        
        $query = "UPDATE {$this->table} SET {$column} = 1 WHERE id = ? AND {$idColumn} = ?";
        return $this->db->update($query, [$messageId, $userId]) > 0;
    }

    public function getUnreadCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE to_id = ? AND is_read = 0 AND deleted_by_receiver = 0";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function canMessage(string $fromId, string $toId): array
    {
        // Check if blocked
        $query = "SELECT COUNT(*) as count FROM block_profile 
                  WHERE (block_by = ? AND block_to = ?) OR (block_by = ? AND block_to = ?)";
        $result = $this->db->selectOne($query, [$fromId, $toId, $toId, $fromId]);
        
        if (($result['count'] ?? 0) > 0) {
            return ['can_message' => false, 'reason' => 'blocked'];
        }

        return ['can_message' => true];
    }

    public function getInboxCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE to_id = ? AND deleted_by_receiver = 0";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function getSentCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE from_id = ? AND deleted_by_sender = 0";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }
}
