<?php
$pageTitle = 'Server Error';
$currentPage = '';
include __DIR__ . '/../layouts/header.php';
?>

<section class="error-page py-20">
    <div class="container">
        <div class="error-content text-center">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="error-code">500</h1>
            <h2 class="error-title">Something Went Wrong</h2>
            <p class="error-message">
                We're experiencing technical difficulties. Please try again later.
            </p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i> Go Home
                </a>
                <a href="/contact" class="btn btn-outline btn-lg">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.error-page {
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.error-content {
    max-width: 500px;
    margin: 0 auto;
}

.error-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto var(--spacing-6);
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
}

.error-code {
    font-size: 6rem;
    font-weight: 800;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: var(--spacing-2);
}

.error-title {
    font-size: var(--text-2xl);
    margin-bottom: var(--spacing-4);
}

.error-message {
    color: var(--text-secondary);
    margin-bottom: var(--spacing-8);
}

.error-actions {
    display: flex;
    gap: var(--spacing-4);
    justify-content: center;
}

@media (max-width: 480px) {
    .error-actions {
        flex-direction: column;
    }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
