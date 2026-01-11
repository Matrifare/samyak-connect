<?php 
/**
 * Payment Failure Page
 * Displays when payment fails (MOCK)
 * 
 * Variables:
 * - $error: error message
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.failure-section {
    padding: 100px 0 60px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffebee 100%);
    min-height: 100vh;
}

.failure-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    max-width: 500px;
    margin: 0 auto;
    text-align: center;
    overflow: hidden;
}

.failure-header {
    background: linear-gradient(135deg, #dc3545, #e57373);
    padding: 40px;
    color: white;
}

.failure-icon {
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    margin-bottom: 20px;
}

.failure-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    margin-bottom: 10px;
}

.failure-body {
    padding: 30px;
}

.error-message {
    background: #ffebee;
    border: 1px solid #ffcdd2;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 25px;
    color: #c62828;
}

.help-section {
    text-align: left;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

.help-section h6 {
    margin-bottom: 15px;
}

.help-section ul {
    margin: 0;
    padding-left: 20px;
}

.help-section li {
    padding: 5px 0;
    color: #666;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.action-buttons .btn {
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
}

.btn-retry {
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    border: none;
    color: white;
}

.btn-retry:hover {
    color: white;
    transform: scale(1.02);
}
</style>

<section class="failure-section">
    <div class="container">
        <div class="failure-card">
            <div class="failure-header">
                <div class="failure-icon">
                    <i class="bi bi-x-lg"></i>
                </div>
                <h1>Payment Failed</h1>
                <p class="mb-0">Don't worry, no amount was deducted</p>
            </div>
            
            <div class="failure-body">
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
                
                <div class="help-section">
                    <h6><i class="bi bi-lightbulb text-warning me-2"></i>Possible reasons:</h6>
                    <ul>
                        <li>Insufficient balance in your account</li>
                        <li>Card declined by bank</li>
                        <li>Network connectivity issues</li>
                        <li>Transaction timeout</li>
                        <li>Incorrect card/UPI details</li>
                    </ul>
                </div>
                
                <div class="action-buttons">
                    <a href="/membership" class="btn btn-retry">
                        <i class="bi bi-arrow-repeat me-2"></i>Try Again
                    </a>
                    <a href="/contact" class="btn btn-outline-secondary">
                        <i class="bi bi-headset me-2"></i>Contact Support
                    </a>
                    <a href="/dashboard" class="btn btn-link text-muted">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
