<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">
                    <div class="auth-card-body">
                        <div class="text-center mb-4">
                            <a href="/" class="navbar-brand d-inline-block mb-3">
                                <span class="text-gradient">Samyak</span> Matrimony
                            </a>
                            <h1 class="auth-title">Welcome Back</h1>
                            <p class="auth-subtitle">Login to your account to continue</p>
                        </div>
                        
                        <form action="/login" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Enter your email"
                                           required>
                                </div>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter your password"
                                           required>
                                    <button type="button" class="input-group-text password-toggle" style="cursor: pointer; border-left: none;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Password is required.</div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="/forgot-password" class="text-primary">Forgot Password?</a>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                        </form>
                        
                        <div class="auth-divider">
                            <span>OR</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="mb-0">Don't have an account? <a href="/register" class="fw-semibold">Register Free</a></p>
                        </div>
                    </div>
                </div>
                
                <!-- Profile ID Login -->
                <div class="auth-card mt-4">
                    <div class="auth-card-body py-4">
                        <h6 class="text-center mb-3">Login with Profile ID</h6>
                        <form action="/login" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" name="profile_id" placeholder="Enter Profile ID (e.g., SM12345)">
                                <button type="submit" class="btn btn-outline-primary">Go</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
