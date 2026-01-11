<?php
/**
 * Search Controller
 * Handles profile search functionality
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class SearchController extends Controller
{
    private User $userModel;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->userModel = new User();
    }

    /**
     * Search page
     */
    public function index(): void
    {
        // Get filter options
        $religions = $this->db->select("SELECT * FROM religion WHERE status = 'APPROVED' ORDER BY religion_name");
        $cities = $this->db->select("SELECT * FROM cities ORDER BY city_name");
        $educationFields = $this->db->select("SELECT * FROM education_field ORDER BY field_name");

        $this->render('search/index', [
            'title' => 'Search Profiles - Samyak Matrimony',
            'religions' => $religions,
            'cities' => $cities,
            'educationFields' => $educationFields
        ]);
    }

    /**
     * Search results
     */
    public function results(): void
    {
        $filters = [
            'gender' => $this->getQuery('gender') ?: $this->getPost('gender'),
            'age_from' => $this->getQuery('age_from') ?: $this->getPost('age_from'),
            'age_to' => $this->getQuery('age_to') ?: $this->getPost('age_to'),
            'religion' => $this->getQuery('religion') ?: $this->getPost('religion'),
            'm_status' => $this->getQuery('m_status') ?: $this->getPost('m_status'),
            'education_field' => $this->getQuery('education_field') ?: $this->getPost('education_field'),
            'city' => $this->getQuery('city') ?: $this->getPost('city')
        ];

        // Clean empty filters
        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '' && $v !== []);

        $page = max(1, (int) ($this->getQuery('page') ?? 1));
        $perPage = 20;

        // Perform search
        $results = $this->userModel->search($filters, $page, $perPage);

        // Get filter options for sidebar
        $religions = $this->db->select("SELECT * FROM religion WHERE status = 'APPROVED' ORDER BY religion_name");
        $cities = $this->db->select("SELECT * FROM cities ORDER BY city_name");

        $this->render('search/results', [
            'title' => 'Search Results - Samyak Matrimony',
            'profiles' => $results['data'],
            'pagination' => [
                'current_page' => $results['page'],
                'total_pages' => $results['total_pages'],
                'total' => $results['total'],
                'per_page' => $results['per_page']
            ],
            'filters' => $filters,
            'religions' => $religions,
            'cities' => $cities
        ]);
    }

    /**
     * Search by profile ID
     */
    public function byId(): void
    {
        $profileId = $this->getQuery('id') ?: $this->getPost('profile_id');

        if (empty($profileId)) {
            $this->flash('error', 'Please enter a Profile ID');
            $this->redirect('/search');
        }

        // Clean and format profile ID
        $profileId = strtoupper(trim($profileId));

        $profile = $this->userModel->findByMatriId($profileId);

        if (!$profile) {
            // Try samyak_id
            $profile = $this->userModel->findBySamyakId($profileId);
        }

        if ($profile && $profile['status'] === 'APPROVED') {
            $this->redirect("/view-profile/{$profile['matri_id']}");
        } else {
            $this->flash('error', 'Profile not found or not available');
            $this->redirect('/search');
        }
    }

    /**
     * Quick search (from homepage)
     */
    public function quick(): void
    {
        // Build query string from POST data
        $params = http_build_query([
            'gender' => $this->getPost('gender'),
            'age_from' => $this->getPost('age_from'),
            'age_to' => $this->getPost('age_to'),
            'religion' => $this->getPost('religion'),
            'm_status' => $this->getPost('m_status'),
            'education_field' => $this->getPost('education_field'),
            'city' => $this->getPost('city')
        ]);

        $this->redirect("/search-result?{$params}");
    }

    /**
     * Get castes by religion (AJAX)
     */
    public function getCastes(): void
    {
        $religionId = $this->getQuery('religion_id') ?: $this->getPost('religion_id');

        if (empty($religionId)) {
            $this->json(['castes' => []]);
        }

        $castes = $this->db->select(
            "SELECT caste_id, caste_name FROM caste 
             WHERE religion_id = ? AND status = 'APPROVED' 
             ORDER BY caste_name",
            [$religionId]
        );

        $this->json(['castes' => $castes]);
    }

    /**
     * Get cities by state (AJAX)
     */
    public function getCities(): void
    {
        $stateId = $this->getQuery('state_id') ?: $this->getPost('state_id');

        if (empty($stateId)) {
            $this->json(['cities' => []]);
        }

        $cities = $this->db->select(
            "SELECT id, city_name FROM cities 
             WHERE state_id = ? 
             ORDER BY city_name",
            [$stateId]
        );

        $this->json(['cities' => $cities]);
    }
}
