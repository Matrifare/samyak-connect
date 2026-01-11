<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class SearchController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Search page
     */
    public function index(): void
    {
        $this->render('search/index', [
            'title' => 'Search Profiles - Samyak Matrimony',
            'meta_description' => 'Search Buddhist matrimonial profiles on Samyak Matrimony'
        ]);
    }

    /**
     * Search results
     */
    public function search(): void
    {
        $criteria = [
            'gender' => Validator::sanitizeString($_GET['gender'] ?? ''),
            'age_from' => (int)($_GET['age_from'] ?? 18),
            'age_to' => (int)($_GET['age_to'] ?? 60),
            'caste' => Validator::sanitizeString($_GET['caste'] ?? ''),
            'marital_status' => Validator::sanitizeString($_GET['marital_status'] ?? ''),
            'education' => Validator::sanitizeString($_GET['education'] ?? ''),
            'occupation' => Validator::sanitizeString($_GET['occupation'] ?? ''),
            'city' => Validator::sanitizeString($_GET['city'] ?? ''),
            'state' => Validator::sanitizeString($_GET['state'] ?? ''),
            'country' => Validator::sanitizeString($_GET['country'] ?? '')
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        // Get current user's gender to exclude same gender profiles
        $excludeGender = null;
        if (Session::isLoggedIn()) {
            $excludeGender = Session::get('user_gender');
        }

        $results = $this->userModel->search($criteria, $perPage, $offset, $excludeGender);
        $totalResults = $this->userModel->searchCount($criteria, $excludeGender);
        $totalPages = ceil($totalResults / $perPage);

        $this->render('search/results', [
            'title' => 'Search Results - Samyak Matrimony',
            'results' => $results,
            'criteria' => $criteria,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalResults' => $totalResults
        ]);
    }

    /**
     * Quick search (from homepage)
     */
    public function quickSearch(): void
    {
        $gender = Validator::sanitizeString($_GET['looking_for'] ?? '');
        $ageFrom = (int)($_GET['age_from'] ?? 18);
        $ageTo = (int)($_GET['age_to'] ?? 60);
        $caste = Validator::sanitizeString($_GET['caste'] ?? '');

        $queryParams = http_build_query([
            'gender' => $gender,
            'age_from' => $ageFrom,
            'age_to' => $ageTo,
            'caste' => $caste
        ]);

        $this->redirect('/search/results?' . $queryParams);
    }

    /**
     * Profile ID search
     */
    public function searchByProfileId(): void
    {
        $profileId = Validator::sanitizeString($_GET['profile_id'] ?? '');

        if (empty($profileId)) {
            Session::setFlash('error', 'Please enter a Profile ID.');
            $this->redirect('/search');
            return;
        }

        $profile = $this->userModel->findByProfileId($profileId);

        if ($profile) {
            $this->redirect('/profile/' . $profile['profile_id']);
        } else {
            Session::setFlash('error', 'Profile not found with ID: ' . htmlspecialchars($profileId));
            $this->redirect('/search');
        }
    }

    /**
     * Advanced search page
     */
    public function advancedSearch(): void
    {
        $this->render('search/advanced', [
            'title' => 'Advanced Search - Samyak Matrimony'
        ]);
    }
}
