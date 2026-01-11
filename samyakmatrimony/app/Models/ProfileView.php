<?php
/**
 * ProfileView Model
 * Tracks profile views
 */

namespace App\Models;

use App\Core\Model;

class ProfileView extends Model
{
    protected string $table = 'profile_views';
    protected array $fillable = ['viewer_id', 'profile_id', 'viewed_at'];

    public function recordView(string $viewerId, string $profileId): bool
    {
        // Don't record self-views
        if ($viewerId === $profileId) {
            return false;
        }

        // Check if already viewed today
        $existing = $this->db->selectOne(
            "SELECT id FROM {$this->table} 
             WHERE viewer_id = ? AND profile_id = ? AND DATE(viewed_at) = CURDATE()",
            [$viewerId, $profileId]
        );

        if ($existing) {
            return false;
        }

        $query = "INSERT INTO {$this->table} (viewer_id, profile_id, viewed_at) VALUES (?, ?, NOW())";
        return $this->db->insert($query, [$viewerId, $profileId]) > 0;
    }

    public function getViewers(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT pv.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
                  FROM {$this->table} pv
                  LEFT JOIN register_view r ON pv.viewer_id = r.matri_id
                  WHERE pv.profile_id = ?
                  ORDER BY pv.viewed_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    public function getViewed(string $userId, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT pv.*, r.username, r.photo1, r.photo1_approve, r.gender, r.matri_id,
                         r.birthdate, r.city_name, r.religion_name, r.caste_name,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
                  FROM {$this->table} pv
                  LEFT JOIN register_view r ON pv.profile_id = r.matri_id
                  WHERE pv.viewer_id = ?
                  ORDER BY pv.viewed_at DESC
                  LIMIT ?, ?";

        return $this->db->select($query, [$userId, $offset, $limit]);
    }

    public function getViewCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE profile_id = ?";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function getTodayViewCount(string $userId): int
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} 
                  WHERE profile_id = ? AND DATE(viewed_at) = CURDATE()";
        $result = $this->db->selectOne($query, [$userId]);
        return $result['count'] ?? 0;
    }

    public function getViewersCount(string $userId): int
    {
        return $this->getViewCount($userId);
    }
}
