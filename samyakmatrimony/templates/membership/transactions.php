<?php 
/**
 * Transaction History Page
 * Displays user's payment history (MOCK)
 * 
 * Variables:
 * - $transactions: array of transaction records
 */
include __DIR__ . '/../layouts/header.php'; 
?>

<style>
.transactions-section {
    padding: 80px 0 60px;
    margin-top: 60px;
    background: #f8f9fa;
    min-height: 80vh;
}

.transactions-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.transactions-header {
    background: linear-gradient(135deg, var(--primary), #6f42c1);
    padding: 30px;
    color: white;
}

.transactions-header h2 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 5px;
}

.transactions-body {
    padding: 0;
}

.transaction-item {
    display: flex;
    align-items: center;
    padding: 20px 30px;
    border-bottom: 1px solid #eee;
    transition: background 0.3s;
}

.transaction-item:last-child {
    border-bottom: none;
}

.transaction-item:hover {
    background: #f8f9fa;
}

.transaction-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.3rem;
    color: white;
}

.transaction-icon.success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.transaction-icon.failed {
    background: linear-gradient(135deg, #dc3545, #e57373);
}

.transaction-info {
    flex: 1;
}

.transaction-info .plan-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.transaction-info .details {
    font-size: 0.9rem;
    color: #666;
}

.transaction-info .txn-id {
    font-size: 0.8rem;
    color: #999;
    font-family: monospace;
}

.transaction-amount {
    text-align: right;
}

.transaction-amount .amount {
    font-weight: 700;
    font-size: 1.2rem;
    color: #333;
}

.transaction-amount .status {
    font-size: 0.85rem;
    padding: 3px 10px;
    border-radius: 15px;
}

.transaction-amount .status.success {
    background: #d4edda;
    color: #28a745;
}

.transaction-amount .status.failed {
    background: #f8d7da;
    color: #dc3545;
}

.empty-state {
    text-align: center;
    padding: 60px 30px;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #666;
}

.download-btn {
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.85rem;
}
</style>

<section class="transactions-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <a href="/dashboard" class="text-muted"><i class="bi bi-arrow-left me-2"></i>Back to Dashboard</a>
                </div>
                
                <div class="transactions-card">
                    <div class="transactions-header">
                        <h2><i class="bi bi-receipt me-2"></i>Transaction History</h2>
                        <p class="mb-0">View your payment history and download invoices</p>
                    </div>
                    
                    <div class="transactions-body">
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $txn): ?>
                            <div class="transaction-item">
                                <div class="transaction-icon <?= $txn['status'] === 'Success' ? 'success' : 'failed' ?>">
                                    <i class="bi bi-<?= $txn['status'] === 'Success' ? 'check' : 'x' ?>-lg"></i>
                                </div>
                                
                                <div class="transaction-info">
                                    <div class="plan-name"><?= $txn['plan'] ?> Plan - <?= $txn['duration'] ?></div>
                                    <div class="details">
                                        <i class="bi bi-calendar3 me-1"></i><?= $txn['date'] ?>
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-credit-card me-1"></i><?= $txn['payment_method'] ?>
                                    </div>
                                    <div class="txn-id">ID: <?= $txn['id'] ?></div>
                                </div>
                                
                                <div class="transaction-amount">
                                    <div class="amount">₹<?= number_format($txn['amount']) ?></div>
                                    <span class="status <?= strtolower($txn['status']) ?>"><?= $txn['status'] ?></span>
                                </div>
                                
                                <?php if ($txn['status'] === 'Success'): ?>
                                <button class="btn btn-outline-primary download-btn ms-3" onclick="downloadInvoice('<?= $txn['id'] ?>')">
                                    <i class="bi bi-download"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-receipt-cutoff"></i>
                                <h5>No transactions yet</h5>
                                <p class="text-muted">Your payment history will appear here</p>
                                <a href="/membership" class="btn btn-primary mt-3">View Membership Plans</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// TODO: Integrate with backend for actual invoice download
function downloadInvoice(transactionId) {
    alert('Invoice download for ' + transactionId + ' will be available after backend integration');
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
