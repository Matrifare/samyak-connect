<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Shortlist;
use App\Models\User;

class ShortlistController extends Controller
{
    private Shortlist $shortlistModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->shortlistModel = new Shortlist();
        $this->userModel = new User();
    }

    /**
     * View shortlisted profiles
     */
    public function index(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $shortlisted = $this->shortlistModel->getShortlistedProfiles($userId, $perPage, $offset);
        $totalShortlisted = $this->shortlistModel->getShortlistedCount($userId);
        $totalPages = ceil($totalShortlisted / $perPage);

        $this->render('shortlist/index', [
            'title' => 'My Shortlist - Samyak Matrimony',
            'shortlisted' => $shortlisted,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalShortlisted' => $totalShortlisted
        ]);
    }

    /**
     * View who shortlisted me
     */
    public function shortlistedBy(): void
    {
        $this->requireAuth();
        
        $userId = Session::getUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $shortlistedBy = $this->shortlistModel->getShortlistedBy($userId, $perPage, $offset);
        $totalShortlistedBy = $this->shortlistModel->getShortlistedByCount($userId);
        $totalPages = ceil($totalShortlistedBy / $perPage);

        $this->render('shortlist/shortlisted-by', [
            'title' => 'Shortlisted By - Samyak Matrimony',
            'shortlistedBy' => $shortlistedBy,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalShortlistedBy' => $totalShortlistedBy
        ]);
    }

    /**
     * Add to shortlist
     */
    public function add(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $profileId = (int)($_POST['profile_id'] ?? 0);

        if ($profileId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid profile']);
            return;
        }

        if ($profileId === $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Cannot shortlist yourself']);
            return;
        }

        // Check if already shortlisted
        if ($this->shortlistModel->isShortlisted($userId, $profileId)) {
            $this->jsonResponse(['success' => false, 'message' => 'Profile already in shortlist']);
            return;
        }

        if ($this->shortlistModel->add($userId, $profileId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Profile added to shortlist']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add to shortlist']);
        }
    }

    /**
     * Remove from shortlist
     */
    public function remove(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $profileId = (int)($_POST['profile_id'] ?? 0);

        if ($profileId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid profile']);
            return;
        }

        if ($this->shortlistModel->remove($userId, $profileId)) {
            $this->jsonResponse(['success' => true, 'message' => 'Profile removed from shortlist']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to remove from shortlist']);
        }
    }

    /**
     * Toggle shortlist (add if not exists, remove if exists)
     */
    public function toggle(): void
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $userId = Session::getUserId();
        $profileId = (int)($_POST['profile_id'] ?? 0);

        if ($profileId === 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid profile']);
            return;
        }

        if ($profileId === $userId) {
            $this->jsonResponse(['success' => false, 'message' => 'Cannot shortlist yourself']);
            return;
        }

        $isShortlisted = $this->shortlistModel->isShortlisted($userId, $profileId);

        if ($isShortlisted) {
            if ($this->shortlistModel->remove($userId, $profileId)) {
                $this->jsonResponse(['success' => true, 'message' => 'Removed from shortlist', 'isShortlisted' => false]);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to remove']);
            }
        } else {
            if ($this->shortlistModel->add($userId, $profileId)) {
                $this->jsonResponse(['success' => true, 'message' => 'Added to shortlist', 'isShortlisted' => true]);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to add']);
            }
        }
    }
}
