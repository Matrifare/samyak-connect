<?php 
/**
 * Upgrade Membership Page
 * Payment page for upgrading membership
 * 
 * Variables:
 * - $selectedPlan: selected plan details
 * - $selectedDuration: 'monthly', 'quarterly', or 'yearly'
 * - $price: calculated price
 * - $paymentMethods: available payment methods
 * - $currentMembership: current user membership info
 * - $allPlans: all available plans
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.upgrade-section {
    padding: 100px 0 60px;
    background: #f8f9fa;
    min-height: 100vh;
}

.upgrade-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.upgrade-header {
    background: <?= $selectedPlan['gradient'] ?>;
    padding: 30px;
    color: white;
    text-align: center;
}

.upgrade-header .plan-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 15px;
}

.upgrade-header h2 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 5px;
}

.upgrade-body {
    padding: 30px;
}

.plan-selector {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.plan-option {
    flex: 1;
    padding: 12px;
    border: 2px solid #eee;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}

.plan-option:hover {
    border-color: var(--primary);
}

.plan-option.active {
    border-color: var(--primary);
    background: #fce4ec;
}

.plan-option .name {
    font-weight: 600;
    font-size: 0.9rem;
}

.plan-option .price {
    color: var(--primary);
    font-weight: 700;
}

.duration-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 25px;
}

.duration-option {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.duration-option:hover {
    border-color: var(--primary);
}

.duration-option.active {
    border-color: var(--primary);
    background: #fce4ec;
}

.duration-option input {
    display: none;
}

.duration-option .radio-circle {
    width: 22px;
    height: 22px;
    border: 2px solid #ccc;
    border-radius: 50%;
    margin-right: 15px;
    position: relative;
}

.duration-option.active .radio-circle {
    border-color: var(--primary);
}

.duration-option.active .radio-circle::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background: var(--primary);
    border-radius: 50%;
}

.duration-option .duration-info {
    flex: 1;
}

.duration-option .duration-name {
    font-weight: 600;
}

.duration-option .duration-desc {
    font-size: 0.85rem;
    color: #666;
}

.duration-option .duration-price {
    text-align: right;
}

.duration-option .duration-price .amount {
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
}

.duration-option .duration-price .save {
    font-size: 0.75rem;
    color: #28a745;
    font-weight: 600;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #333;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 25px;
}

.payment-method {
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

.payment-method:hover {
    border-color: var(--primary);
}

.payment-method.active {
    border-color: var(--primary);
    background: #fce4ec;
}

.payment-method input {
    display: none;
}

.payment-method i {
    font-size: 1.5rem;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

.payment-method .method-name {
    font-weight: 600;
    font-size: 0.9rem;
}

.payment-method .method-desc {
    font-size: 0.75rem;
    color: #666;
}

.order-summary {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

.order-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.order-row.total {
    border-top: 2px solid #ddd;
    margin-top: 10px;
    padding-top: 15px;
    font-weight: 700;
    font-size: 1.2rem;
}

.order-row .label {
    color: #666;
}

.order-row .value {
    font-weight: 600;
}

.btn-pay {
    width: 100%;
    padding: 15px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    border: none;
    color: white;
    transition: all 0.3s;
}

.btn-pay:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 20px rgba(233, 30, 99, 0.3);
    color: white;
}

.secure-badge {
    text-align: center;
    margin-top: 15px;
    color: #666;
    font-size: 0.85rem;
}

.secure-badge i {
    color: #28a745;
}

.features-summary {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    padding: 25px;
}

.features-summary h5 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 20px;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.feature-item:last-child {
    border-bottom: none;
}

.feature-item i {
    color: #28a745;
    margin-right: 12px;
    font-size: 1.1rem;
}

.feature-item span {
    flex: 1;
}

.feature-item .value {
    font-weight: 600;
    color: var(--primary);
}

.coupon-section {
    margin-bottom: 20px;
}

.coupon-input {
    display: flex;
    gap: 10px;
}

.coupon-input input {
    flex: 1;
    padding: 12px 15px;
    border: 2px solid #eee;
    border-radius: 10px;
    font-size: 0.95rem;
}

.coupon-input input:focus {
    outline: none;
    border-color: var(--primary);
}

.coupon-input button {
    padding: 12px 20px;
    border: none;
    background: #333;
    color: white;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
}

@media (max-width: 991px) {
    .features-summary {
        margin-top: 30px;
    }
    
    .payment-methods {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="upgrade-section">
    <div class="container">
        <div class="row g-4">
            <!-- Main Form -->
            <div class="col-lg-7">
                <div class="upgrade-card">
                    <div class="upgrade-header">
                        <div class="plan-icon">
                            <i class="bi <?= $selectedPlan['icon'] ?>"></i>
                        </div>
                        <h2>Upgrade to <?= $selectedPlan['name'] ?></h2>
                        <p class="mb-0"><?= $selectedPlan['description'] ?></p>
                    </div>
                    
                    <div class="upgrade-body">
                        <form id="upgradeForm" action="/membership/process-payment" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            <input type="hidden" name="plan_id" id="plan_id" value="<?= $selectedPlan['id'] ?>">
                            
                            <!-- Plan Selection -->
                            <h6 class="section-title">Select Plan</h6>
                            <div class="plan-selector">
                                <?php foreach ($allPlans as $planId => $plan): ?>
                                <?php if ($plan['prices']['yearly'] > 0): ?>
                                <div class="plan-option <?= $planId === $selectedPlan['id'] ? 'active' : '' ?>" 
                                     onclick="selectPlan('<?= $planId ?>')">
                                    <div class="name"><?= $plan['name'] ?></div>
                                    <div class="price">₹<?= number_format($plan['prices']['yearly']) ?></div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Duration Selection -->
                            <h6 class="section-title">Select Duration</h6>
                            <div class="duration-options">
                                <label class="duration-option <?= $selectedDuration === 'monthly' ? 'active' : '' ?>">
                                    <input type="radio" name="duration" value="monthly" <?= $selectedDuration === 'monthly' ? 'checked' : '' ?>>
                                    <span class="radio-circle"></span>
                                    <div class="duration-info">
                                        <div class="duration-name">Monthly</div>
                                        <div class="duration-desc">Billed every month</div>
                                    </div>
                                    <div class="duration-price">
                                        <div class="amount">₹<?= number_format($selectedPlan['prices']['monthly']) ?></div>
                                    </div>
                                </label>
                                
                                <label class="duration-option <?= $selectedDuration === 'quarterly' ? 'active' : '' ?>">
                                    <input type="radio" name="duration" value="quarterly" <?= $selectedDuration === 'quarterly' ? 'checked' : '' ?>>
                                    <span class="radio-circle"></span>
                                    <div class="duration-info">
                                        <div class="duration-name">Quarterly</div>
                                        <div class="duration-desc">Billed every 3 months</div>
                                    </div>
                                    <div class="duration-price">
                                        <div class="amount">₹<?= number_format($selectedPlan['prices']['quarterly']) ?></div>
                                        <div class="save">Save 15%</div>
                                    </div>
                                </label>
                                
                                <label class="duration-option <?= $selectedDuration === 'yearly' ? 'active' : '' ?>">
                                    <input type="radio" name="duration" value="yearly" <?= $selectedDuration === 'yearly' ? 'checked' : '' ?>>
                                    <span class="radio-circle"></span>
                                    <div class="duration-info">
                                        <div class="duration-name">Yearly</div>
                                        <div class="duration-desc">Billed annually - Best Value!</div>
                                    </div>
                                    <div class="duration-price">
                                        <div class="amount">₹<?= number_format($selectedPlan['prices']['yearly']) ?></div>
                                        <div class="save">Save 35%</div>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- Payment Method -->
                            <h6 class="section-title">Payment Method</h6>
                            <div class="payment-methods">
                                <?php foreach ($paymentMethods as $index => $method): ?>
                                <label class="payment-method <?= $index === 0 ? 'active' : '' ?>">
                                    <input type="radio" name="payment_method" value="<?= $method['id'] ?>" <?= $index === 0 ? 'checked' : '' ?>>
                                    <i class="bi <?= $method['icon'] ?>"></i>
                                    <div class="method-name"><?= $method['name'] ?></div>
                                    <div class="method-desc"><?= $method['description'] ?></div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Coupon -->
                            <div class="coupon-section">
                                <h6 class="section-title">Have a Coupon?</h6>
                                <div class="coupon-input">
                                    <input type="text" name="coupon_code" placeholder="Enter coupon code">
                                    <button type="button" onclick="applyCoupon()">Apply</button>
                                </div>
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="order-summary">
                                <div class="order-row">
                                    <span class="label"><?= $selectedPlan['name'] ?> Plan (<?= ucfirst($selectedDuration) ?>)</span>
                                    <span class="value">₹<?= number_format($price) ?></span>
                                </div>
                                <div class="order-row">
                                    <span class="label">GST (18%)</span>
                                    <span class="value">₹<?= number_format($price * 0.18) ?></span>
                                </div>
                                <div class="order-row">
                                    <span class="label">Discount</span>
                                    <span class="value text-success">-₹0</span>
                                </div>
                                <div class="order-row total">
                                    <span>Total</span>
                                    <span>₹<?= number_format($price * 1.18) ?></span>
                                </div>
                            </div>
                            
                            <!-- TODO: Replace this button action with actual payment gateway integration -->
                            <button type="submit" class="btn btn-pay">
                                <i class="bi bi-lock me-2"></i>Proceed to Pay ₹<?= number_format($price * 1.18) ?>
                            </button>
                            
                            <div class="secure-badge">
                                <i class="bi bi-shield-check me-1"></i>
                                Secure payment with 256-bit SSL encryption
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Features Summary -->
            <div class="col-lg-5">
                <div class="features-summary">
                    <h5><i class="bi bi-gift text-primary me-2"></i>What You'll Get</h5>
                    
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Profile Views / Month</span>
                        <span class="value"><?= $selectedPlan['features']['profile_views'] ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>View Contact Details</span>
                        <span class="value"><?= $selectedPlan['features']['contact_views'] ?: 'No' ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Messages per Day</span>
                        <span class="value"><?= $selectedPlan['features']['messages_per_day'] ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Express Interest / Day</span>
                        <span class="value"><?= $selectedPlan['features']['interests_per_day'] ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Search Filters</span>
                        <span class="value"><?= $selectedPlan['features']['search_filters'] ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Photo Album</span>
                        <span class="value"><?= $selectedPlan['features']['photo_album'] ?> Photos</span>
                    </div>
                    
                    <?php if ($selectedPlan['features']['profile_highlight']): ?>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Profile Highlight</span>
                        <span class="value"><i class="bi bi-check text-success"></i></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($selectedPlan['features']['horoscope_matching']): ?>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Horoscope Matching</span>
                        <span class="value"><i class="bi bi-check text-success"></i></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($selectedPlan['features']['video_call']): ?>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Video Call Feature</span>
                        <span class="value"><i class="bi bi-check text-success"></i></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($selectedPlan['features']['priority_support']): ?>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Priority Support</span>
                        <span class="value"><i class="bi bi-check text-success"></i></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="/membership/compare" class="text-muted">
                        <i class="bi bi-columns-gap me-1"></i>Compare All Plans
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Duration option selection
document.querySelectorAll('.duration-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input').checked = true;
        // TODO: Update order summary dynamically
    });
});

// Payment method selection
document.querySelectorAll('.payment-method').forEach(method => {
    method.addEventListener('click', function() {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input').checked = true;
    });
});

// Select plan
function selectPlan(planId) {
    window.location.href = '/membership/upgrade?plan=' + planId + '&duration=' + document.querySelector('input[name="duration"]:checked').value;
}

// Apply coupon (mock)
function applyCoupon() {
    // TODO: Integrate with backend coupon validation
    alert('Coupon validation will be integrated with backend');
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
