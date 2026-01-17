<?php
/**
 * User Model
 * Handles user/member database operations
 */

namespace App\Models;

use App\Core\Model;
use App\Core\Security;

class User extends Model
{
    protected string $table = 'register';
    protected string $primaryKey = 'matri_id';
    
    protected array $fillable = [
        'matri_id', 'samyak_id', 'email', 'password', 'mobile', 'phone',
        'username', 'gender', 'birthdate', 'm_status', 'height', 'complexion',
        'religion_id', 'caste_id', 'subcaste', 'mother_tongue', 'gothra',
        'raashi', 'nakshatra', 'manglik', 'horoscope_match',
        'education', 'education_field', 'occupation', 'income', 'job_location',
        'father_name', 'father_occupation', 'mother_name', 'mother_occupation',
        'brothers', 'sisters', 'family_status', 'family_type', 'family_values',
        'state', 'city', 'address', 'photo1', 'photo2', 'photo3', 'photo4',
        'profile_text', 'part_frm_age', 'part_to_age', 'part_height',
        'part_religion', 'part_caste', 'part_income', 'part_education',
        'status', 'mobile_verify_status', 'email_verify_status',
        'photo_view_status', 'photo_protect', 'photo_pswd',
        'created_at', 'updated_at'
    ];
    
    protected array $hidden = ['password', 'photo_pswd'];

    public function findByEmail(string $email): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE email = ?",
            [$email]
        );
    }

    public function findByMatriId(string $matriId): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE matri_id = ?",
            [$matriId]
        );
    }

    public function findBySamyakId(string $samyakId): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE samyak_id = ?",
            [$samyakId]
        );
    }

    public function findForLogin(string $identifier): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} 
             WHERE matri_id = ? OR email = ? OR samyak_id = ?",
            [$identifier, $identifier, $identifier]
        );
    }

    public function emailExists(string $email, ?string $exceptMatriId = null): bool
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($exceptMatriId) {
            $query .= " AND matri_id != ?";
            $params[] = $exceptMatriId;
        }

        $result = $this->db->selectOne($query, $params);
        return ($result['count'] ?? 0) > 0;
    }

    public function mobileExists(string $mobile, ?string $exceptMatriId = null): bool
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE mobile = ?";
        $params = [$mobile];

        if ($exceptMatriId) {
            $query .= " AND matri_id != ?";
            $params[] = $exceptMatriId;
        }

        $result = $this->db->selectOne($query, $params);
        return ($result['count'] ?? 0) > 0;
    }

    public function isBlocked(string $email): ?array
    {
        return $this->db->selectOne(
            "SELECT id, matri_id FROM blocked_registrations WHERE email = ?",
            [$email]
        );
    }

    public function createUser(array $data): string
    {
        $matriId = $this->generateMatriId($data['gender']);
        $data['matri_id'] = $matriId;
        
        if (isset($data['password'])) {
            $data['password'] = Security::hashPassword($data['password']);
        }
        
        $data['status'] = $data['status'] ?? 'PENDING';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->create($data);
        return $matriId;
    }

    public function updatePassword(string $matriId, string $newPassword): bool
    {
        $hashedPassword = Security::hashPassword($newPassword);
        return $this->db->update(
            "UPDATE {$this->table} SET password = ?, updated_at = NOW() WHERE matri_id = ?",
            [$hashedPassword, $matriId]
        ) > 0;
    }

    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return Security::verifyPassword($password, $hashedPassword);
    }

    public function upgradeLegacyPassword(string $matriId, string $password): void
    {
        $hashedPassword = Security::hashPassword($password);
        $this->db->update(
            "UPDATE {$this->table} SET password = ? WHERE matri_id = ?",
            [$hashedPassword, $matriId]
        );
    }

    private function generateMatriId(string $gender): string
    {
        $prefix = ($gender === 'Bride' || $gender === 'Female') ? 'SM' : 'SMB';
        
        $result = $this->db->selectOne(
            "SELECT matri_id FROM {$this->table} 
             WHERE matri_id LIKE ? 
             ORDER BY index_id DESC LIMIT 1",
            [$prefix . '%']
        );

        if ($result) {
            $lastNumber = (int) substr($result['matri_id'], strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1001;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function getFullProfile(string $matriId): ?array
    {
        $user = $this->db->selectOne(
            "SELECT r.*, 
                    rel.religion_name, 
                    c.caste_name,
                    ct.city_name,
                    st.state_name,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age
             FROM {$this->table} r
             LEFT JOIN religion rel ON r.religion_id = rel.religion_id
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             LEFT JOIN state st ON r.state = st.id
             WHERE r.matri_id = ?",
            [$matriId]
        );

        if ($user) {
            unset($user['password'], $user['photo_pswd']);
        }

        return $user;
    }

    public function search(array $filters, int $page = 1, int $perPage = 20): array
    {
        $conditions = [];
        $params = [];

        if (!empty($filters['gender'])) {
            $conditions[] = "r.gender = ?";
            $params[] = $filters['gender'];
        }

        if (!empty($filters['age_from'])) {
            $conditions[] = "TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) >= ?";
            $params[] = (int) $filters['age_from'];
        }
        if (!empty($filters['age_to'])) {
            $conditions[] = "TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) <= ?";
            $params[] = (int) $filters['age_to'];
        }

        if (!empty($filters['religion'])) {
            if (is_array($filters['religion'])) {
                $placeholders = implode(',', array_fill(0, count($filters['religion']), '?'));
                $conditions[] = "r.religion_id IN ({$placeholders})";
                $params = array_merge($params, $filters['religion']);
            } else {
                $conditions[] = "r.religion_id = ?";
                $params[] = $filters['religion'];
            }
        }

        if (!empty($filters['caste'])) {
            $conditions[] = "r.caste_id = ?";
            $params[] = $filters['caste'];
        }

        if (!empty($filters['m_status'])) {
            if (is_array($filters['m_status'])) {
                $placeholders = implode(',', array_fill(0, count($filters['m_status']), '?'));
                $conditions[] = "r.m_status IN ({$placeholders})";
                $params = array_merge($params, $filters['m_status']);
            } else {
                $conditions[] = "r.m_status = ?";
                $params[] = $filters['m_status'];
            }
        }

        if (!empty($filters['city'])) {
            $conditions[] = "r.city = ?";
            $params[] = $filters['city'];
        }

        $conditions[] = "r.status = 'APPROVED'";

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $offset = ($page - 1) * $perPage;

        $countQuery = "SELECT COUNT(*) as total FROM {$this->table} r {$whereClause}";
        $countResult = $this->db->selectOne($countQuery, $params);
        $total = (int) ($countResult['total'] ?? 0);

        $query = "SELECT r.matri_id, r.username, r.gender, r.birthdate, r.height, 
                         r.education, r.occupation, r.city, r.photo1,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                         rel.religion_name, c.caste_name, ct.city_name
                  FROM {$this->table} r
                  LEFT JOIN religion rel ON r.religion_id = rel.religion_id
                  LEFT JOIN caste c ON r.caste_id = c.caste_id
                  LEFT JOIN cities ct ON r.city = ct.id
                  {$whereClause}
                  ORDER BY r.index_id DESC
                  LIMIT ? OFFSET ?";

        $params[] = $perPage;
        $params[] = $offset;

        $results = $this->db->select($query, $params);

        return [
            'data' => $results,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    public function updateLastLogin(string $matriId): void
    {
        $this->db->update(
            "UPDATE {$this->table} SET last_login = NOW() WHERE matri_id = ?",
            [$matriId]
        );
    }

    public function getStats(): array
    {
        $total = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'APPROVED'");
        $brides = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table} WHERE gender = 'Bride' AND status = 'APPROVED'");
        $grooms = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table} WHERE gender = 'Groom' AND status = 'APPROVED'");
        
        return [
            'total' => (int) ($total['count'] ?? 0),
            'brides' => (int) ($brides['count'] ?? 0),
            'grooms' => (int) ($grooms['count'] ?? 0)
        ];
    }

    /**
     * Get featured profiles for homepage
     */
    public function getFeaturedProfiles(int $limit = 8): array
    {
        $query = "SELECT r.matri_id, r.username, r.gender, r.birthdate, r.height, 
                         r.education, r.occupation, r.city, r.photo1,
                         TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                         rel.religion_name, c.caste_name, ct.city_name
                  FROM {$this->table} r
                  LEFT JOIN religion rel ON r.religion_id = rel.religion_id
                  LEFT JOIN caste c ON r.caste_id = c.caste_id
                  LEFT JOIN cities ct ON r.city = ct.id
                  WHERE r.status = 'APPROVED' 
                  AND r.photo1 IS NOT NULL 
                  AND r.photo1 != ''
                  ORDER BY RAND()
                  LIMIT ?";

        return $this->db->select($query, [$limit]);
    }

    /**
     * Get total count of approved profiles
     */
    public function getTotalCount(): int
    {
        $result = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'APPROVED'"
        );
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get count by gender
     */
    public function getCountByGender(string $gender): int
    {
        $genderValue = ($gender === 'Male') ? 'Groom' : 'Bride';
        $result = $this->db->selectOne(
            "SELECT COUNT(*) as count FROM {$this->table} WHERE gender = ? AND status = 'APPROVED'",
            [$genderValue]
        );
        return (int) ($result['count'] ?? 0);
    }
}
