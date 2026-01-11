<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class HomeController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Home page
     */
    public function index(): void
    {
        // Get featured profiles
        $featuredProfiles = $this->userModel->getFeaturedProfiles(8);
        
        // Get success stories count
        $stats = [
            'total_profiles' => $this->userModel->getTotalCount(),
            'male_profiles' => $this->userModel->getCountByGender('Male'),
            'female_profiles' => $this->userModel->getCountByGender('Female'),
            'success_stories' => 150 // This can be fetched from database
        ];

        $this->render('home/index', [
            'title' => 'Samyak Matrimony - Buddhist Matrimonial Service',
            'meta_description' => 'Find your perfect Buddhist life partner on Samyak Matrimony. Trusted matrimonial service for Buddhist community.',
            'featuredProfiles' => $featuredProfiles,
            'stats' => $stats
        ]);
    }

    /**
     * About page
     */
    public function about(): void
    {
        $this->render('pages/about', [
            'title' => 'About Us - Samyak Matrimony',
            'meta_description' => 'Learn about Samyak Matrimony - the trusted Buddhist matrimonial service.'
        ]);
    }

    /**
     * Contact page
     */
    public function contact(): void
    {
        $this->render('pages/contact', [
            'title' => 'Contact Us - Samyak Matrimony',
            'meta_description' => 'Get in touch with Samyak Matrimony for any queries or support.'
        ]);
    }

    /**
     * Process contact form
     */
    public function submitContact(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
            return;
        }

        // Validate and process contact form
        $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');

        // TODO: Save to database or send email

        Session::setFlash('success', 'Thank you for contacting us. We will get back to you soon.');
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
     * Terms page
     */
    public function terms(): void
    {
        $this->render('pages/terms', [
            'title' => 'Terms & Conditions - Samyak Matrimony'
        ]);
    }

    /**
     * Success stories page
     */
    public function successStories(): void
    {
        $this->render('pages/success-stories', [
            'title' => 'Success Stories - Samyak Matrimony',
            'meta_description' => 'Read inspiring success stories of couples who found love on Samyak Matrimony.'
        ]);
    }
}
