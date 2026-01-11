<?php
/**
 * Interest Model
 * Handles express interest requests
 */

namespace App\Models;

use App\Core\Model;

class Interest extends Model
{
    protected string $table = 'expint';
    protected array $fillable = [
        'msg_from', 'msg_to', 'msg_id', 'interest_status', 'created_at', 'updated_at'
    ];

    /**
     * Send express interest
     */
    public function send(string $from, string $to): array
    {
        // Check if already sent
        $existing = $this->findExisting($from, $to);
        if ($existing) {
            return ['success' => false, 'message' => 'Interest already sent'];
        }

        // Check if blocked
        $blocked = $this->isBlocked($from, $to);
        if ($blocked) {
            return ['success' => false, 'message' => 'Cannot send interest to this user'];
        }

        $query = "INSERT INTO {$this->table} (msg_from, msg_to, interest_status, created_at)
                  VALUES (?, ?, 'pending', NOW())";
        
        $id = $this->db->insert($query, [$from, $to]);
        
        if ($id) {
            return ['success' => true, 'message' => 'Interest sent successfully', 'id' => $id];
        }
        
        return ['success' => false, 'message' => 'Failed to send interest'];
    }

    /**
     * Accept interest
     */
    public function accept(int $interestId, string $userId): array
    {
        $query = "UPDATE {$this->table} SET interest_status = 'accepted', updated_at = NOW()
                  WHERE msg_id = ? AND msg_to = ? AND interest_status = 'pending'";
        
        $updated = $this->db->update($query, [$interestId, $userId]);
        
        if ($updated > 0) {
            return ['success' => true, 'message' => 'Interest accepted'];
        }
        
        return ['success' => false, 'message' => 'Could not accept interest'];
    }

    /**
     * Decline interest
     */
    public function decline(int $interestId, string $userId): array
    {
        $query = "UPDATE {$this->table} SET interest_status = 'declined', updated_at = NOW()
                  WHERE msg_id = ? AND msg_to = ? AND interest_status = 'pending'";
        
        $updated = $this->db->update($query, [$interestId, $userId]);
        
        if ($updated > 0) {
            return ['success' => true, 'message' => 'Interest declined'];
        }
        
        return ['success' => false, 'message' => 'Could not decline interest'];
    }

    /**
     * Get received interests
     */
    public function getReceived(string $userId, int $page = 1, int $limit = 20, ?string $status = null): array
    {
        $offset = ($page - 1) * $limit;
        $params = [$userId];
        
        $statusClause = '';
        if ($status) {
            $statusClause = 'AND e.interest_status = ?';
            $params[] = $status;
        }
        
        $params[] = $offset;
        $params[] = $limit;
        
        $query = "SELECT e.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name
                  FROM {$this->table} e
                  LEFT JOIN register_view r ON e.msg_from = r.matri_id
                  WHERE e.msg_to = ? {$statusClause}
                  ORDER BY e.created_at DESC
                  LIMIT ?, ?";
        
        return $this->db->select($query, $params);
    }

    /**
     * Get sent interests
     */
    public function getSent(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT e.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name
                  FROM {$this->table} e
                  LEFT JOIN register_view r ON e.msg_to = r.matri_id
                  WHERE e.msg_from = ?
                  ORDER BY e.created_at DESC
                  LIMIT ?, ?";
        
        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Find existing interest
     */
    public function findExisting(string $from, string $to): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE msg_from = ? AND msg_to = ?";
        return $this->db->selectOne($query, [$from, $to]);
    }

    /**
     * Check if blocked
     */
    private function isBlocked(string $from, string $to): bool
    {
        $query = "SELECT COUNT(*) as count FROM block_profile 
                  WHERE (block_by = ? AND block_to = ?) OR (block_by = ? AND block_to = ?)";
        $result = $this->db->selectOne($query, [$from, $to, $to, $from]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Get pending count
     */
    public function getPendingCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE msg_to = ? AND interest_status = 'pending'";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }
}
