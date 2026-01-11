<?php
/**
 * Shortlist Model
 * Handles profile shortlisting/favorites
 */

namespace App\Models;

use App\Core\Model;

class Shortlist extends Model
{
    protected string $table = 'shortlist';
    protected array $fillable = ['user_id', 'shortlisted_id', 'created_at'];

    /**
     * Add to shortlist
     */
    public function add(string $userId, string $profileId): array
    {
        // Check if already shortlisted
        if ($this->isShortlisted($userId, $profileId)) {
            return ['success' => false, 'message' => 'Already in shortlist'];
        }

        $query = "INSERT INTO {$this->table} (user_id, shortlisted_id, created_at) VALUES (?, ?, NOW())";
        $id = $this->db->insert($query, [$userId, $profileId]);

        if ($id) {
            return ['success' => true, 'message' => 'Added to shortlist'];
        }

        return ['success' => false, 'message' => 'Failed to add to shortlist'];
    }

    /**
     * Remove from shortlist
     */
    public function remove(string $userId, string $profileId): array
    {
        $query = "DELETE FROM {$this->table} WHERE user_id = ? AND shortlisted_id = ?";
        $deleted = $this->db->delete($query, [$userId, $profileId]);

        if ($deleted > 0) {
            return ['success' => true, 'message' => 'Removed from shortlist'];
        }

        return ['success' => false, 'message' => 'Not found in shortlist'];
    }

    /**
     * Check if shortlisted
     */
    public function isShortlisted(string $userId, string $profileId): bool
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ? AND shortlisted_id = ?";
        $result = $this->db->selectOne($query, [$userId, $profileId]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Get user's shortlist
     */
    public function getList(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT s.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name, r.height,
                         r.edu_name, r.ocp_name, r.profile_text
                  FROM {$this->table} s
                  LEFT JOIN register_view r ON s.shortlisted_id = r.matri_id
                  WHERE s.user_id = ?
                  ORDER BY s.created_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get users who shortlisted me
     */
    public function getWhoShortlistedMe(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT s.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name
                  FROM {$this->table} s
                  LEFT JOIN register_view r ON s.user_id = r.matri_id
                  WHERE s.shortlisted_id = ?
                  ORDER BY s.created_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get shortlist count
     */
    public function getCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ?";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    /**
     * Toggle shortlist status
     */
    public function toggle(string $userId, string $profileId): array
    {
        if ($this->isShortlisted($userId, $profileId)) {
            return $this->remove($userId, $profileId);
        }
        return $this->add($userId, $profileId);
    }
}
