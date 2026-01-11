<?php 
/**
 * Membership Plans Page
 * Displays all available membership plans with pricing
 * 
 * Variables:
 * - $plans: array of membership plans
 * - $selectedDuration: 'monthly', 'quarterly', or 'yearly'
 * - $currentMembership: current user membership info
 * - $isLoggedIn: boolean
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.membership-hero {
    background: linear-gradient(135deg, var(--primary) 0%, #6f42c1 100%);
    padding: 80px 0 60px;
    margin-top: 60px;
    color: white;
    text-align: center;
}

.membership-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.membership-hero p {
    opacity: 0.9;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

.duration-selector {
    display: inline-flex;
    background: rgba(255,255,255,0.15);
    border-radius: 50px;
    padding: 5px;
    margin-top: 2rem;
}

.duration-btn {
    padding: 10px 25px;
    border: none;
    background: transparent;
    color: white;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 500;
}

.duration-btn.active {
    background: white;
    color: var(--primary);
}

.duration-btn:hover:not(.active) {
    background: rgba(255,255,255,0.2);
}

.save-badge {
    background: #28a745;
    color: white;
    font-size: 0.7rem;
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 5px;
}

.plans-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.plan-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    position: relative;
    transition: all 0.3s;
    border: 2px solid transparent;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.plan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.plan-card.popular {
    border-color: #ffc107;
}

.popular-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: #333;
    padding: 5px 20px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
}

.plan-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.8rem;
    color: white;
}

.plan-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.plan-description {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.plan-price {
    margin-bottom: 1.5rem;
}

.plan-price .amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
}

.plan-price .currency {
    font-size: 1.2rem;
    vertical-align: super;
}

.plan-price .period {
    color: #666;
    font-size: 0.9rem;
}

.plan-features {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem;
    text-align: left;
}

.plan-features li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
}

.plan-features li:last-child {
    border-bottom: none;
}

.plan-features .feature-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 0.75rem;
}

.plan-features .feature-icon.yes {
    background: #d4edda;
    color: #28a745;
}

.plan-features .feature-icon.no {
    background: #f8d7da;
    color: #dc3545;
}

.plan-features .feature-value {
    margin-left: auto;
    font-weight: 600;
    color: #333;
}

.btn-upgrade {
    width: 100%;
    padding: 12px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-upgrade.btn-primary {
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    border: none;
}

.btn-upgrade.btn-primary:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 20px rgba(233, 30, 99, 0.3);
}

.current-plan-badge {
    background: #e8f5e9;
    color: #28a745;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.compare-link {
    text-align: center;
    margin-top: 3rem;
}

.compare-link a {
    color: var(--primary);
    font-weight: 500;
    text-decoration: none;
}

.compare-link a:hover {
    text-decoration: underline;
}

@media (max-width: 991px) {
    .plan-card {
        margin-bottom: 2rem;
    }
}
</style>

<!-- Hero Section -->
<section class="membership-hero">
    <div class="container">
        <h1>Choose Your Perfect Plan</h1>
        <p>Unlock premium features and find your life partner faster with our membership plans</p>
        
        <!-- Duration Selector -->
        <div class="duration-selector">
            <button class="duration-btn <?= $selectedDuration === 'monthly' ? 'active' : '' ?>" onclick="changeDuration('monthly')">
                Monthly
            </button>
            <button class="duration-btn <?= $selectedDuration === 'quarterly' ? 'active' : '' ?>" onclick="changeDuration('quarterly')">
                Quarterly
                <span class="save-badge">Save 15%</span>
            </button>
            <button class="duration-btn <?= $selectedDuration === 'yearly' ? 'active' : '' ?>" onclick="changeDuration('yearly')">
                Yearly
                <span class="save-badge">Save 35%</span>
            </button>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section class="plans-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php foreach ($plans as $planId => $plan): ?>
            <div class="col-lg-3 col-md-6">
                <div class="plan-card <?= $plan['is_popular'] ? 'popular' : '' ?>">
                    <?php if ($plan['is_popular']): ?>
                    <div class="popular-badge"><i class="bi bi-fire me-1"></i>Most Popular</div>
                    <?php endif; ?>
                    
                    <div class="plan-icon" style="background: <?= $plan['gradient'] ?>">
                        <i class="bi <?= $plan['icon'] ?>"></i>
                    </div>
                    
                    <h3 class="plan-name text-center"><?= $plan['name'] ?></h3>
                    <p class="plan-description text-center"><?= $plan['description'] ?></p>
                    
                    <div class="plan-price text-center">
                        <?php if ($plan['prices'][$selectedDuration] > 0): ?>
                        <span class="currency">₹</span>
                        <span class="amount"><?= number_format($plan['prices'][$selectedDuration]) ?></span>
                        <span class="period">/ <?= $selectedDuration === 'monthly' ? 'month' : ($selectedDuration === 'quarterly' ? '3 months' : 'year') ?></span>
                        <?php else: ?>
                        <span class="amount">Free</span>
                        <span class="period">Forever</span>
                        <?php endif; ?>
                    </div>
                    
                    <ul class="plan-features">
                        <li>
                            <span class="feature-icon yes"><i class="bi bi-check"></i></span>
                            Profile Views
                            <span class="feature-value"><?= is_numeric($plan['features']['profile_views']) ? $plan['features']['profile_views'] . '/mo' : $plan['features']['profile_views'] ?></span>
                        </li>
                        <li>
                            <span class="feature-icon <?= $plan['features']['contact_views'] ? 'yes' : 'no' ?>">
                                <i class="bi bi-<?= $plan['features']['contact_views'] ? 'check' : 'x' ?>"></i>
                            </span>
                            Contact Details
                            <span class="feature-value"><?= $plan['features']['contact_views'] ?: 'No' ?></span>
                        </li>
                        <li>
                            <span class="feature-icon yes"><i class="bi bi-check"></i></span>
                            Messages/Day
                            <span class="feature-value"><?= $plan['features']['messages_per_day'] ?></span>
                        </li>
                        <li>
                            <span class="feature-icon yes"><i class="bi bi-check"></i></span>
                            Interests/Day
                            <span class="feature-value"><?= $plan['features']['interests_per_day'] ?></span>
                        </li>
                        <li>
                            <span class="feature-icon <?= $plan['features']['profile_highlight'] ? 'yes' : 'no' ?>">
                                <i class="bi bi-<?= $plan['features']['profile_highlight'] ? 'check' : 'x' ?>"></i>
                            </span>
                            Profile Highlight
                        </li>
                        <li>
                            <span class="feature-icon <?= $plan['features']['horoscope_matching'] ? 'yes' : 'no' ?>">
                                <i class="bi bi-<?= $plan['features']['horoscope_matching'] ? 'check' : 'x' ?>"></i>
                            </span>
                            Horoscope Matching
                        </li>
                    </ul>
                    
                    <?php if ($currentMembership['plan_id'] === $planId): ?>
                    <div class="text-center">
                        <span class="current-plan-badge"><i class="bi bi-check-circle me-1"></i>Current Plan</span>
                    </div>
                    <?php elseif ($plan['prices'][$selectedDuration] > 0): ?>
                    <a href="/membership/upgrade?plan=<?= $planId ?>&duration=<?= $selectedDuration ?>" class="btn btn-upgrade btn-primary">
                        Upgrade Now
                    </a>
                    <?php else: ?>
                    <button class="btn btn-upgrade btn-outline-secondary" disabled>
                        Basic Plan
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="compare-link">
            <a href="/membership/compare"><i class="bi bi-columns-gap me-2"></i>Compare All Features in Detail</a>
        </div>
    </div>
</section>

<!-- Trust Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1">100% Secure</h6>
                    <small class="text-muted">SSL Encrypted Payments</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <i class="bi bi-arrow-repeat text-primary" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1">Easy Refund</h6>
                    <small class="text-muted">7-Day Money Back</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <i class="bi bi-headset text-info" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1">24/7 Support</h6>
                    <small class="text-muted">Dedicated Help Desk</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <i class="bi bi-credit-card text-warning" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1">Multiple Options</h6>
                    <small class="text-muted">Cards, UPI, Netbanking</small>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function changeDuration(duration) {
    window.location.href = '/membership?duration=' + duration;
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
