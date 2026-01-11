<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">
                    <div class="auth-card-body">
                        <div class="text-center mb-4">
                            <div class="mb-4">
                                <div class="stat-icon mx-auto" style="width: 80px; height: 80px;">
                                    <i class="bi bi-key" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <h1 class="auth-title">Forgot Password?</h1>
                            <p class="auth-subtitle">No worries! Enter your email and we'll send you reset instructions.</p>
                        </div>
                        
                        <form action="/forgot-password" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Enter your registered email"
                                           required>
                                </div>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send me-2"></i>Send Reset Link
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="/login" class="text-muted">
                                <i class="bi bi-arrow-left me-1"></i>Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
