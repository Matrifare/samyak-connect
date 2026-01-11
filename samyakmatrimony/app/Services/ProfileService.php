<?php
/**
 * Profile Service
 * Handles profile-related operations with API-ready abstraction
 */

namespace App\Services;

use App\Core\Database;
use App\Core\Session;

class ProfileService
{
    private Database $db;
    private Session $session;
    private ?ApiService $api = null;
    private bool $useApi = false;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
    }

    /**
     * Enable API mode
     */
    public function enableApiMode(string $apiUrl, string $token): void
    {
        $this->useApi = true;
        $this->api = new ApiService($apiUrl);
        $this->api->setAuthToken($token);
    }

    /**
     * Get profile by ID
     */
    public function getProfile(string $matriId): ?array
    {
        if ($this->useApi) {
            $response = $this->api->get("/profiles/{$matriId}");
            return $response['success'] ? $response['data'] : null;
        }

        $profile = $this->db->selectOne(
            "SELECT r.*, 
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    rel.religion_name,
                    c.caste_name,
                    ct.city_name,
                    st.state_name
             FROM register r
             LEFT JOIN religion rel ON r.religion_id = rel.religion_id
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             LEFT JOIN state st ON r.state = st.id
             WHERE r.matri_id = ?",
            [$matriId]
        );

        if ($profile) {
            unset($profile['password'], $profile['photo_pswd']);
        }

        return $profile;
    }

    /**
     * Update profile
     */
    public function updateProfile(string $matriId, array $data): array
    {
        if ($this->useApi) {
            $response = $this->api->put("/profiles/{$matriId}", $data);
            return [
                'success' => $response['success'],
                'message' => $response['data']['message'] ?? 'Profile updated.'
            ];
        }

        // Build update query dynamically
        $allowedFields = [
            'username', 'birthdate', 'height', 'complexion', 'blood_group',
            'm_status', 'mother_tongue', 'caste_id', 'subcaste', 'gothra',
            'education', 'education_field', 'occupation', 'income', 'job_location',
            'father_name', 'father_occupation', 'mother_name', 'mother_occupation',
            'brothers', 'sisters', 'family_status', 'family_type', 'family_values',
            'state', 'city', 'address', 'profile_text',
            'part_frm_age', 'part_to_age', 'part_height', 'part_religion',
            'part_caste', 'part_income', 'part_education', 'hobbies'
        ];

        $updates = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "{$key} = ?";
                $params[] = $value;
            }
        }

        if (empty($updates)) {
            return [
                'success' => false,
                'message' => 'No valid fields to update.'
            ];
        }

        $updates[] = "updated_at = NOW()";
        $params[] = $matriId;

        try {
            $this->db->update(
                "UPDATE register SET " . implode(', ', $updates) . " WHERE matri_id = ?",
                $params
            );

            return [
                'success' => true,
                'message' => 'Profile updated successfully.'
            ];
        } catch (\Exception $e) {
            error_log("Profile update failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to update profile. Please try again.'
            ];
        }
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto(string $matriId, array $file, string $photoField = 'photo1'): array
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return [
                'success' => false,
                'message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.'
            ];
        }

        if ($file['size'] > $maxSize) {
            return [
                'success' => false,
                'message' => 'File too large. Maximum size is 5MB.'
            ];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $matriId . '_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../public/uploads/photos/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
            // Delete old photo if exists
            $oldPhoto = $this->db->selectOne(
                "SELECT {$photoField} FROM register WHERE matri_id = ?",
                [$matriId]
            );

            if (!empty($oldPhoto[$photoField]) && file_exists($uploadPath . $oldPhoto[$photoField])) {
                unlink($uploadPath . $oldPhoto[$photoField]);
            }

            // Update database
            $this->db->update(
                "UPDATE register SET {$photoField} = ?, updated_at = NOW() WHERE matri_id = ?",
                [$filename, $matriId]
            );

            return [
                'success' => true,
                'message' => 'Photo uploaded successfully.',
                'filename' => $filename,
                'url' => '/uploads/photos/' . $filename
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to upload photo. Please try again.'
        ];
    }

    /**
     * Search profiles
     */
    public function search(array $filters, int $page = 1, int $perPage = 20): array
    {
        if ($this->useApi) {
            $filters['page'] = $page;
            $filters['per_page'] = $perPage;
            $response = $this->api->get('/profiles/search', $filters);
            return $response['success'] ? $response['data'] : ['data' => [], 'total' => 0];
        }

        $conditions = ["r.status = 'APPROVED'"];
        $params = [];

        // Gender filter
        if (!empty($filters['gender'])) {
            $conditions[] = "r.gender = ?";
            $params[] = $filters['gender'];
        }

        // Age filter
        if (!empty($filters['age_from'])) {
            $conditions[] = "TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) >= ?";
            $params[] = (int) $filters['age_from'];
        }
        if (!empty($filters['age_to'])) {
            $conditions[] = "TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) <= ?";
            $params[] = (int) $filters['age_to'];
        }

        // Caste filter
        if (!empty($filters['caste'])) {
            $conditions[] = "r.caste_id = ?";
            $params[] = $filters['caste'];
        }

        // Marital status filter
        if (!empty($filters['m_status'])) {
            $conditions[] = "r.m_status = ?";
            $params[] = $filters['m_status'];
        }

        // Education filter
        if (!empty($filters['education'])) {
            $conditions[] = "r.education LIKE ?";
            $params[] = '%' . $filters['education'] . '%';
        }

        // Location filter
        if (!empty($filters['state'])) {
            $conditions[] = "r.state = ?";
            $params[] = $filters['state'];
        }
        if (!empty($filters['city'])) {
            $conditions[] = "r.city = ?";
            $params[] = $filters['city'];
        }

        $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        $offset = ($page - 1) * $perPage;

        // Get total count
        $countResult = $this->db->selectOne(
            "SELECT COUNT(*) as total FROM register r {$whereClause}",
            $params
        );
        $total = (int) ($countResult['total'] ?? 0);

        // Get results
        $params[] = $perPage;
        $params[] = $offset;

        $results = $this->db->select(
            "SELECT r.matri_id, r.username as name, r.gender, r.birthdate, r.height,
                    r.education, r.occupation, r.city, r.photo1 as photo,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    c.caste_name, ct.city_name
             FROM register r
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             {$whereClause}
             ORDER BY r.index_id DESC
             LIMIT ? OFFSET ?",
            $params
        );

        return [
            'data' => $results,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Get featured profiles for homepage
     */
    public function getFeaturedProfiles(int $limit = 8): array
    {
        return $this->db->select(
            "SELECT r.matri_id, r.matri_id as profile_id, r.username as name, 
                    r.gender, r.photo1 as photo, r.city, r.height,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    c.caste_name
             FROM register r
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             WHERE r.status = 'APPROVED' AND r.photo1 IS NOT NULL
             ORDER BY RAND()
             LIMIT ?",
            [$limit]
        );
    }

    /**
     * Get profile statistics
     */
    public function getStats(): array
    {
        $total = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM register WHERE status = 'APPROVED'"
        );
        $brides = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM register WHERE gender IN ('Bride', 'Female') AND status = 'APPROVED'"
        );
        $grooms = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM register WHERE gender IN ('Groom', 'Male') AND status = 'APPROVED'"
        );

        return [
            'total_profiles' => (int) ($total['count'] ?? 0),
            'female_profiles' => (int) ($brides['count'] ?? 0),
            'male_profiles' => (int) ($grooms['count'] ?? 0),
            'success_stories' => 150 // Update with actual count
        ];
    }
}
