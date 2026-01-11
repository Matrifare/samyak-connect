<?php
/**
 * Membership Controller
 * Handles membership plans display, comparison, and upgrade flow
 * 
 * NOTE: This controller uses STATIC/DUMMY data only.
 * TODO: Replace static data with database queries when integrating with DB
 * TODO: Integrate with payment gateway for actual payment processing
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class MembershipController extends Controller
{
    /**
     * Static membership plans data
     * TODO: Replace with database fetch when DB is ready
     */
    private array $plans = [
        'free' => [
            'id' => 'free',
            'name' => 'Free',
            'slug' => 'free',
            'icon' => 'bi-gift',
            'color' => '#6c757d',
            'gradient' => 'linear-gradient(135deg, #6c757d, #adb5bd)',
            'is_popular' => false,
            'prices' => [
                'monthly' => 0,
                'quarterly' => 0,
                'yearly' => 0
            ],
            'features' => [
                'profile_views' => 5,
                'contact_views' => 0,
                'messages_per_day' => 2,
                'interests_per_day' => 3,
                'search_filters' => 'Basic',
                'profile_highlight' => false,
                'priority_support' => false,
                'profile_boost' => false,
                'verified_badge' => false,
                'photo_album' => 3,
                'horoscope_matching' => false,
                'video_call' => false
            ],
            'description' => 'Get started with basic features'
        ],
        'silver' => [
            'id' => 'silver',
            'name' => 'Silver',
            'slug' => 'silver',
            'icon' => 'bi-award',
            'color' => '#c0c0c0',
            'gradient' => 'linear-gradient(135deg, #c0c0c0, #e8e8e8)',
            'is_popular' => false,
            'prices' => [
                'monthly' => 499,
                'quarterly' => 1299,
                'yearly' => 3999
            ],
            'features' => [
                'profile_views' => 30,
                'contact_views' => 10,
                'messages_per_day' => 10,
                'interests_per_day' => 15,
                'search_filters' => 'Advanced',
                'profile_highlight' => false,
                'priority_support' => false,
                'profile_boost' => false,
                'verified_badge' => false,
                'photo_album' => 6,
                'horoscope_matching' => true,
                'video_call' => false
            ],
            'description' => 'Enhanced features for serious seekers'
        ],
        'gold' => [
            'id' => 'gold',
            'name' => 'Gold',
            'slug' => 'gold',
            'icon' => 'bi-star-fill',
            'color' => '#ffc107',
            'gradient' => 'linear-gradient(135deg, #ffc107, #ffdb4d)',
            'is_popular' => true,
            'prices' => [
                'monthly' => 999,
                'quarterly' => 2499,
                'yearly' => 7999
            ],
            'features' => [
                'profile_views' => 100,
                'contact_views' => 50,
                'messages_per_day' => 50,
                'interests_per_day' => 50,
                'search_filters' => 'Premium',
                'profile_highlight' => true,
                'priority_support' => true,
                'profile_boost' => true,
                'verified_badge' => false,
                'photo_album' => 10,
                'horoscope_matching' => true,
                'video_call' => true
            ],
            'description' => 'Most popular choice for finding your match'
        ],
        'platinum' => [
            'id' => 'platinum',
            'name' => 'Platinum',
            'slug' => 'platinum',
            'icon' => 'bi-gem',
            'color' => '#6f42c1',
            'gradient' => 'linear-gradient(135deg, #6f42c1, #a855f7)',
            'is_popular' => false,
            'prices' => [
                'monthly' => 1999,
                'quarterly' => 4999,
                'yearly' => 14999
            ],
            'features' => [
                'profile_views' => 'Unlimited',
                'contact_views' => 'Unlimited',
                'messages_per_day' => 'Unlimited',
                'interests_per_day' => 'Unlimited',
                'search_filters' => 'VIP',
                'profile_highlight' => true,
                'priority_support' => true,
                'profile_boost' => true,
                'verified_badge' => true,
                'photo_album' => 20,
                'horoscope_matching' => true,
                'video_call' => true
            ],
            'description' => 'VIP experience with exclusive benefits'
        ]
    ];

    /**
     * Feature labels for comparison table
     */
    private array $featureLabels = [
        'profile_views' => 'Profile Views / Month',
        'contact_views' => 'View Contact Details',
        'messages_per_day' => 'Messages / Day',
        'interests_per_day' => 'Express Interest / Day',
        'search_filters' => 'Search Filters',
        'profile_highlight' => 'Profile Highlight',
        'priority_support' => 'Priority Support',
        'profile_boost' => 'Profile Boost',
        'verified_badge' => 'Verified Badge',
        'photo_album' => 'Photo Album Limit',
        'horoscope_matching' => 'Horoscope Matching',
        'video_call' => 'Video Call Feature'
    ];

    /**
     * Payment methods (static)
     * TODO: Replace with actual payment gateway options
     */
    private array $paymentMethods = [
        [
            'id' => 'card',
            'name' => 'Credit / Debit Card',
            'icon' => 'bi-credit-card',
            'description' => 'Visa, Mastercard, RuPay',
            'enabled' => true
        ],
        [
            'id' => 'upi',
            'name' => 'UPI',
            'icon' => 'bi-phone',
            'description' => 'Google Pay, PhonePe, Paytm',
            'enabled' => true
        ],
        [
            'id' => 'netbanking',
            'name' => 'Net Banking',
            'icon' => 'bi-bank',
            'description' => 'All major banks supported',
            'enabled' => true
        ],
        [
            'id' => 'wallet',
            'name' => 'Wallet',
            'icon' => 'bi-wallet2',
            'description' => 'Paytm, Amazon Pay',
            'enabled' => true
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get dummy current membership for logged-in user
     * TODO: Replace with actual user membership fetch from DB
     */
    private function getCurrentMembership(): array
    {
        // Simulate a logged-in user with Free membership
        return [
            'plan_id' => 'free',
            'plan_name' => 'Free',
            'status' => 'active',
            'start_date' => date('Y-m-d', strtotime('-30 days')),
            'expiry_date' => null, // Free plan doesn't expire
            'auto_renew' => false,
            'days_remaining' => null
        ];
    }

    /**
     * Display all membership plans
     */
    public function index(): void
    {
        $duration = $this->getQuery('duration', 'yearly');
        
        $this->render('membership/plans', [
            'title' => 'Membership Plans - Samyak Matrimony',
            'meta_description' => 'Choose the perfect membership plan for your matrimony journey. Free, Silver, Gold, and Platinum plans available.',
            'plans' => $this->plans,
            'selectedDuration' => $duration,
            'currentMembership' => $this->getCurrentMembership(),
            'isLoggedIn' => Session::isLoggedIn()
        ]);
    }

    /**
     * Plan comparison page
     */
    public function compare(): void
    {
        $this->render('membership/compare', [
            'title' => 'Compare Membership Plans - Samyak Matrimony',
            'meta_description' => 'Compare all membership plans side by side. Find the perfect plan for your needs.',
            'plans' => $this->plans,
            'featureLabels' => $this->featureLabels,
            'currentMembership' => $this->getCurrentMembership(),
            'isLoggedIn' => Session::isLoggedIn()
        ]);
    }

    /**
     * Upgrade membership page
     */
    public function upgrade(?string $planId = null): void
    {
        // Require authentication for upgrade
        if (!Session::isLoggedIn()) {
            $this->flash('warning', 'Please login to upgrade your membership.');
            $this->redirect('/login?redirect=/membership/upgrade');
            return;
        }

        $planId = $planId ?? $this->getQuery('plan', 'gold');
        $duration = $this->getQuery('duration', 'yearly');

        if (!isset($this->plans[$planId])) {
            $this->flash('error', 'Invalid membership plan selected.');
            $this->redirect('/membership');
            return;
        }

        $selectedPlan = $this->plans[$planId];
        $price = $selectedPlan['prices'][$duration] ?? $selectedPlan['prices']['yearly'];

        $this->render('membership/upgrade', [
            'title' => 'Upgrade to ' . $selectedPlan['name'] . ' - Samyak Matrimony',
            'selectedPlan' => $selectedPlan,
            'selectedDuration' => $duration,
            'price' => $price,
            'paymentMethods' => $this->paymentMethods,
            'currentMembership' => $this->getCurrentMembership(),
            'allPlans' => $this->plans
        ]);
    }

    /**
     * Process payment (MOCK - No actual payment)
     * TODO: Integrate with actual payment gateway
     */
    public function processPayment(): void
    {
        $this->requireAuth();
        $this->requireCsrf();

        $planId = $this->getPost('plan_id');
        $duration = $this->getPost('duration');
        $paymentMethod = $this->getPost('payment_method');

        // Mock validation
        if (empty($planId) || empty($duration) || empty($paymentMethod)) {
            $this->flash('error', 'Please fill all required fields.');
            $this->redirect('/membership/upgrade?plan=' . ($planId ?? 'gold'));
            return;
        }

        // TODO: Integrate payment gateway here
        // For now, just show a success message

        // Redirect to success page
        $this->redirect('/membership/success?plan=' . $planId . '&duration=' . $duration);
    }

    /**
     * Payment success page (MOCK)
     */
    public function success(): void
    {
        $planId = $this->getQuery('plan', 'gold');
        $duration = $this->getQuery('duration', 'yearly');

        if (!isset($this->plans[$planId])) {
            $this->redirect('/membership');
            return;
        }

        $plan = $this->plans[$planId];
        $price = $plan['prices'][$duration] ?? $plan['prices']['yearly'];

        // Generate mock transaction details
        $transaction = [
            'id' => 'TXN' . strtoupper(substr(md5(time()), 0, 12)),
            'date' => date('d M Y, h:i A'),
            'amount' => $price,
            'plan_name' => $plan['name'],
            'duration' => ucfirst($duration),
            'status' => 'Success',
            'payment_method' => 'Credit Card ****1234'
        ];

        $this->render('membership/success', [
            'title' => 'Payment Successful - Samyak Matrimony',
            'plan' => $plan,
            'duration' => $duration,
            'transaction' => $transaction
        ]);
    }

    /**
     * Payment failure page (MOCK)
     */
    public function failure(): void
    {
        $error = $this->getQuery('error', 'Payment could not be processed. Please try again.');

        $this->render('membership/failure', [
            'title' => 'Payment Failed - Samyak Matrimony',
            'error' => $error
        ]);
    }

    /**
     * Transaction history page (MOCK)
     */
    public function transactions(): void
    {
        $this->requireAuth();

        // Mock transaction history
        $transactions = [
            [
                'id' => 'TXN8A3F2C1D9E4B',
                'date' => date('d M Y', strtotime('-15 days')),
                'plan' => 'Gold',
                'duration' => 'Yearly',
                'amount' => 7999,
                'status' => 'Success',
                'payment_method' => 'UPI'
            ],
            [
                'id' => 'TXN7B2E1D8C3A5F',
                'date' => date('d M Y', strtotime('-380 days')),
                'plan' => 'Silver',
                'duration' => 'Yearly',
                'amount' => 3999,
                'status' => 'Success',
                'payment_method' => 'Credit Card'
            ]
        ];

        $this->render('membership/transactions', [
            'title' => 'Transaction History - Samyak Matrimony',
            'transactions' => $transactions
        ]);
    }

    /**
     * Get plan details (API endpoint for AJAX)
     * TODO: Convert to proper API response when needed
     */
    public function getPlanDetails(): void
    {
        $planId = $this->getQuery('plan');
        
        if (!isset($this->plans[$planId])) {
            http_response_code(404);
            echo json_encode(['error' => 'Plan not found']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'plan' => $this->plans[$planId]
        ]);
    }
}
