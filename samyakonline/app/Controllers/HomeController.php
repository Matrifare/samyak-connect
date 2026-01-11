<?php
/**
 * Home Controller
 * Handles homepage and static pages
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Homepage
     */
    public function index(): void
    {
        // Get statistics
        $stats = $this->getStats();
        
        // Get featured profiles
        $userModel = new User();
        $featuredProfiles = $userModel->search([
            'gender' => 'Bride'
        ], 1, 8);

        // Get success stories
        $successStories = $this->db->select(
            "SELECT * FROM success_story WHERE status = 'APPROVED' ORDER BY id DESC LIMIT 3"
        );

        // Pass data to template
        $pageTitle = 'Home';
        $currentPage = 'home';
        $stats = $stats;
        $featuredProfiles = $featuredProfiles['data'] ?? [];
        $successStories = $successStories ?? [];
        
        include __DIR__ . '/../../templates/pages/home.php';
    }

    /**
     * About us page
     */
    public function about(): void
    {
        $this->render('pages/about', [
            'title' => 'About Us - Samyak Matrimony'
        ]);
    }

    /**
     * Contact us page
     */
    public function contact(): void
    {
        $this->render('pages/contact', [
            'title' => 'Contact Us - Samyak Matrimony',
            'success' => $this->session->getFlash('success'),
            'error' => $this->session->getFlash('error')
        ]);
    }

    /**
     * Process contact form
     */
    public function submitContact(): void
    {
        $this->requireCsrf();

        $name = $this->getPost('name');
        $email = $this->getPost('email');
        $subject = $this->getPost('subject');
        $message = $this->getPost('message');

        // Validate
        if (empty($name) || empty($email) || empty($message)) {
            $this->session->setFlash('error', 'Please fill all required fields');
            $this->redirect('/contact');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->setFlash('error', 'Please enter a valid email address');
            $this->redirect('/contact');
        }

        // Store contact inquiry
        $this->db->insert(
            "INSERT INTO contact_inquiries (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())",
            [$name, $email, $subject, $message]
        );

        $this->session->setFlash('success', 'Thank you for contacting us. We will get back to you soon.');
        $this->redirect('/contact');
    }

    /**
     * Privacy policy page
     */
    public function privacy(): void
    {
        $this->render('pages/privacy', [
            'title' => 'Privacy Policy - Samyak Matrimony'
        ]);
    }

    /**
     * Terms and conditions page
     */
    public function terms(): void
    {
        $this->render('pages/terms', [
            'title' => 'Terms & Conditions - Samyak Matrimony'
        ]);
    }

    /**
     * FAQ page
     */
    public function faq(): void
    {
        $faqs = $this->db->select("SELECT * FROM faq WHERE status = 'ACTIVE' ORDER BY sort_order");
        
        $this->render('pages/faq', [
            'title' => 'FAQ - Samyak Matrimony',
            'faqs' => $faqs
        ]);
    }

    /**
     * Get site statistics
     */
    private function getStats(): array
    {
        $stats = $this->db->selectOne(
            "SELECT 
                (SELECT COUNT(*) FROM register WHERE gender = 'Bride' AND status = 'APPROVED') as brides,
                (SELECT COUNT(*) FROM register WHERE gender = 'Groom' AND status = 'APPROVED') as grooms,
                (SELECT COUNT(*) FROM success_story WHERE status = 'APPROVED') as success_stories"
        );

        return [
            'brides' => (int) ($stats['brides'] ?? 0),
            'grooms' => (int) ($stats['grooms'] ?? 0),
            'success_stories' => (int) ($stats['success_stories'] ?? 0),
            'total_members' => (int) (($stats['brides'] ?? 0) + ($stats['grooms'] ?? 0))
        ];
    }
}
