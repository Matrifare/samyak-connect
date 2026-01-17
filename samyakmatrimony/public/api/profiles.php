<?php
/**
 * API Endpoint for fetching profiles
 * Returns JSON data for React/JS frontend
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;

try {
    $userModel = new User();
    
    $action = $_GET['action'] ?? 'featured';
    
    switch ($action) {
        case 'featured':
            $limit = (int) ($_GET['limit'] ?? 8);
            $profiles = $userModel->getFeaturedProfiles($limit);
            echo json_encode([
                'success' => true,
                'data' => $profiles
            ]);
            break;
            
        case 'stats':
            $stats = [
                'total_profiles' => $userModel->getTotalCount(),
                'male_profiles' => $userModel->getCountByGender('Male'),
                'female_profiles' => $userModel->getCountByGender('Female'),
                'success_stories' => 150
            ];
            echo json_encode([
                'success' => true,
                'data' => $stats
            ]);
            break;
            
        case 'search':
            $filters = [
                'gender' => $_GET['gender'] ?? null,
                'age_from' => $_GET['age_from'] ?? null,
                'age_to' => $_GET['age_to'] ?? null,
                'religion' => $_GET['religion'] ?? null,
                'caste' => $_GET['caste'] ?? null,
                'city' => $_GET['city'] ?? null,
                'm_status' => $_GET['m_status'] ?? null
            ];
            $page = (int) ($_GET['page'] ?? 1);
            $perPage = (int) ($_GET['per_page'] ?? 20);
            
            $results = $userModel->search(array_filter($filters), $page, $perPage);
            echo json_encode([
                'success' => true,
                'data' => $results['data'],
                'pagination' => [
                    'total' => $results['total'],
                    'page' => $results['page'],
                    'per_page' => $results['per_page'],
                    'total_pages' => $results['total_pages']
                ]
            ]);
            break;
            
        case 'profile':
            $matriId = $_GET['id'] ?? null;
            if (!$matriId) {
                throw new Exception('Profile ID is required');
            }
            $profile = $userModel->getFullProfile($matriId);
            if (!$profile) {
                throw new Exception('Profile not found');
            }
            echo json_encode([
                'success' => true,
                'data' => $profile
            ]);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
