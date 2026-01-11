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
                    <div>
                        <h2 class="mb-1">Welcome, <?= htmlspecialchars($user['name'] ?? 'User') ?>!</h2>
                        <p class="text-muted mb-0">Profile ID: <span class="text-primary fw-semibold"><?= htmlspecialchars($user['profile_id'] ?? 'N/A') ?></span></p>
                    </div>
                    <a href="/profile/edit" class="btn btn-outline-primary"><i class="bi bi-pencil me-2"></i>Edit Profile</a>
                </div>
                
                <!-- Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon"><i class="bi bi-eye"></i></div>
                            <div class="dashboard-stat-content">
                                <h3><?= $stats['profile_views'] ?? 0 ?></h3>
                                <p>Profile Views</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, #e91e8c, #ff6b9d);"><i class="bi bi-heart"></i></div>
                            <div class="dashboard-stat-content">
                                <h3><?= $stats['interests_received'] ?? 0 ?></h3>
                                <p>Interests Received</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, #6c5ce7, #a29bfe);"><i class="bi bi-send"></i></div>
                            <div class="dashboard-stat-content">
                                <h3><?= $stats['interests_sent'] ?? 0 ?></h3>
                                <p>Interests Sent</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, #00cec9, #81ecec);"><i class="bi bi-bookmark"></i></div>
                            <div class="dashboard-stat-content">
                                <h3><?= $stats['shortlisted_by'] ?? 0 ?></h3>
                                <p>Shortlisted By</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-eye text-primary me-2"></i>Recent Visitors</h5></div>
                            <div class="card-body">
                                <?php if (!empty($recentViews)): ?>
                                    <?php foreach ($recentViews as $view): ?>
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="<?= !empty($view['photo']) ? '/uploads/photos/' . $view['photo'] : '/assets/images/default-user.jpg' ?>" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><?= htmlspecialchars($view['name']) ?></h6>
                                                <small class="text-muted"><?= $view['profile_id'] ?></small>
                                            </div>
                                            <a href="/profile/<?= $view['profile_id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted text-center py-4">No recent visitors yet</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card glass-card h-100">
                            <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-heart text-danger me-2"></i>Recent Interests</h5></div>
                            <div class="card-body">
                                <?php if (!empty($recentInterests)): ?>
                                    <?php foreach ($recentInterests as $interest): ?>
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="<?= !empty($interest['photo']) ? '/uploads/photos/' . $interest['photo'] : '/assets/images/default-user.jpg' ?>" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><?= htmlspecialchars($interest['name']) ?></h6>
                                                <small class="text-muted"><?= $interest['profile_id'] ?></small>
                                            </div>
                                            <button class="btn btn-sm btn-success me-1" onclick="acceptInterest(<?= $interest['id'] ?>, this)"><i class="bi bi-check"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="declineInterest(<?= $interest['id'] ?>, this)"><i class="bi bi-x"></i></button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted text-center py-4">No new interests</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
