<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Security;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login page
     */
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/login', [
            'title' => 'Login - Samyak Matrimony',
            'meta_description' => 'Login to your Samyak Matrimony account'
        ]);
    }

    /**
     * Process login
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request. Please try again.');
            $this->redirect('/login');
            return;
        }

        $email = Validator::sanitizeEmail($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate inputs
        $errors = [];
        if (!Validator::isValidEmail($email)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (empty($password)) {
            $errors[] = 'Password is required.';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirect('/login');
            return;
        }

        // Find user by email
        $user = $this->userModel->findByEmail($email);
        
        if (!$user) {
            Session::setFlash('error', 'Invalid email or password.');
            $this->redirect('/login');
            return;
        }

        // Verify password (support both MD5 legacy and new Argon2ID)
        $passwordValid = false;
        if (Security::verifyPassword($password, $user['password'])) {
            $passwordValid = true;
        } elseif (md5($password) === $user['password']) {
            // Legacy MD5 password - upgrade to Argon2ID
            $passwordValid = true;
            $this->userModel->updatePassword($user['id'], Security::hashPassword($password));
        }

        if (!$passwordValid) {
            Session::setFlash('error', 'Invalid email or password.');
            $this->redirect('/login');
            return;
        }

        // Check if account is active
        if (isset($user['status']) && $user['status'] !== 'active') {
            Session::setFlash('error', 'Your account is not active. Please contact support.');
            $this->redirect('/login');
            return;
        }

        // Login successful
        Session::login($user['id'], [
            'name' => $user['name'] ?? '',
            'email' => $user['email'],
            'profile_id' => $user['profile_id'] ?? $user['id'],
            'gender' => $user['gender'] ?? '',
            'photo' => $user['photo'] ?? ''
        ]);

        // Update last login
        $this->userModel->updateLastLogin($user['id']);

        Session::setFlash('success', 'Welcome back!');
        $this->redirect('/dashboard');
    }

    /**
     * Show registration page
     */
    public function showRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->render('auth/register', [
            'title' => 'Register - Samyak Matrimony',
            'meta_description' => 'Create your free account on Samyak Matrimony'
        ]);
    }

    /**
     * Process registration
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }

        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request. Please try again.');
            $this->redirect('/register');
            return;
        }

        // Sanitize inputs
        $data = [
            'name' => Validator::sanitizeString($_POST['name'] ?? ''),
            'email' => Validator::sanitizeEmail($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'gender' => Validator::sanitizeString($_POST['gender'] ?? ''),
            'dob' => Validator::sanitizeString($_POST['dob'] ?? ''),
            'mobile' => Validator::sanitizeString($_POST['mobile'] ?? ''),
            'religion' => 'Buddhist',
            'caste' => Validator::sanitizeString($_POST['caste'] ?? ''),
            'profile_for' => Validator::sanitizeString($_POST['profile_for'] ?? 'self')
        ];

        // Validate
        $errors = [];
        
        if (!Validator::isValidLength($data['name'], 2, 100)) {
            $errors[] = 'Name must be between 2 and 100 characters.';
        }
        if (!Validator::isValidEmail($data['email'])) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (!Validator::isStrongPassword($data['password'])) {
            $errors[] = 'Password must be at least 8 characters with uppercase, lowercase, and number.';
        }
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Passwords do not match.';
        }
        if (!in_array($data['gender'], ['Male', 'Female'])) {
            $errors[] = 'Please select a valid gender.';
        }
        if (!Validator::isValidDate($data['dob'])) {
            $errors[] = 'Please enter a valid date of birth.';
        }
        if (!Validator::isValidPhone($data['mobile'])) {
            $errors[] = 'Please enter a valid mobile number.';
        }

        // Check if email already exists
        if ($this->userModel->findByEmail($data['email'])) {
            $errors[] = 'This email is already registered.';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            Session::set('form_data', $data);
            $this->redirect('/register');
            return;
        }

        // Generate profile ID
        $prefix = $data['gender'] === 'Male' ? 'SM' : 'SF';
        $data['profile_id'] = $this->userModel->generateProfileId($prefix);

        // Hash password
        $data['password'] = Security::hashPassword($data['password']);
        unset($data['confirm_password']);

        // Create user
        $userId = $this->userModel->create($data);

        if ($userId) {
            Session::remove('form_data');
            Session::setFlash('success', 'Registration successful! Your Profile ID is: ' . $data['profile_id'] . '. Please login to continue.');
            $this->redirect('/login');
        } else {
            Session::setFlash('error', 'Registration failed. Please try again.');
            $this->redirect('/register');
        }
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        Session::logout();
        Session::setFlash('success', 'You have been logged out successfully.');
        $this->redirect('/');
    }

    /**
     * Show forgot password page
     */
    public function showForgotPassword(): void
    {
        $this->render('auth/forgot-password', [
            'title' => 'Forgot Password - Samyak Matrimony'
        ]);
    }

    /**
     * Process forgot password
     */
    public function forgotPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/forgot-password');
            return;
        }

        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request. Please try again.');
            $this->redirect('/forgot-password');
            return;
        }

        $email = Validator::sanitizeEmail($_POST['email'] ?? '');

        if (!Validator::isValidEmail($email)) {
            Session::setFlash('error', 'Please enter a valid email address.');
            $this->redirect('/forgot-password');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        // Always show success message (security - don't reveal if email exists)
        Session::setFlash('success', 'If this email is registered, you will receive password reset instructions.');
        
        if ($user) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $this->userModel->setPasswordResetToken($user['id'], $token);
            
            // TODO: Send email with reset link
            // For now, we'll just set a message
        }

        $this->redirect('/forgot-password');
    }
}
