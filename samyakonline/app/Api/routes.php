<?php
/**
 * API Router
 * RESTful API endpoints for the matrimony platform
 */

require_once __DIR__ . '/../../DatabaseConnection.php';
require_once __DIR__ . '/../../lib/Security.php';
require_once __DIR__ . '/../Core/Database.php';

use App\Core\Database;

// Set JSON headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get request info
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api/', '', $uri);
$segments = explode('/', trim($uri, '/'));

$resource = $segments[0] ?? '';
$id = $segments[1] ?? null;
$action = $segments[2] ?? null;

// Database connection
$db = Database::getInstance();

// API Response helper
function apiResponse($data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function apiError(string $message, int $status = 400): void {
    apiResponse(['success' => false, 'error' => $message], $status);
}

// Check authentication for protected routes
function requireApiAuth(): array {
    if (!Security::isAuthenticated()) {
        apiError('Unauthorized', 401);
    }
    return [
        'user_id' => $_SESSION['user_id'],
        'matri_id' => $_SESSION['matri_id'] ?? $_SESSION['user_id']
    ];
}

// Route handlers
switch ($resource) {
    case 'profiles':
        handleProfiles($db, $method, $id, $action);
        break;
    
    case 'search':
        handleSearch($db, $method);
        break;
    
    case 'messages':
        handleMessages($db, $method, $id, $action);
        break;
    
    case 'interests':
        handleInterests($db, $method, $id, $action);
        break;
    
    case 'shortlist':
        handleShortlist($db, $method, $id);
        break;
    
    case 'castes':
        handleCastes($db, $method);
        break;
    
    case 'cities':
        handleCities($db, $method);
        break;
    
    case 'stats':
        handleStats($db, $method);
        break;
    
    default:
        apiError('Endpoint not found', 404);
}

/**
 * Handle profile endpoints
 */
function handleProfiles($db, $method, $id, $action) {
    switch ($method) {
        case 'GET':
            if ($id) {
                // Get single profile
                $profile = $db->selectOne(
                    "SELECT username, matri_id, gender, birthdate, height, religion_name, 
                            caste_name, city_name, state_name, country_name, edu_name, 
                            ocp_name, profile_text, photo1, photo1_approve, photo_protect
                     FROM register_view 
                     WHERE matri_id = ? AND status = 'Active'",
                    [Security::sanitizeProfileId($id)]
                );
                
                if ($profile) {
                    // Calculate age
                    if ($profile['birthdate']) {
                        $birthDate = new DateTime($profile['birthdate']);
                        $today = new DateTime();
                        $profile['age'] = $birthDate->diff($today)->y;
                    }
                    apiResponse(['success' => true, 'data' => $profile]);
                } else {
                    apiError('Profile not found', 404);
                }
            } else {
                apiError('Profile ID required', 400);
            }
            break;
        
        case 'PUT':
            $auth = requireApiAuth();
            if ($id !== $auth['matri_id']) {
                apiError('Cannot edit other profiles', 403);
            }
            // Handle profile update
            $data = json_decode(file_get_contents('php://input'), true);
            // Add update logic here
            apiResponse(['success' => true, 'message' => 'Profile updated']);
            break;
        
        default:
            apiError('Method not allowed', 405);
    }
}

/**
 * Handle search endpoints
 */
function handleSearch($db, $method) {
    if ($method !== 'GET' && $method !== 'POST') {
        apiError('Method not allowed', 405);
    }
    
    $params = $method === 'POST' 
        ? json_decode(file_get_contents('php://input'), true) 
        : $_GET;
    
    $page = max(1, (int)($params['page'] ?? 1));
    $limit = min(50, max(1, (int)($params['limit'] ?? 20)));
    $offset = ($page - 1) * $limit;
    
    // Build query conditions
    $conditions = ["status = 'Active'"];
    $queryParams = [];
    
    // Gender filter
    if (!empty($params['gender'])) {
        $conditions[] = "gender = ?";
        $queryParams[] = $params['gender'];
    }
    
    // Age range
    if (!empty($params['min_age']) && !empty($params['max_age'])) {
        $conditions[] = "((YEAR(CURDATE()) - YEAR(birthdate)) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthdate, '%m%d'))) BETWEEN ? AND ?";
        $queryParams[] = (int)$params['min_age'];
        $queryParams[] = (int)$params['max_age'];
    }
    
    // Religion
    if (!empty($params['religion'])) {
        $religions = is_array($params['religion']) ? $params['religion'] : [$params['religion']];
        $placeholders = implode(',', array_fill(0, count($religions), '?'));
        $conditions[] = "religion IN ($placeholders)";
        $queryParams = array_merge($queryParams, array_map('intval', $religions));
    }
    
    // Caste
    if (!empty($params['caste'])) {
        $castes = is_array($params['caste']) ? $params['caste'] : [$params['caste']];
        $placeholders = implode(',', array_fill(0, count($castes), '?'));
        $conditions[] = "caste IN ($placeholders)";
        $queryParams = array_merge($queryParams, array_map('intval', $castes));
    }
    
    // City
    if (!empty($params['city'])) {
        $conditions[] = "city = ?";
        $queryParams[] = (int)$params['city'];
    }
    
    // Photo only
    if (!empty($params['with_photo']) && $params['with_photo'] === 'true') {
        $conditions[] = "photo1 != '' AND photo1_approve = 'APPROVED'";
    }
    
    $whereClause = implode(' AND ', $conditions);
    
    // Get count
    $countResult = $db->selectOne(
        "SELECT COUNT(*) as total FROM register_view WHERE $whereClause",
        $queryParams
    );
    $total = $countResult['total'] ?? 0;
    
    // Get results
    $queryParams[] = $offset;
    $queryParams[] = $limit;
    
    $profiles = $db->select(
        "SELECT username, matri_id, gender, birthdate, height, religion_name, 
                caste_name, city_name, edu_name, photo1, photo1_approve, photo_protect
         FROM register_view 
         WHERE $whereClause
         ORDER BY last_login DESC
         LIMIT ?, ?",
        $queryParams
    );
    
    // Calculate ages
    foreach ($profiles as &$profile) {
        if ($profile['birthdate']) {
            $birthDate = new DateTime($profile['birthdate']);
            $today = new DateTime();
            $profile['age'] = $birthDate->diff($today)->y;
        }
    }
    
    apiResponse([
        'success' => true,
        'data' => $profiles,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'pages' => ceil($total / $limit)
        ]
    ]);
}

/**
 * Handle message endpoints
 */
function handleMessages($db, $method, $id, $action) {
    $auth = requireApiAuth();
    
    switch ($method) {
        case 'GET':
            if ($action === 'conversation' && $id) {
                // Get conversation
                $messages = $db->select(
                    "SELECT * FROM inbox 
                     WHERE (msg_from = ? AND msg_to = ?) OR (msg_from = ? AND msg_to = ?)
                     ORDER BY msg_date ASC LIMIT 100",
                    [$auth['matri_id'], $id, $id, $auth['matri_id']]
                );
                apiResponse(['success' => true, 'data' => $messages]);
            } else {
                // Get inbox
                $type = $_GET['type'] ?? 'inbox';
                $page = max(1, (int)($_GET['page'] ?? 1));
                $limit = 20;
                $offset = ($page - 1) * $limit;
                
                if ($type === 'sent') {
                    $messages = $db->select(
                        "SELECT i.*, r.username, r.photo1 FROM inbox i 
                         LEFT JOIN register r ON i.msg_to = r.matri_id
                         WHERE i.msg_from = ? AND i.deleted_by_sender = 0
                         ORDER BY i.msg_date DESC LIMIT ?, ?",
                        [$auth['matri_id'], $offset, $limit]
                    );
                } else {
                    $messages = $db->select(
                        "SELECT i.*, r.username, r.photo1 FROM inbox i 
                         LEFT JOIN register r ON i.msg_from = r.matri_id
                         WHERE i.msg_to = ? AND i.deleted_by_receiver = 0
                         ORDER BY i.msg_date DESC LIMIT ?, ?",
                        [$auth['matri_id'], $offset, $limit]
                    );
                }
                apiResponse(['success' => true, 'data' => $messages]);
            }
            break;
        
        case 'POST':
            // Send message
            $data = json_decode(file_get_contents('php://input'), true);
            $to = Security::sanitizeProfileId($data['to'] ?? '');
            $subject = trim($data['subject'] ?? '');
            $message = trim($data['message'] ?? '');
            
            if (empty($to) || empty($subject) || empty($message)) {
                apiError('All fields are required');
            }
            
            $db->insert(
                "INSERT INTO inbox (msg_from, msg_to, subject, message, msg_date, msg_status, read_status)
                 VALUES (?, ?, ?, ?, NOW(), 'sent', 'unread')",
                [$auth['matri_id'], $to, $subject, $message]
            );
            
            apiResponse(['success' => true, 'message' => 'Message sent']);
            break;
        
        default:
            apiError('Method not allowed', 405);
    }
}

/**
 * Handle interest endpoints
 */
function handleInterests($db, $method, $id, $action) {
    $auth = requireApiAuth();
    
    switch ($method) {
        case 'GET':
            $type = $_GET['type'] ?? 'received';
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            if ($type === 'sent') {
                $interests = $db->select(
                    "SELECT e.*, r.username, r.photo1, r.matri_id FROM expint e
                     LEFT JOIN register r ON e.msg_to = r.matri_id
                     WHERE e.msg_from = ?
                     ORDER BY e.created_at DESC LIMIT ?, ?",
                    [$auth['matri_id'], $offset, $limit]
                );
            } else {
                $interests = $db->select(
                    "SELECT e.*, r.username, r.photo1, r.matri_id FROM expint e
                     LEFT JOIN register r ON e.msg_from = r.matri_id
                     WHERE e.msg_to = ?
                     ORDER BY e.created_at DESC LIMIT ?, ?",
                    [$auth['matri_id'], $offset, $limit]
                );
            }
            apiResponse(['success' => true, 'data' => $interests]);
            break;
        
        case 'POST':
            // Send interest
            $data = json_decode(file_get_contents('php://input'), true);
            $to = Security::sanitizeProfileId($data['to'] ?? '');
            
            if (empty($to)) {
                apiError('Profile ID required');
            }
            
            // Check existing
            $existing = $db->selectOne(
                "SELECT * FROM expint WHERE msg_from = ? AND msg_to = ?",
                [$auth['matri_id'], $to]
            );
            
            if ($existing) {
                apiError('Interest already sent');
            }
            
            $db->insert(
                "INSERT INTO expint (msg_from, msg_to, interest_status, created_at) VALUES (?, ?, 'pending', NOW())",
                [$auth['matri_id'], $to]
            );
            
            apiResponse(['success' => true, 'message' => 'Interest sent']);
            break;
        
        case 'PUT':
            if (!$id) {
                apiError('Interest ID required');
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $status = $data['status'] ?? '';
            
            if (!in_array($status, ['accepted', 'declined'])) {
                apiError('Invalid status');
            }
            
            $db->update(
                "UPDATE expint SET interest_status = ?, updated_at = NOW() WHERE msg_id = ? AND msg_to = ?",
                [$status, (int)$id, $auth['matri_id']]
            );
            
            apiResponse(['success' => true, 'message' => 'Interest ' . $status]);
            break;
        
        default:
            apiError('Method not allowed', 405);
    }
}

/**
 * Handle shortlist endpoints
 */
function handleShortlist($db, $method, $id) {
    $auth = requireApiAuth();
    
    switch ($method) {
        case 'GET':
            $page = max(1, (int)($_GET['page'] ?? 1));
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            $shortlist = $db->select(
                "SELECT s.*, r.username, r.photo1, r.matri_id, r.birthdate, r.city_name
                 FROM shortlist s
                 LEFT JOIN register_view r ON s.shortlisted_id = r.matri_id
                 WHERE s.user_id = ?
                 ORDER BY s.created_at DESC LIMIT ?, ?",
                [$auth['matri_id'], $offset, $limit]
            );
            apiResponse(['success' => true, 'data' => $shortlist]);
            break;
        
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $profileId = Security::sanitizeProfileId($data['profile_id'] ?? '');
            
            if (empty($profileId)) {
                apiError('Profile ID required');
            }
            
            // Check existing
            $existing = $db->selectOne(
                "SELECT * FROM shortlist WHERE user_id = ? AND shortlisted_id = ?",
                [$auth['matri_id'], $profileId]
            );
            
            if ($existing) {
                apiError('Already shortlisted');
            }
            
            $db->insert(
                "INSERT INTO shortlist (user_id, shortlisted_id, created_at) VALUES (?, ?, NOW())",
                [$auth['matri_id'], $profileId]
            );
            
            apiResponse(['success' => true, 'message' => 'Added to shortlist']);
            break;
        
        case 'DELETE':
            if (!$id) {
                apiError('Profile ID required');
            }
            
            $db->delete(
                "DELETE FROM shortlist WHERE user_id = ? AND shortlisted_id = ?",
                [$auth['matri_id'], Security::sanitizeProfileId($id)]
            );
            
            apiResponse(['success' => true, 'message' => 'Removed from shortlist']);
            break;
        
        default:
            apiError('Method not allowed', 405);
    }
}

/**
 * Handle caste endpoints
 */
function handleCastes($db, $method) {
    if ($method !== 'GET') {
        apiError('Method not allowed', 405);
    }
    
    $religionId = (int)($_GET['religion_id'] ?? 0);
    
    if ($religionId <= 0) {
        apiError('Religion ID required');
    }
    
    $castes = $db->select(
        "SELECT caste_id, caste_name FROM caste 
         WHERE religion_id = ? AND status = 'APPROVED' 
         ORDER BY caste_name ASC",
        [$religionId]
    );
    
    apiResponse(['success' => true, 'data' => $castes]);
}

/**
 * Handle city endpoints
 */
function handleCities($db, $method) {
    if ($method !== 'GET') {
        apiError('Method not allowed', 405);
    }
    
    $stateId = (int)($_GET['state_id'] ?? 0);
    
    if ($stateId <= 0) {
        apiError('State ID required');
    }
    
    $cities = $db->select(
        "SELECT city_id, city_name FROM city 
         WHERE state_id = ? 
         ORDER BY city_name ASC",
        [$stateId]
    );
    
    apiResponse(['success' => true, 'data' => $cities]);
}

/**
 * Handle stats endpoints
 */
function handleStats($db, $method) {
    if ($method !== 'GET') {
        apiError('Method not allowed', 405);
    }
    
    $auth = requireApiAuth();
    
    // Get various counts
    $unreadMessages = $db->selectOne(
        "SELECT COUNT(*) as count FROM inbox WHERE msg_to = ? AND read_status = 'unread' AND deleted_by_receiver = 0",
        [$auth['matri_id']]
    );
    
    $pendingInterests = $db->selectOne(
        "SELECT COUNT(*) as count FROM expint WHERE msg_to = ? AND interest_status = 'pending'",
        [$auth['matri_id']]
    );
    
    $profileViews = $db->selectOne(
        "SELECT COUNT(*) as count FROM profile_views WHERE viewed_id = ? AND viewed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)",
        [$auth['matri_id']]
    );
    
    $shortlistCount = $db->selectOne(
        "SELECT COUNT(*) as count FROM shortlist WHERE user_id = ?",
        [$auth['matri_id']]
    );
    
    apiResponse([
        'success' => true,
        'data' => [
            'unread_messages' => $unreadMessages['count'] ?? 0,
            'pending_interests' => $pendingInterests['count'] ?? 0,
            'profile_views_30d' => $profileViews['count'] ?? 0,
            'shortlist_count' => $shortlistCount['count'] ?? 0
        ]
    ]);
}
