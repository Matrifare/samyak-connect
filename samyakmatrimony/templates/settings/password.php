<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?>
            </div>
            
            <div class="col-lg-9">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </nav>
                
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card glass-card">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>Change Password</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="/settings/password" method="POST" class="needs-validation" novalidate>
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" name="current_password" required>
                                            <button type="button" class="input-group-text password-toggle"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" name="new_password" id="new_password" 
                                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" required>
                                            <button type="button" class="input-group-text password-toggle"><i class="bi bi-eye"></i></button>
                                        </div>
                                        <div class="form-text">Min 8 characters with uppercase, lowercase, and number</div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                            <button type="button" class="input-group-text password-toggle"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-2"></i>Update Password
                                        </button>
                                        <a href="/settings" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h6><i class="bi bi-info-circle me-2"></i>Password Tips</h6>
                            <ul class="mb-0 small">
                                <li>Use at least 8 characters</li>
                                <li>Include uppercase and lowercase letters</li>
                                <li>Include at least one number</li>
                                <li>Avoid using personal information like your name or birth date</li>
                                <li>Don't reuse passwords from other websites</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('confirm_password').addEventListener('input', function() {
    if (this.value !== document.getElementById('new_password').value) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
