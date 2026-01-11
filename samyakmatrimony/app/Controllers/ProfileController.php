<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Security;
use App\Models\User;
use App\Models\ProfileView;
use App\Models\Shortlist;
use App\Models\Interest;

class ProfileController extends Controller
{
    private User $userModel;
    private ProfileView $profileViewModel;
    private Shortlist $shortlistModel;
    private Interest $interestModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->profileViewModel = new ProfileView();
        $this->shortlistModel = new Shortlist();
        $this->interestModel = new Interest();
    }

    /**
     * Dashboard
     */
    public function dashboard(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $user = $this->userModel->findById($userId);
        
        // Get dashboard stats
        $stats = [
            'profile_views' => $this->profileViewModel->getViewCount($userId),
            'interests_received' => $this->interestModel->getReceivedCount($userId),
            'interests_sent' => $this->interestModel->getSentCount($userId),
            'shortlisted_by' => $this->shortlistModel->getShortlistedByCount($userId)
        ];
        
        // Get recent profile views
        $recentViews = $this->profileViewModel->getRecentViewers($userId, 5);
        
        // Get recent interests
        $recentInterests = $this->interestModel->getRecentReceived($userId, 5);

        $this->render('dashboard/index', [
            'title' => 'Dashboard - Samyak Matrimony',
            'user' => $user,
            'stats' => $stats,
            'recentViews' => $recentViews,
            'recentInterests' => $recentInterests
        ]);
    }

    /**
     * View own profile
     */
    public function myProfile(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $user = $this->userModel->findById($userId);

        $this->render('profile/my-profile', [
            'title' => 'My Profile - Samyak Matrimony',
            'user' => $user
        ]);
    }

    /**
     * Edit profile
     */
    public function editProfile(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $user = $this->userModel->findById($userId);

        $this->render('profile/edit', [
            'title' => 'Edit Profile - Samyak Matrimony',
            'user' => $user
        ]);
    }

    /**
     * Update profile
     */
    public function updateProfile(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile/edit');
            return;
        }

        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request. Please try again.');
            $this->redirect('/profile/edit');
            return;
        }

        $userId = Session::getUserId();

        // Sanitize inputs
        $data = [
            'name' => Validator::sanitizeString($_POST['name'] ?? ''),
            'dob' => Validator::sanitizeString($_POST['dob'] ?? ''),
            'height' => Validator::sanitizeString($_POST['height'] ?? ''),
            'weight' => Validator::sanitizeString($_POST['weight'] ?? ''),
            'complexion' => Validator::sanitizeString($_POST['complexion'] ?? ''),
            'blood_group' => Validator::sanitizeString($_POST['blood_group'] ?? ''),
            'marital_status' => Validator::sanitizeString($_POST['marital_status'] ?? ''),
            'mother_tongue' => Validator::sanitizeString($_POST['mother_tongue'] ?? ''),
            'caste' => Validator::sanitizeString($_POST['caste'] ?? ''),
            'sub_caste' => Validator::sanitizeString($_POST['sub_caste'] ?? ''),
            'education' => Validator::sanitizeString($_POST['education'] ?? ''),
            'occupation' => Validator::sanitizeString($_POST['occupation'] ?? ''),
            'income' => Validator::sanitizeString($_POST['income'] ?? ''),
            'city' => Validator::sanitizeString($_POST['city'] ?? ''),
            'state' => Validator::sanitizeString($_POST['state'] ?? ''),
            'country' => Validator::sanitizeString($_POST['country'] ?? 'India'),
            'about_me' => Validator::sanitizeString($_POST['about_me'] ?? ''),
            'family_details' => Validator::sanitizeString($_POST['family_details'] ?? ''),
            'partner_expectations' => Validator::sanitizeString($_POST['partner_expectations'] ?? ''),
            'hobbies' => Validator::sanitizeString($_POST['hobbies'] ?? '')
        ];

        // Update profile
        if ($this->userModel->update($userId, $data)) {
            Session::setFlash('success', 'Profile updated successfully.');
        } else {
            Session::setFlash('error', 'Failed to update profile. Please try again.');
        }

        $this->redirect('/profile/edit');
    }

    /**
     * View other user's profile
     */
    public function viewProfile(string $profileId): void
    {
        $this->requireAuth();
        
        $profile = $this->userModel->findByProfileId($profileId);
        
        if (!$profile) {
            Session::setFlash('error', 'Profile not found.');
            $this->redirect('/search');
            return;
        }

        $userId = Session::getUserId();
        
        // Don't record view if viewing own profile
        if ($profile['id'] != $userId) {
            $this->profileViewModel->recordView($userId, $profile['id']);
        }

        // Check if shortlisted
        $isShortlisted = $this->shortlistModel->isShortlisted($userId, $profile['id']);
        
        // Check interest status
        $interestStatus = $this->interestModel->getStatus($userId, $profile['id']);

        $this->render('profile/view', [
            'title' => $profile['name'] . ' - Samyak Matrimony',
            'profile' => $profile,
            'isShortlisted' => $isShortlisted,
            'interestStatus' => $interestStatus
        ]);
    }

    /**
     * Upload photo
     */
    public function uploadPhoto(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->jsonResponse(['success' => false, 'message' => 'No file uploaded or upload error']);
            return;
        }

        $file = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF allowed.']);
            return;
        }

        if ($file['size'] > $maxSize) {
            $this->jsonResponse(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
            return;
        }

        $userId = Session::getUserId();
        $user = $this->userModel->findById($userId);
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $user['profile_id'] . '_' . time() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../public/uploads/photos/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
            $this->userModel->update($userId, ['photo' => $filename]);
            Session::set('user_photo', $filename);
            $this->jsonResponse(['success' => true, 'message' => 'Photo uploaded successfully', 'filename' => $filename]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to upload photo']);
        }
    }

    /**
     * Change password
     */
    public function changePassword(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile/edit');
            return;
        }

        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request. Please try again.');
            $this->redirect('/profile/edit');
            return;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $userId = Session::getUserId();
        $user = $this->userModel->findById($userId);

        // Verify current password
        $passwordValid = false;
        if (Security::verifyPassword($currentPassword, $user['password'])) {
            $passwordValid = true;
        } elseif (md5($currentPassword) === $user['password']) {
            $passwordValid = true;
        }

        if (!$passwordValid) {
            Session::setFlash('error', 'Current password is incorrect.');
            $this->redirect('/profile/edit');
            return;
        }

        if ($newPassword !== $confirmPassword) {
            Session::setFlash('error', 'New passwords do not match.');
            $this->redirect('/profile/edit');
            return;
        }

        if (!Validator::isStrongPassword($newPassword)) {
            Session::setFlash('error', 'Password must be at least 8 characters with uppercase, lowercase, and number.');
            $this->redirect('/profile/edit');
            return;
        }

        $this->userModel->updatePassword($userId, Security::hashPassword($newPassword));
        Session::setFlash('success', 'Password changed successfully.');
        $this->redirect('/profile/edit');
    }
}
