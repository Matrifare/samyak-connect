<?php
/**
 * Authentication Service
 * Handles user authentication logic with API-ready abstraction
 * 
 * This service can be easily switched between local DB and external API
 */

namespace App\Services;

use App\Core\Database;
use App\Core\Security;
use App\Core\Session;

class AuthService
{
    private Database $db;
    private Session $session;
    private ?ApiService $api = null;
    private bool $useApi = false;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        
        // Enable this when API is ready
        // $this->enableApiMode('https://api.samyakmatrimony.com/v1');
    }

    /**
     * Enable API mode for authentication
     */
    public function enableApiMode(string $apiUrl): void
    {
        $this->useApi = true;
        $this->api = new ApiService($apiUrl);
    }

    /**
     * Attempt user login
     */
    public function login(string $identifier, string $password): array
    {
        if ($this->useApi) {
            return $this->loginViaApi($identifier, $password);
        }
        
        return $this->loginViaDatabase($identifier, $password);
    }

    /**
     * Login using local database
     */
    private function loginViaDatabase(string $identifier, string $password): array
    {
        // Find user by email, matri_id, or samyak_id
        $user = $this->db->selectOne(
            "SELECT * FROM register 
             WHERE email = ? OR matri_id = ? OR samyak_id = ?
             LIMIT 1",
            [$identifier, $identifier, $identifier]
        );

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid credentials. Please check your email/ID and password.'
            ];
        }

        // Verify password (support legacy MD5 and modern Argon2)
        $passwordValid = false;
        if (Security::verifyPassword($password, $user['password'])) {
            $passwordValid = true;
        } elseif (md5($password) === $user['password']) {
            // Upgrade legacy password
            $passwordValid = true;
            $this->upgradePassword($user['matri_id'], $password);
        }

        if (!$passwordValid) {
            return [
                'success' => false,
                'message' => 'Invalid credentials. Please check your email/ID and password.'
            ];
        }

        // Check account status
        if (isset($user['status']) && !in_array($user['status'], ['APPROVED', 'ACTIVE'])) {
            return [
                'success' => false,
                'message' => 'Your account is pending approval or suspended. Please contact support.'
            ];
        }

        // Set session
        $this->createSession($user);

        // Update last login
        $this->db->update(
            "UPDATE register SET last_login = NOW() WHERE matri_id = ?",
            [$user['matri_id']]
        );

        return [
            'success' => true,
            'message' => 'Login successful',
            'user' => $this->sanitizeUserData($user)
        ];
    }

    /**
     * Login via external API
     */
    private function loginViaApi(string $identifier, string $password): array
    {
        $response = $this->api->post('/auth/login', [
            'identifier' => $identifier,
            'password' => $password
        ]);

        if ($response['success'] && isset($response['data']['user'])) {
            $this->createSession($response['data']['user']);
            $this->session->set('api_token', $response['data']['token'] ?? '');
            
            return [
                'success' => true,
                'message' => 'Login successful',
                'user' => $response['data']['user']
            ];
        }

        return [
            'success' => false,
            'message' => $response['data']['message'] ?? 'Login failed. Please try again.'
        ];
    }

    /**
     * Register new user
     */
    public function register(array $data): array
    {
        if ($this->useApi) {
            return $this->registerViaApi($data);
        }
        
        return $this->registerViaDatabase($data);
    }

    /**
     * Register using local database
     */
    private function registerViaDatabase(array $data): array
    {
        // Check if email exists
        $existing = $this->db->selectOne(
            "SELECT matri_id FROM register WHERE email = ?",
            [$data['email']]
        );

        if ($existing) {
            return [
                'success' => false,
                'message' => 'This email is already registered. Please login or use forgot password.'
            ];
        }

        // Check if mobile exists
        if (!empty($data['mobile'])) {
            $existingMobile = $this->db->selectOne(
                "SELECT matri_id FROM register WHERE mobile = ?",
                [$data['mobile']]
            );

            if ($existingMobile) {
                return [
                    'success' => false,
                    'message' => 'This mobile number is already registered.'
                ];
            }
        }

        // Generate profile ID
        $matriId = $this->generateMatriId($data['gender'] ?? 'Male');
        
        // Hash password
        $hashedPassword = Security::hashPassword($data['password']);

        // Insert user
        try {
            $this->db->insert(
                "INSERT INTO register (
                    matri_id, email, password, mobile, username, gender, 
                    birthdate, religion_id, caste_id, status, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING', NOW())",
                [
                    $matriId,
                    $data['email'],
                    $hashedPassword,
                    $data['mobile'] ?? '',
                    $data['name'],
                    $data['gender'],
                    $data['dob'] ?? null,
                    1, // Buddhist
                    $data['caste_id'] ?? null
                ]
            );

            return [
                'success' => true,
                'message' => "Registration successful! Your Profile ID is: {$matriId}",
                'matri_id' => $matriId
            ];
        } catch (\Exception $e) {
            error_log("Registration failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ];
        }
    }

    /**
     * Register via external API
     */
    private function registerViaApi(array $data): array
    {
        $response = $this->api->post('/auth/register', $data);

        return [
            'success' => $response['success'],
            'message' => $response['data']['message'] ?? 'Registration completed.',
            'matri_id' => $response['data']['matri_id'] ?? null
        ];
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        if ($this->useApi && $this->session->get('api_token')) {
            $this->api->setAuthToken($this->session->get('api_token'));
            $this->api->post('/auth/logout');
        }
        
        $this->session->destroy();
    }

    /**
     * Request password reset
     */
    public function forgotPassword(string $email): array
    {
        if ($this->useApi) {
            $response = $this->api->post('/auth/forgot-password', ['email' => $email]);
            return [
                'success' => true,
                'message' => 'If this email is registered, you will receive reset instructions.'
            ];
        }

        $user = $this->db->selectOne(
            "SELECT matri_id FROM register WHERE email = ?",
            [$email]
        );

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $this->db->update(
                "UPDATE register SET reset_token = ?, reset_token_expiry = ? WHERE matri_id = ?",
                [$token, $expiry, $user['matri_id']]
            );

            // TODO: Send email with reset link
            // Mail::send($email, 'Password Reset', "Reset your password: {$resetLink}");
        }

        return [
            'success' => true,
            'message' => 'If this email is registered, you will receive reset instructions.'
        ];
    }

    /**
     * Create user session
     */
    private function createSession(array $user): void
    {
        $this->session->regenerate();
        $this->session->set('user', [
            'matri_id' => $user['matri_id'],
            'email' => $user['email'],
            'name' => $user['username'] ?? $user['name'] ?? '',
            'gender' => $user['gender'] ?? '',
            'photo' => $user['photo1'] ?? $user['photo'] ?? '',
            'status' => $user['status'] ?? 'ACTIVE'
        ]);
    }

    /**
     * Sanitize user data for response
     */
    private function sanitizeUserData(array $user): array
    {
        unset($user['password'], $user['photo_pswd'], $user['reset_token']);
        return $user;
    }

    /**
     * Upgrade legacy MD5 password to Argon2
     */
    private function upgradePassword(string $matriId, string $password): void
    {
        $hashedPassword = Security::hashPassword($password);
        $this->db->update(
            "UPDATE register SET password = ? WHERE matri_id = ?",
            [$hashedPassword, $matriId]
        );
    }

    /**
     * Generate unique profile ID
     */
    private function generateMatriId(string $gender): string
    {
        $prefix = ($gender === 'Female' || $gender === 'Bride') ? 'SM' : 'SMB';
        
        $result = $this->db->selectOne(
            "SELECT matri_id FROM register 
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
}
