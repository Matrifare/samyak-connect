<?php
/**
 * Shortlist Controller
 * Handles profile shortlisting/favorites
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Shortlist;

class ShortlistController extends Controller
{
    private Shortlist $shortlistModel;

    public function __construct()
    {
        parent::__construct();
        $this->shortlistModel = new Shortlist();
    }

    /**
     * View shortlist
     */
    public function index(): void
    {
        $this->requireAuth();
        
        $page = (int)($_GET['page'] ?? 1);
        $profiles = $this->shortlistModel->getList($_SESSION['user_id'], $page);

        $this->render('shortlist/index', [
            'profiles' => $profiles,
            'currentPage' => $page,
            'pageTitle' => 'My Shortlist'
        ]);
    }

    /**
     * View who shortlisted me
     */
    public function shortlistedMe(): void
    {
        $this->requireAuth();
        
        $page = (int)($_GET['page'] ?? 1);
        $profiles = $this->shortlistModel->getWhoShortlistedMe($_SESSION['user_id'], $page);

        $this->render('shortlist/shortlisted-me', [
            'profiles' => $profiles,
            'currentPage' => $page,
            'pageTitle' => 'Who Shortlisted Me'
        ]);
    }

    /**
     * Add to shortlist
     */
    public function add(string $profileId): void
    {
        $this->requireAuth();
        
        $profileId = $this->sanitize($profileId);
        $result = $this->shortlistModel->add($_SESSION['user_id'], $profileId);

        if ($this->isAjax()) {
            $this->json($result);
            return;
        }

        if ($result['success']) {
            $this->session->flash('success', $result['message']);
        } else {
            $this->session->flash('error', $result['message']);
        }

        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'shortlist');
    }

    /**
     * Remove from shortlist
     */
    public function remove(string $profileId): void
    {
        $this->requireAuth();
        
        $profileId = $this->sanitize($profileId);
        $result = $this->shortlistModel->remove($_SESSION['user_id'], $profileId);

        if ($this->isAjax()) {
            $this->json($result);
            return;
        }

        if ($result['success']) {
            $this->session->flash('success', $result['message']);
        } else {
            $this->session->flash('error', $result['message']);
        }

        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'shortlist');
    }

    /**
     * Toggle shortlist (add/remove)
     */
    public function toggle(string $profileId): void
    {
        $this->requireAuth();
        
        $profileId = $this->sanitize($profileId);
        $result = $this->shortlistModel->toggle($_SESSION['user_id'], $profileId);
        $isShortlisted = $this->shortlistModel->isShortlisted($_SESSION['user_id'], $profileId);

        if ($this->isAjax()) {
            $this->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'isShortlisted' => $isShortlisted
            ]);
            return;
        }

        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'shortlist');
    }

    /**
     * Check if shortlisted (AJAX)
     */
    public function check(string $profileId): void
    {
        $this->requireAuth();
        
        $profileId = $this->sanitize($profileId);
        $isShortlisted = $this->shortlistModel->isShortlisted($_SESSION['user_id'], $profileId);

        $this->json(['isShortlisted' => $isShortlisted]);
    }

    /**
     * Get shortlist count (AJAX)
     */
    public function count(): void
    {
        $this->requireAuth();
        
        $count = $this->shortlistModel->getCount($_SESSION['user_id']);
        $this->json(['count' => $count]);
    }

    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
