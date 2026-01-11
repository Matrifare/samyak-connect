<?php
/**
 * Settings Controller
 * Handles account settings and preferences
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Security;
use App\Core\Validator;
use App\Services\AuthService;
use App\Services\ProfileService;

class SettingsController extends Controller
{
    private AuthService $authService;
    private ProfileService $profileService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
        $this->profileService = new ProfileService();
    }

    /**
     * Settings dashboard
     */
    public function index(): void
    {
        $this->requireAuth();
        
        $user = $this->session->getUser();
        $profile = $this->profileService->getProfile($user['matri_id']);

        $this->render('settings/index', [
            'title' => 'Account Settings - Samyak Matrimony',
            'user' => $profile
        ]);
    }

    /**
     * Change password page
     */
    public function password(): void
    {
        $this->requireAuth();

        $this->render('settings/password', [
            'title' => 'Change Password - Samyak Matrimony'
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $currentPassword = $this->getPost('current_password');
        $newPassword = $this->getPost('new_password');
        $confirmPassword = $this->getPost('confirm_password');

        // Validation
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $this->flash('error', 'All fields are required.');
            $this->redirect('/settings/password');
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $this->flash('error', 'New passwords do not match.');
            $this->redirect('/settings/password');
            return;
        }

        if (!Validator::isStrongPassword($newPassword)) {
            $this->flash('error', 'Password must be at least 8 characters with uppercase, lowercase, and number.');
            $this->redirect('/settings/password');
            return;
        }

        $user = $this->session->getUser();
        $profile = $this->profileService->getProfile($user['matri_id']);

        // Verify current password
        if (!Security::verifyPassword($currentPassword, $profile['password']) && 
            md5($currentPassword) !== $profile['password']) {
            $this->flash('error', 'Current password is incorrect.');
            $this->redirect('/settings/password');
            return;
        }

        // Update password
        $hashedPassword = Security::hashPassword($newPassword);
        $this->db->update(
            "UPDATE register SET password = ?, updated_at = NOW() WHERE matri_id = ?",
            [$hashedPassword, $user['matri_id']]
        );

        $this->flash('success', 'Password changed successfully!');
        $this->redirect('/settings');
    }

    /**
     * Privacy settings page
     */
    public function privacy(): void
    {
        $this->requireAuth();
        
        $user = $this->session->getUser();
        $profile = $this->profileService->getProfile($user['matri_id']);

        $this->render('settings/privacy', [
            'title' => 'Privacy Settings - Samyak Matrimony',
            'user' => $profile
        ]);
    }

    /**
     * Update privacy settings
     */
    public function updatePrivacy(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $user = $this->session->getUser();
        
        $settings = [
            'photo_view_status' => $this->getPost('photo_visibility') ?: 'all',
            'photo_protect' => $this->getPost('photo_protect') ? 1 : 0,
            'show_contact' => $this->getPost('show_contact') ? 1 : 0,
            'show_income' => $this->getPost('show_income') ? 1 : 0
        ];

        $this->db->update(
            "UPDATE register SET 
                photo_view_status = ?, 
                photo_protect = ?,
                updated_at = NOW() 
             WHERE matri_id = ?",
            [$settings['photo_view_status'], $settings['photo_protect'], $user['matri_id']]
        );

        $this->flash('success', 'Privacy settings updated!');
        $this->redirect('/settings/privacy');
    }

    /**
     * Notification settings page
     */
    public function notifications(): void
    {
        $this->requireAuth();
        
        $user = $this->session->getUser();
        
        // Get current notification preferences
        $preferences = $this->db->selectOne(
            "SELECT * FROM notification_preferences WHERE matri_id = ?",
            [$user['matri_id']]
        );

        $this->render('settings/notifications', [
            'title' => 'Notification Settings - Samyak Matrimony',
            'preferences' => $preferences ?: []
        ]);
    }

    /**
     * Update notification settings
     */
    public function updateNotifications(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $user = $this->session->getUser();
        
        $preferences = [
            'email_interests' => $this->getPost('email_interests') ? 1 : 0,
            'email_messages' => $this->getPost('email_messages') ? 1 : 0,
            'email_views' => $this->getPost('email_views') ? 1 : 0,
            'email_matches' => $this->getPost('email_matches') ? 1 : 0,
            'email_newsletter' => $this->getPost('email_newsletter') ? 1 : 0,
            'sms_interests' => $this->getPost('sms_interests') ? 1 : 0,
            'sms_messages' => $this->getPost('sms_messages') ? 1 : 0
        ];

        // Upsert notification preferences
        $existing = $this->db->selectOne(
            "SELECT id FROM notification_preferences WHERE matri_id = ?",
            [$user['matri_id']]
        );

        if ($existing) {
            $this->db->update(
                "UPDATE notification_preferences SET 
                    email_interests = ?, email_messages = ?, email_views = ?,
                    email_matches = ?, email_newsletter = ?,
                    sms_interests = ?, sms_messages = ?,
                    updated_at = NOW()
                 WHERE matri_id = ?",
                [...array_values($preferences), $user['matri_id']]
            );
        } else {
            $this->db->insert(
                "INSERT INTO notification_preferences 
                    (matri_id, email_interests, email_messages, email_views, 
                     email_matches, email_newsletter, sms_interests, sms_messages, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())",
                [$user['matri_id'], ...array_values($preferences)]
            );
        }

        $this->flash('success', 'Notification settings updated!');
        $this->redirect('/settings/notifications');
    }

    /**
     * Delete account page
     */
    public function deleteAccount(): void
    {
        $this->requireAuth();

        $this->render('settings/delete-account', [
            'title' => 'Delete Account - Samyak Matrimony'
        ]);
    }

    /**
     * Process account deletion
     */
    public function processDeleteAccount(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $password = $this->getPost('password');
        $reason = $this->getPost('reason');
        $confirm = $this->getPost('confirm');

        if ($confirm !== 'DELETE') {
            $this->flash('error', 'Please type DELETE to confirm.');
            $this->redirect('/settings/delete-account');
            return;
        }

        $user = $this->session->getUser();
        $profile = $this->profileService->getProfile($user['matri_id']);

        // Verify password
        if (!Security::verifyPassword($password, $profile['password']) && 
            md5($password) !== $profile['password']) {
            $this->flash('error', 'Incorrect password.');
            $this->redirect('/settings/delete-account');
            return;
        }

        // Soft delete - mark as deleted instead of removing
        $this->db->update(
            "UPDATE register SET 
                status = 'DELETED', 
                deletion_reason = ?,
                deleted_at = NOW() 
             WHERE matri_id = ?",
            [$reason, $user['matri_id']]
        );

        // Log out
        $this->authService->logout();

        $this->flash('success', 'Your account has been deleted. We\'re sorry to see you go.');
        $this->redirect('/');
    }

    /**
     * Hide profile temporarily
     */
    public function hideProfile(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $user = $this->session->getUser();
        $hideUntil = $this->getPost('hide_until');

        $this->db->update(
            "UPDATE register SET 
                status = 'HIDDEN', 
                hidden_until = ?,
                updated_at = NOW() 
             WHERE matri_id = ?",
            [$hideUntil, $user['matri_id']]
        );

        $this->flash('success', 'Your profile is now hidden.');
        $this->redirect('/settings/privacy');
    }

    /**
     * Unhide profile
     */
    public function unhideProfile(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $user = $this->session->getUser();

        $this->db->update(
            "UPDATE register SET 
                status = 'APPROVED', 
                hidden_until = NULL,
                updated_at = NOW() 
             WHERE matri_id = ?",
            [$user['matri_id']]
        );

        $this->flash('success', 'Your profile is now visible again.');
        $this->redirect('/settings/privacy');
    }
}
