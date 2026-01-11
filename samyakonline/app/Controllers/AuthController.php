<?php
/**
 * Authentication Controller
 * Handles login, logout, registration, and password reset
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\User;
use App\Services\MailService;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->userModel = new User();
    }

    /**
     * Show login page
     */
    public function login(): void
    {
        // Redirect if already logged in
        if ($this->isAuthenticated()) {
            $this->redirect('/homepage');
        }

        $this->render('auth/login', [
            'title' => 'Login - Samyak Matrimony',
            'error' => $this->session->getFlash('error'),
            'success' => $this->session->getFlash('success')
        ]);
    }

    /**
     * Process login
     */
    public function authenticate(): void
    {
        // Validate CSRF
        $this->requireCsrf();

        $username = $this->getPost('username');
        $password = $this->getPost('password');
        $keepLogin = $this->getPost('keep_login');

        // Validate input
        $validator = new Validator([
            'username' => $username,
            'password' => $password
        ]);

        $validator
            ->required('username', 'Profile ID or Email is required')
            ->required('password', 'Password is required');

        if ($validator->fails()) {
            $this->session->setFlash('error', $validator->getAllErrors()[0]);
            $this->redirect('/login');
        }

        // Check if user is blocked
        $blocked = $this->userModel->isBlocked($username);
        if ($blocked) {
            $this->session->set('profile_suspended_id', $blocked['matri_id']);
            $this->redirect('/profile_blocked');
        }

        // Find user
        $user = $this->userModel->findForLogin($username);

        if (!$user) {
            $this->logFailedLogin($username);
            $this->session->setFlash('error', 'Invalid username or password');
            $this->redirect('/login');
        }

        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            $this->logFailedLogin($username);
            $this->session->setFlash('error', 'Invalid username or password');
            $this->redirect('/login');
        }

        // Upgrade legacy MD5 password to modern hash
        if (strlen($user['password']) === 32 && ctype_xdigit($user['password'])) {
            $this->userModel->upgradeLegacyPassword($user['matri_id'], $password);
        }

        // Check account status
        if ($user['status'] === 'SUSPENDED') {
            $this->session->set('profile_suspended_id', $user['matri_id']);
            $this->redirect('/profile_suspended');
        }

        if ($user['status'] === 'DELETED') {
            $this->session->set('profile_deleted_id', $user['matri_id']);
            $this->redirect('/profile_deleted');
        }

        // Regenerate session ID for security
        $this->session->regenerate();

        // Store user in session
        $this->session->set('user', [
            'matri_id' => $user['matri_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'gender' => $user['gender'],
            'photo1' => $user['photo1'],
            'status' => $user['status']
        ]);

        // Update last login
        $this->userModel->updateLastLogin($user['matri_id']);

        // Handle remember me
        if ($keepLogin) {
            $this->setRememberToken($user['matri_id']);
        }

        // Check for redirect after login
        $redirectTo = $this->session->get('redirect_after_login', '/homepage');
        $this->session->remove('redirect_after_login');

        $this->redirect($redirectTo);
    }

    /**
     * Show registration page
     */
    public function register(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/homepage');
        }

        // Get form data for dropdowns
        $religions = $this->db->select("SELECT * FROM religion WHERE status = 'APPROVED' ORDER BY religion_name");
        $cities = $this->db->select("SELECT * FROM cities ORDER BY city_name");
        $states = $this->db->select("SELECT * FROM state ORDER BY state_name");

        $this->render('auth/register', [
            'title' => 'Register - Samyak Matrimony',
            'religions' => $religions,
            'cities' => $cities,
            'states' => $states,
            'errors' => $this->session->getFlash('errors') ?? [],
            'old' => $this->session->getFlash('old') ?? []
        ]);
    }

    /**
     * Process registration
     */
    public function store(): void
    {
        $this->requireCsrf();

        $data = [
            'full_name' => $this->getPost('full_name'),
            'email' => $this->getPost('email'),
            'mobile' => $this->getPost('mobile_no'),
            'password' => $this->getPost('password'),
            'gender' => $this->getPost('gender'),
            'day' => $this->getPost('day'),
            'month' => $this->getPost('month'),
            'year' => $this->getPost('year'),
            'height' => $this->getPost('height'),
            'complexion' => $this->getPost('complexion'),
            'religion_id' => $this->getPost('religion'),
            'caste_id' => $this->getPost('caste'),
            'm_status' => $this->getPost('m_status'),
            'education' => $this->getPost('education'),
            'occupation' => $this->getPost('occupation'),
            'city' => $this->getPost('city'),
            'state' => $this->getPost('state')
        ];

        // Validate
        $validator = new Validator($data);
        $validator
            ->required('full_name', 'Name is required')
            ->maxLength('full_name', 100, 'Name is too long')
            ->required('email', 'Email is required')
            ->email('email', 'Invalid email address')
            ->required('mobile', 'Mobile number is required')
            ->mobile('mobile', 'Invalid mobile number')
            ->required('password', 'Password is required')
            ->minLength('password', 8, 'Password must be at least 8 characters')
            ->required('gender', 'Gender is required')
            ->in('gender', ['Bride', 'Groom'], 'Invalid gender')
            ->required('day', 'Birth date is required')
            ->required('month', 'Birth month is required')
            ->required('year', 'Birth year is required')
            ->required('religion_id', 'Religion is required')
            ->required('caste_id', 'Caste is required');

        // Check unique email
        if ($this->userModel->emailExists($data['email'])) {
            $validator->custom('email', fn() => false, 'Email already registered');
        }

        // Check unique mobile
        if ($this->userModel->mobileExists($data['mobile'])) {
            $validator->custom('mobile', fn() => false, 'Mobile number already registered');
        }

        if ($validator->fails()) {
            $this->session->setFlash('errors', $validator->getErrors());
            $this->session->setFlash('old', $data);
            $this->redirect('/register');
        }

        // Prepare user data
        $birthdate = "{$data['year']}-{$data['month']}-{$data['day']}";
        
        // Validate age (must be 18+)
        $age = (new \DateTime())->diff(new \DateTime($birthdate))->y;
        if ($age < 18) {
            $this->session->setFlash('errors', ['birthdate' => ['Must be at least 18 years old']]);
            $this->session->setFlash('old', $data);
            $this->redirect('/register');
        }

        $userData = [
            'username' => $data['full_name'],
            'email' => strtolower($data['email']),
            'mobile' => preg_replace('/[^0-9]/', '', $data['mobile']),
            'password' => $data['password'],
            'gender' => $data['gender'],
            'birthdate' => $birthdate,
            'height' => $data['height'],
            'complexion' => $data['complexion'],
            'religion_id' => $data['religion_id'],
            'caste_id' => $data['caste_id'],
            'm_status' => $data['m_status'],
            'education' => $data['education'],
            'occupation' => $data['occupation'],
            'city' => $data['city'],
            'state' => $data['state'],
            'status' => 'PENDING'
        ];

        try {
            $matriId = $this->userModel->createUser($userData);

            // Send welcome email
            $this->sendWelcomeEmail($matriId, $userData);

            $this->session->setFlash('success', "Registration successful! Your Profile ID is: {$matriId}");
            $this->redirect('/login');

        } catch (\Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            $this->session->setFlash('errors', ['general' => ['Registration failed. Please try again.']]);
            $this->session->setFlash('old', $data);
            $this->redirect('/register');
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        // Clear remember token
        $this->clearRememberToken();

        // Destroy session
        $this->session->destroy();

        $this->redirect('/');
    }

    /**
     * Show forgot password page
     */
    public function forgotPassword(): void
    {
        $this->render('auth/forgot-password', [
            'title' => 'Forgot Password - Samyak Matrimony',
            'error' => $this->session->getFlash('error'),
            'success' => $this->session->getFlash('success')
        ]);
    }

    /**
     * Process forgot password
     */
    public function sendResetLink(): void
    {
        $this->requireCsrf();

        $email = $this->getPost('email');

        $validator = new Validator(['email' => $email]);
        $validator->required('email')->email('email');

        if ($validator->fails()) {
            $this->session->setFlash('error', 'Please enter a valid email address');
            $this->redirect('/forgot-password');
        }

        $user = $this->userModel->findByEmail($email);

        // Don't reveal if email exists
        $this->session->setFlash('success', 'If the email exists, you will receive password reset instructions.');

        if ($user) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store token
            $this->db->execute(
                "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE token = ?, expires_at = ?",
                [$email, hash('sha256', $token), $expiry, hash('sha256', $token), $expiry]
            );

            // Send email
            $this->sendPasswordResetEmail($user, $token);
        }

        $this->redirect('/forgot-password');
    }

    /**
     * Log failed login attempt
     */
    private function logFailedLogin(string $identifier): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->db->insert(
            "INSERT INTO login_attempts (identifier, ip_address, attempted_at) VALUES (?, ?, NOW())",
            [$identifier, $ip]
        );
    }

    /**
     * Set remember me token
     */
    private function setRememberToken(string $matriId): void
    {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);
        $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

        $this->db->execute(
            "INSERT INTO remember_tokens (matri_id, token, expires_at) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE token = ?, expires_at = ?",
            [$matriId, $hashedToken, $expiry, $hashedToken, $expiry]
        );

        setcookie('remember_token', $token, [
            'expires' => strtotime('+30 days'),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    /**
     * Clear remember token
     */
    private function clearRememberToken(): void
    {
        if (isset($_COOKIE['remember_token'])) {
            $hashedToken = hash('sha256', $_COOKIE['remember_token']);
            $this->db->delete("DELETE FROM remember_tokens WHERE token = ?", [$hashedToken]);

            setcookie('remember_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }
    }

    /**
     * Send welcome email
     */
    private function sendWelcomeEmail(string $matriId, array $userData): void
    {
        // Implement email sending logic
    }

    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail(array $user, string $token): void
    {
        // Implement email sending logic
    }
}
