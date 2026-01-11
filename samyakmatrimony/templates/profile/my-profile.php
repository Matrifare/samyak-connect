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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">My Profile</h2>
                    <a href="/profile/edit" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Edit Profile</a>
                </div>
                
                <!-- Profile Header -->
                <div class="card glass-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="<?= !empty($user['photo']) ? '/uploads/photos/' . $user['photo'] : '/assets/images/default-' . strtolower($user['gender'] ?? 'male') . '.jpg' ?>" 
                                     class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 4px solid var(--primary);">
                            </div>
                            <div class="col">
                                <h3 class="mb-1"><?= htmlspecialchars($user['name'] ?? 'User') ?></h3>
                                <p class="text-primary fw-semibold mb-2"><?= htmlspecialchars($user['profile_id'] ?? '') ?></p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary-gradient text-white"><i class="bi bi-calendar3 me-1"></i><?= $user['age'] ?? '25' ?> years</span>
                                    <span class="badge bg-light text-dark"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($user['city'] ?? 'India') ?></span>
                                    <span class="badge bg-light text-dark"><i class="bi bi-mortarboard me-1"></i><?= htmlspecialchars($user['education'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Details (same layout as view.php) -->
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-person text-primary me-2"></i>Basic Information</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 col-6"><label class="text-muted small">Height</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['height'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4 col-6"><label class="text-muted small">Weight</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['weight'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4 col-6"><label class="text-muted small">Complexion</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['complexion'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4 col-6"><label class="text-muted small">Marital Status</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['marital_status'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4 col-6"><label class="text-muted small">Mother Tongue</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['mother_tongue'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4 col-6"><label class="text-muted small">Caste</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['caste'] ?? 'N/A') ?></p></div>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($user['about_me'])): ?>
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-chat-quote text-primary me-2"></i>About Me</h5></div>
                    <div class="card-body"><p class="mb-0"><?= nl2br(htmlspecialchars($user['about_me'])) ?></p></div>
                </div>
                <?php endif; ?>
                
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Education & Career</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="text-muted small">Education</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['education'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4"><label class="text-muted small">Occupation</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['occupation'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4"><label class="text-muted small">Annual Income</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['income'] ?? 'N/A') ?></p></div>
                        </div>
                    </div>
                </div>
                
                <div class="card glass-card">
                    <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-geo-alt text-primary me-2"></i>Location</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="text-muted small">City</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['city'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4"><label class="text-muted small">State</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['state'] ?? 'N/A') ?></p></div>
                            <div class="col-md-4"><label class="text-muted small">Country</label><p class="mb-0 fw-semibold"><?= htmlspecialchars($user['country'] ?? 'India') ?></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
