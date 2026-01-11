<?php 
/**
 * Plan Comparison Page
 * Side-by-side comparison of all membership plans
 * 
 * Variables:
 * - $plans: array of membership plans
 * - $featureLabels: array of feature labels for display
 * - $currentMembership: current user membership info
 * - $isLoggedIn: boolean
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.compare-hero {
    background: linear-gradient(135deg, var(--primary) 0%, #6f42c1 100%);
    padding: 80px 0 40px;
    margin-top: 60px;
    color: white;
    text-align: center;
}

.compare-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
}

.compare-section {
    padding: 40px 0 60px;
    background: #f8f9fa;
}

.compare-table-wrapper {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.compare-table {
    width: 100%;
    border-collapse: collapse;
}

.compare-table th,
.compare-table td {
    padding: 15px 20px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.compare-table th {
    background: #f8f9fa;
    font-weight: 600;
}

.compare-table .feature-name {
    text-align: left;
    font-weight: 500;
    color: #333;
    background: white;
}

.compare-table .feature-name i {
    margin-right: 10px;
    color: var(--primary);
}

.compare-table thead th {
    padding: 25px 20px;
    vertical-align: bottom;
}

.compare-table thead th:first-child {
    text-align: left;
}

.plan-header {
    text-align: center;
}

.plan-header .plan-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    font-size: 1.3rem;
    color: white;
}

.plan-header .plan-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    margin-bottom: 5px;
    color: #333;
}

.plan-header .plan-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
}

.plan-header .plan-price small {
    font-weight: 400;
    color: #666;
    font-size: 0.8rem;
}

.popular-column {
    background: #fff8e1 !important;
}

.popular-header {
    position: relative;
}

.popular-header::before {
    content: "★ MOST POPULAR";
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: #333;
    padding: 3px 15px;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
}

.feature-check {
    color: #28a745;
    font-size: 1.2rem;
}

.feature-cross {
    color: #dc3545;
    font-size: 1.2rem;
}

.feature-value {
    font-weight: 600;
    color: #333;
}

.compare-table tbody tr:hover {
    background: #f8f9fa;
}

.compare-table tbody tr:last-child td {
    border-bottom: none;
}

.compare-table tfoot td {
    padding: 20px;
    background: #f8f9fa;
}

.btn-choose {
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-choose.btn-primary {
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    border: none;
}

.btn-choose:hover {
    transform: scale(1.05);
}

.current-badge {
    display: inline-block;
    background: #e8f5e9;
    color: #28a745;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .compare-table-wrapper {
        overflow-x: auto;
    }
    
    .compare-table {
        min-width: 800px;
    }
    
    .compare-table th,
    .compare-table td {
        padding: 12px 15px;
    }
}

.category-row td {
    background: #e9ecef !important;
    font-weight: 600;
    color: #495057;
    text-align: left !important;
}
</style>

<!-- Hero Section -->
<section class="compare-hero">
    <div class="container">
        <h1>Compare All Plans</h1>
        <p class="mb-0">Find the perfect plan that suits your needs</p>
    </div>
</section>

<!-- Compare Table Section -->
<section class="compare-section">
    <div class="container">
        <div class="compare-table-wrapper">
            <table class="compare-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Features</th>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <th class="<?= $plan['is_popular'] ? 'popular-column popular-header' : '' ?>" style="width: 18.75%;">
                            <div class="plan-header">
                                <div class="plan-icon" style="background: <?= $plan['gradient'] ?>">
                                    <i class="bi <?= $plan['icon'] ?>"></i>
                                </div>
                                <div class="plan-name"><?= $plan['name'] ?></div>
                                <div class="plan-price">
                                    <?php if ($plan['prices']['yearly'] > 0): ?>
                                    ₹<?= number_format($plan['prices']['yearly']) ?>
                                    <small>/year</small>
                                    <?php else: ?>
                                    Free
                                    <?php endif; ?>
                                </div>
                            </div>
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Profile & Search Category -->
                    <tr class="category-row">
                        <td colspan="5"><i class="bi bi-person-circle me-2"></i>Profile & Search</td>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-eye"></i>Profile Views / Month</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <span class="feature-value"><?= $plan['features']['profile_views'] ?></span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-telephone"></i>View Contact Details</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['contact_views']): ?>
                            <span class="feature-value"><?= $plan['features']['contact_views'] ?></span>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-funnel"></i>Search Filters</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <span class="feature-value"><?= $plan['features']['search_filters'] ?></span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    
                    <!-- Communication Category -->
                    <tr class="category-row">
                        <td colspan="5"><i class="bi bi-chat-dots me-2"></i>Communication</td>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-envelope"></i>Messages / Day</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <span class="feature-value"><?= $plan['features']['messages_per_day'] ?></span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-heart"></i>Express Interest / Day</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <span class="feature-value"><?= $plan['features']['interests_per_day'] ?></span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-camera-video"></i>Video Call</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['video_call']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    
                    <!-- Profile Enhancement Category -->
                    <tr class="category-row">
                        <td colspan="5"><i class="bi bi-stars me-2"></i>Profile Enhancement</td>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-images"></i>Photo Album Limit</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <span class="feature-value"><?= $plan['features']['photo_album'] ?></span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-lightning"></i>Profile Highlight</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['profile_highlight']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-rocket"></i>Profile Boost</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['profile_boost']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-patch-check"></i>Verified Badge</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['verified_badge']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    
                    <!-- Special Features Category -->
                    <tr class="category-row">
                        <td colspan="5"><i class="bi bi-gem me-2"></i>Special Features</td>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-moon-stars"></i>Horoscope Matching</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['horoscope_matching']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="feature-name"><i class="bi bi-headset"></i>Priority Support</td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($plan['features']['priority_support']): ?>
                            <i class="bi bi-check-circle-fill feature-check"></i>
                            <?php else: ?>
                            <i class="bi bi-x-circle feature-cross"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <?php foreach ($plans as $planId => $plan): ?>
                        <td class="<?= $plan['is_popular'] ? 'popular-column' : '' ?>">
                            <?php if ($currentMembership['plan_id'] === $planId): ?>
                            <span class="current-badge"><i class="bi bi-check-circle me-1"></i>Current Plan</span>
                            <?php elseif ($plan['prices']['yearly'] > 0): ?>
                            <a href="/membership/upgrade?plan=<?= $planId ?>" class="btn btn-choose btn-primary">
                                Choose <?= $plan['name'] ?>
                            </a>
                            <?php else: ?>
                            <span class="text-muted">Basic Plan</span>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-center mt-4">
            <a href="/membership" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Back to Plans</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
