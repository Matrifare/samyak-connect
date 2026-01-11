<?php 
/**
 * Payment Success Page
 * Displays after successful payment (MOCK)
 * 
 * Variables:
 * - $plan: purchased plan details
 * - $duration: selected duration
 * - $transaction: mock transaction details
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.success-section {
    padding: 100px 0 60px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
    min-height: 100vh;
}

.success-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    overflow: hidden;
}

.success-header {
    background: linear-gradient(135deg, #28a745, #20c997);
    padding: 40px;
    color: white;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin-bottom: 20px;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); opacity: 1; }
}

.success-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    margin-bottom: 10px;
}

.success-body {
    padding: 30px;
}

.transaction-details {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    text-align: left;
}

.transaction-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.transaction-row:last-child {
    border-bottom: none;
}

.transaction-row .label {
    color: #666;
}

.transaction-row .value {
    font-weight: 600;
    color: #333;
}

.transaction-row .value.success {
    color: #28a745;
}

.plan-badge {
    display: inline-block;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 20px;
}

.plan-badge.gold {
    background: linear-gradient(135deg, #ffc107, #ffdb4d);
    color: #333;
}

.plan-badge.silver {
    background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
    color: #333;
}

.plan-badge.platinum {
    background: linear-gradient(135deg, #6f42c1, #a855f7);
    color: white;
}

.next-steps {
    text-align: left;
    margin-bottom: 25px;
}

.next-steps h6 {
    margin-bottom: 15px;
}

.next-steps ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.next-steps li {
    padding: 10px 0;
    display: flex;
    align-items: center;
}

.next-steps li i {
    width: 30px;
    height: 30px;
    background: #e8f5e9;
    color: #28a745;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.action-buttons .btn {
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
}

.btn-dashboard {
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    border: none;
    color: white;
}

.btn-dashboard:hover {
    color: white;
    transform: scale(1.02);
}

.confetti {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 1000;
}

.confetti-piece {
    position: absolute;
    width: 10px;
    height: 10px;
    animation: confetti-fall 3s ease-out forwards;
}

@keyframes confetti-fall {
    0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}
</style>

<!-- Confetti Animation -->
<div class="confetti" id="confetti"></div>

<section class="success-section">
    <div class="container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h1>Payment Successful!</h1>
                <p class="mb-0">Your membership has been activated</p>
            </div>
            
            <div class="success-body">
                <div class="plan-badge <?= $plan['id'] ?>">
                    <i class="bi <?= $plan['icon'] ?> me-2"></i><?= $plan['name'] ?> Member
                </div>
                
                <div class="transaction-details">
                    <div class="transaction-row">
                        <span class="label">Transaction ID</span>
                        <span class="value"><?= $transaction['id'] ?></span>
                    </div>
                    <div class="transaction-row">
                        <span class="label">Date & Time</span>
                        <span class="value"><?= $transaction['date'] ?></span>
                    </div>
                    <div class="transaction-row">
                        <span class="label">Plan</span>
                        <span class="value"><?= $transaction['plan_name'] ?> (<?= $transaction['duration'] ?>)</span>
                    </div>
                    <div class="transaction-row">
                        <span class="label">Payment Method</span>
                        <span class="value"><?= $transaction['payment_method'] ?></span>
                    </div>
                    <div class="transaction-row">
                        <span class="label">Amount Paid</span>
                        <span class="value">₹<?= number_format($transaction['amount'] * 1.18) ?></span>
                    </div>
                    <div class="transaction-row">
                        <span class="label">Status</span>
                        <span class="value success"><i class="bi bi-check-circle me-1"></i><?= $transaction['status'] ?></span>
                    </div>
                </div>
                
                <div class="next-steps">
                    <h6><i class="bi bi-lightbulb text-warning me-2"></i>What's Next?</h6>
                    <ul>
                        <li>
                            <i class="bi bi-search"></i>
                            <span>Start searching for your perfect match</span>
                        </li>
                        <li>
                            <i class="bi bi-heart"></i>
                            <span>Send interests to profiles you like</span>
                        </li>
                        <li>
                            <i class="bi bi-chat-dots"></i>
                            <span>Connect with potential partners</span>
                        </li>
                        <li>
                            <i class="bi bi-person-check"></i>
                            <span>Complete your profile for better matches</span>
                        </li>
                    </ul>
                </div>
                
                <div class="action-buttons">
                    <a href="/dashboard" class="btn btn-dashboard">
                        <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                    </a>
                    <a href="/search" class="btn btn-outline-primary">
                        <i class="bi bi-search me-2"></i>Search Profiles
                    </a>
                </div>
                
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="bi bi-envelope me-1"></i>
                        A receipt has been sent to your registered email address
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Create confetti animation
function createConfetti() {
    const confettiContainer = document.getElementById('confetti');
    const colors = ['#e91e63', '#ffc107', '#28a745', '#6f42c1', '#17a2b8'];
    
    for (let i = 0; i < 50; i++) {
        const piece = document.createElement('div');
        piece.className = 'confetti-piece';
        piece.style.left = Math.random() * 100 + '%';
        piece.style.background = colors[Math.floor(Math.random() * colors.length)];
        piece.style.animationDelay = Math.random() * 2 + 's';
        piece.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
        confettiContainer.appendChild(piece);
    }
    
    // Remove confetti after animation
    setTimeout(() => {
        confettiContainer.innerHTML = '';
    }, 5000);
}

// Trigger confetti on page load
document.addEventListener('DOMContentLoaded', createConfetti);
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
