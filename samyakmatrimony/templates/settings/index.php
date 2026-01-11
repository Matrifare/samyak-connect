<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <h2 class="mb-4"><i class="bi bi-gear text-primary me-2"></i>Account Settings</h2>
                
                <!-- Settings Cards -->
                <div class="row g-4">
                    <!-- Profile Settings -->
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="settings-icon bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Profile Settings</h5>
                                        <small class="text-muted">Update your profile information</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Manage your personal details, photos, and partner preferences.</p>
                                <a href="/profile/edit" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Settings -->
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="settings-icon bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Change Password</h5>
                                        <small class="text-muted">Update your login password</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Keep your account secure by using a strong password.</p>
                                <a href="/settings/password" class="btn btn-outline-warning">
                                    <i class="bi bi-key me-2"></i>Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Privacy Settings -->
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="settings-icon bg-info bg-opacity-10 text-info">
                                        <i class="bi bi-eye-slash"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Privacy Settings</h5>
                                        <small class="text-muted">Control who can see your profile</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Manage photo visibility, contact display, and profile hide options.</p>
                                <a href="/settings/privacy" class="btn btn-outline-info">
                                    <i class="bi bi-shield-check me-2"></i>Manage Privacy
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification Settings -->
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="settings-icon bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-bell"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Notifications</h5>
                                        <small class="text-muted">Email and SMS preferences</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Choose which notifications you want to receive.</p>
                                <a href="/settings/notifications" class="btn btn-outline-success">
                                    <i class="bi bi-bell me-2"></i>Manage Notifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Info -->
                <div class="card glass-card mt-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="text-muted small">Profile ID</label>
                                <p class="mb-0 fw-semibold text-primary"><?= htmlspecialchars($user['matri_id'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Email</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Mobile</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($user['mobile'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Account Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-<?= ($user['status'] ?? '') === 'APPROVED' ? 'success' : 'warning' ?>">
                                        <?= htmlspecialchars($user['status'] ?? 'Active') ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Member Since</label>
                                <p class="mb-0 fw-semibold"><?= isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A' ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Last Login</label>
                                <p class="mb-0 fw-semibold"><?= isset($user['last_login']) ? date('d M Y, H:i', strtotime($user['last_login'])) : 'N/A' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Danger Zone -->
                <div class="card border-danger mt-4">
                    <div class="card-header bg-danger bg-opacity-10 border-danger">
                        <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Delete Account</h6>
                                <p class="text-muted mb-0 small">Permanently delete your account and all data. This action cannot be undone.</p>
                            </div>
                            <a href="/settings/delete-account" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-2"></i>Delete Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.settings-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
