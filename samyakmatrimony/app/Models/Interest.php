<?php
/**
 * Interest Model
 * Handles express interest functionality
 */

namespace App\Models;

use App\Core\Model;

class Interest extends Model
{
    protected string $table = 'expint';
    protected array $fillable = [
        'msg_from', 'msg_to', 'msg_id', 'interest_status', 'created_at', 'updated_at'
    ];

    public function send(string $from, string $to): array
    {
        $existing = $this->findExisting($from, $to);
        if ($existing) {
            return ['success' => false, 'message' => 'Interest already sent'];
        }

        if ($this->isBlocked($from, $to)) {
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

    public function getReceived(string $userId, int $page = 1, int $limit = 20, ?string $status = null): array
    {
        $offset = ($page - 1) * $limit;
        $params = [$userId];
        
        $statusClause = '';
        if ($status) {
            $statusClause = 'AND e.interest_status = ?';
            $params[] = $status;
        }
        
        $query = "SELECT e.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
                  FROM {$this->table} e
                  LEFT JOIN register_view r ON e.msg_from = r.matri_id
                  WHERE e.msg_to = ? {$statusClause}
                  ORDER BY e.created_at DESC
                  LIMIT ?, ?";
        
        $params[] = $offset;
        $params[] = $limit;
        
        return $this->db->select($query, $params);
    }

    public function getSent(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT e.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
                  FROM {$this->table} e
                  LEFT JOIN register_view r ON e.msg_to = r.matri_id
                  WHERE e.msg_from = ?
                  ORDER BY e.created_at DESC
                  LIMIT ?, ?";
        
        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    public function findExisting(string $from, string $to): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE msg_from = ? AND msg_to = ?";
        return $this->db->selectOne($query, [$from, $to]);
    }

    private function isBlocked(string $from, string $to): bool
    {
        $query = "SELECT COUNT(*) as count FROM block_profile 
                  WHERE (block_by = ? AND block_to = ?) OR (block_by = ? AND block_to = ?)";
        $result = $this->db->selectOne($query, [$from, $to, $to, $from]);
        return ($result['count'] ?? 0) > 0;
    }

    public function getPendingCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE msg_to = ? AND interest_status = 'pending'";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function getReceivedCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE msg_to = ?";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function getSentCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE msg_from = ?";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }
}
