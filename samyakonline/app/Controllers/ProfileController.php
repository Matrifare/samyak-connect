<?php
/**
 * Profile Controller
 * Handles profile viewing and management
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    private User $userModel;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->userModel = new User();
    }

    /**
     * View profile
     */
    public function view(): void
    {
        $matriId = $this->params['id'] ?? $this->getQuery('id');

        if (empty($matriId)) {
            $this->flash('error', 'Profile not found');
            $this->redirect('/search');
        }

        $profile = $this->userModel->getFullProfile($matriId);

        if (!$profile) {
            $this->flash('error', 'Profile not found');
            $this->redirect('/search');
        }

        // Check if profile is viewable
        if ($profile['status'] !== 'APPROVED' && 
            (!$this->isAuthenticated() || $this->user['matri_id'] !== $matriId)) {
            $this->flash('error', 'Profile not available');
            $this->redirect('/search');
        }

        // Log profile view if authenticated and not own profile
        if ($this->isAuthenticated() && $this->user['matri_id'] !== $matriId) {
            $this->logProfileView($matriId);
        }

        // Get photos
        $photos = $this->getProfilePhotos($profile);

        // Check interest status
        $interestStatus = null;
        if ($this->isAuthenticated()) {
            $interestStatus = $this->getInterestStatus($this->user['matri_id'], $matriId);
        }

        $this->render('profile/view', [
            'title' => "{$profile['username']} - {$profile['matri_id']} | Samyak Matrimony",
            'profile' => $profile,
            'photos' => $photos,
            'interestStatus' => $interestStatus,
            'canViewContact' => $this->canViewContact($profile)
        ]);
    }

    /**
     * Edit own profile
     */
    public function edit(): void
    {
        $this->requireAuth();

        $profile = $this->userModel->getFullProfile($this->user['matri_id']);

        // Get dropdown data
        $religions = $this->db->select("SELECT * FROM religion WHERE status = 'APPROVED' ORDER BY religion_name");
        $castes = $this->db->select("SELECT * FROM caste WHERE religion_id = ? AND status = 'APPROVED' ORDER BY caste_name", 
            [$profile['religion_id']]);
        $cities = $this->db->select("SELECT * FROM cities ORDER BY city_name");
        $states = $this->db->select("SELECT * FROM state ORDER BY state_name");

        $this->render('profile/edit', [
            'title' => 'Edit Profile - Samyak Matrimony',
            'profile' => $profile,
            'religions' => $religions,
            'castes' => $castes,
            'cities' => $cities,
            'states' => $states,
            'errors' => $this->session->getFlash('errors') ?? [],
            'success' => $this->session->getFlash('success')
        ]);
    }

    /**
     * Update profile
     */
    public function update(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $data = [
            'username' => $this->getPost('username'),
            'height' => $this->getPost('height'),
            'complexion' => $this->getPost('complexion'),
            'religion_id' => $this->getPost('religion_id'),
            'caste_id' => $this->getPost('caste_id'),
            'subcaste' => $this->getPost('subcaste'),
            'mother_tongue' => $this->getPost('mother_tongue'),
            'gothra' => $this->getPost('gothra'),
            'raashi' => $this->getPost('raashi'),
            'nakshatra' => $this->getPost('nakshatra'),
            'manglik' => $this->getPost('manglik'),
            'education' => $this->getPost('education'),
            'education_field' => $this->getPost('education_field'),
            'occupation' => $this->getPost('occupation'),
            'income' => $this->getPost('income'),
            'job_location' => $this->getPost('job_location'),
            'father_name' => $this->getPost('father_name'),
            'father_occupation' => $this->getPost('father_occupation'),
            'mother_name' => $this->getPost('mother_name'),
            'mother_occupation' => $this->getPost('mother_occupation'),
            'brothers' => $this->getPost('brothers'),
            'sisters' => $this->getPost('sisters'),
            'family_status' => $this->getPost('family_status'),
            'family_type' => $this->getPost('family_type'),
            'family_values' => $this->getPost('family_values'),
            'state' => $this->getPost('state'),
            'city' => $this->getPost('city'),
            'address' => $this->getPost('address'),
            'profile_text' => $this->getPost('profile_text')
        ];

        // Validate
        $validator = new Validator($data);
        $validator
            ->required('username', 'Name is required')
            ->maxLength('username', 100)
            ->maxLength('profile_text', 2000, 'Profile description is too long');

        if ($validator->fails()) {
            $this->session->setFlash('errors', $validator->getErrors());
            $this->redirect('/edit-profile');
        }

        // Update
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->userModel->update($this->user['matri_id'], $data);

        $this->session->setFlash('success', 'Profile updated successfully');
        $this->redirect('/edit-profile');
    }

    /**
     * User dashboard/homepage
     */
    public function dashboard(): void
    {
        $this->requireAuth();

        $matriId = $this->user['matri_id'];
        $profile = $this->userModel->getFullProfile($matriId);

        // Get statistics
        $stats = $this->getDashboardStats($matriId);

        // Get recent profile views
        $recentViews = $this->db->select(
            "SELECT r.matri_id, r.username, r.photo1, pv.viewed_at
             FROM profile_views pv
             JOIN register r ON pv.viewer_id = r.matri_id
             WHERE pv.profile_id = ?
             ORDER BY pv.viewed_at DESC LIMIT 5",
            [$matriId]
        );

        // Get recent interests
        $recentInterests = $this->db->select(
            "SELECT r.matri_id, r.username, r.photo1, ei.created_at
             FROM express_interest ei
             JOIN register r ON ei.from_id = r.matri_id
             WHERE ei.to_id = ? AND ei.status = 'PENDING'
             ORDER BY ei.created_at DESC LIMIT 5",
            [$matriId]
        );

        // Get matches
        $matches = $this->getMatches($profile);

        $this->render('profile/dashboard', [
            'title' => 'Dashboard - Samyak Matrimony',
            'profile' => $profile,
            'stats' => $stats,
            'recentViews' => $recentViews,
            'recentInterests' => $recentInterests,
            'matches' => $matches
        ]);
    }

    /**
     * Log profile view
     */
    private function logProfileView(string $profileId): void
    {
        $viewerId = $this->user['matri_id'];

        // Check if already viewed today
        $existing = $this->db->selectOne(
            "SELECT id FROM profile_views 
             WHERE viewer_id = ? AND profile_id = ? AND DATE(viewed_at) = CURDATE()",
            [$viewerId, $profileId]
        );

        if (!$existing) {
            $this->db->insert(
                "INSERT INTO profile_views (viewer_id, profile_id, viewed_at) VALUES (?, ?, NOW())",
                [$viewerId, $profileId]
            );
        }
    }

    /**
     * Get profile photos
     */
    private function getProfilePhotos(array $profile): array
    {
        $photos = [];
        for ($i = 1; $i <= 4; $i++) {
            $photoField = "photo{$i}";
            if (!empty($profile[$photoField])) {
                $photos[] = $profile[$photoField];
            }
        }
        return $photos;
    }

    /**
     * Get interest status between two users
     */
    private function getInterestStatus(string $fromId, string $toId): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM express_interest WHERE from_id = ? AND to_id = ?",
            [$fromId, $toId]
        );
    }

    /**
     * Check if user can view contact details
     */
    private function canViewContact(array $profile): bool
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        // Check if current user has an accepted interest
        $interest = $this->db->selectOne(
            "SELECT * FROM express_interest 
             WHERE ((from_id = ? AND to_id = ?) OR (from_id = ? AND to_id = ?))
             AND status = 'ACCEPTED'",
            [$this->user['matri_id'], $profile['matri_id'], $profile['matri_id'], $this->user['matri_id']]
        );

        return $interest !== null;
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats(string $matriId): array
    {
        return [
            'profile_views' => (int) $this->db->selectOne(
                "SELECT COUNT(*) as count FROM profile_views WHERE profile_id = ?", [$matriId]
            )['count'] ?? 0,
            
            'interests_received' => (int) $this->db->selectOne(
                "SELECT COUNT(*) as count FROM express_interest WHERE to_id = ? AND status = 'PENDING'", [$matriId]
            )['count'] ?? 0,
            
            'interests_sent' => (int) $this->db->selectOne(
                "SELECT COUNT(*) as count FROM express_interest WHERE from_id = ?", [$matriId]
            )['count'] ?? 0,
            
            'shortlisted' => (int) $this->db->selectOne(
                "SELECT COUNT(*) as count FROM shortlist WHERE from_id = ?", [$matriId]
            )['count'] ?? 0,
            
            'unread_messages' => (int) $this->db->selectOne(
                "SELECT COUNT(*) as count FROM messages WHERE to_id = ? AND is_read = 0", [$matriId]
            )['count'] ?? 0
        ];
    }

    /**
     * Get matching profiles based on preferences
     */
    private function getMatches(array $profile): array
    {
        $oppositeGender = $profile['gender'] === 'Bride' ? 'Groom' : 'Bride';
        
        return $this->db->select(
            "SELECT r.matri_id, r.username, r.photo1, r.city, r.occupation,
                    TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) as age,
                    c.caste_name, ct.city_name
             FROM register r
             LEFT JOIN caste c ON r.caste_id = c.caste_id
             LEFT JOIN cities ct ON r.city = ct.id
             WHERE r.gender = ?
             AND r.status = 'APPROVED'
             AND TIMESTAMPDIFF(YEAR, r.birthdate, CURDATE()) BETWEEN ? AND ?
             AND r.matri_id != ?
             ORDER BY r.index_id DESC
             LIMIT 10",
            [
                $oppositeGender,
                $profile['part_frm_age'] ?? 18,
                $profile['part_to_age'] ?? 60,
                $profile['matri_id']
            ]
        );
    }
}
