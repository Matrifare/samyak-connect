<?php
/**
 * Profile View Model
 * Tracks who viewed which profiles
 */

namespace App\Models;

use App\Core\Model;

class ProfileView extends Model
{
    protected string $table = 'profile_views';
    protected array $fillable = ['viewer_id', 'viewed_id', 'viewed_at'];

    /**
     * Record a profile view
     */
    public function recordView(string $viewerId, string $viewedId): bool
    {
        // Don't record self-views
        if ($viewerId === $viewedId) {
            return false;
        }

        // Check if viewed today already (prevent spam)
        $today = date('Y-m-d');
        $query = "SELECT id FROM {$this->table} 
                  WHERE viewer_id = ? AND viewed_id = ? AND DATE(viewed_at) = ?";
        $existing = $this->db->selectOne($query, [$viewerId, $viewedId, $today]);

        if ($existing) {
            return false; // Already viewed today
        }

        $insertQuery = "INSERT INTO {$this->table} (viewer_id, viewed_id, viewed_at) VALUES (?, ?, NOW())";
        return $this->db->insert($insertQuery, [$viewerId, $viewedId]) > 0;
    }

    /**
     * Get who viewed my profile
     */
    public function getViewers(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT pv.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name
                  FROM {$this->table} pv
                  LEFT JOIN register_view r ON pv.viewer_id = r.matri_id
                  WHERE pv.viewed_id = ?
                  ORDER BY pv.viewed_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get profiles I viewed
     */
    public function getViewed(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT pv.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name
                  FROM {$this->table} pv
                  LEFT JOIN register_view r ON pv.viewed_id = r.matri_id
                  WHERE pv.viewer_id = ?
                  ORDER BY pv.viewed_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    /**
     * Get view count
     */
    public function getViewCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE viewed_id = ?";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    /**
     * Get today's view count
     */
    public function getTodayViewCount(string $userId): int
    {
        $today = date('Y-m-d');
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE viewed_id = ? AND DATE(viewed_at) = ?";
        $result = $this->db->selectOne($query, [$userId, $today]);
        return $result['count'] ?? 0;
    }
}
