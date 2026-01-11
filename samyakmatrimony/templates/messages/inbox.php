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
                    <h2 class="mb-0">Messages</h2>
                    <span class="badge bg-primary rounded-pill"><?= $unreadCount ?? 0 ?> unread</span>
                </div>
                
                <?php if (!empty($conversations)): ?>
                    <div class="card glass-card">
                        <div class="list-group list-group-flush">
                            <?php foreach ($conversations as $conv): ?>
                                <a href="/messages/<?= $conv['other_user_id'] ?>" class="list-group-item list-group-item-action d-flex align-items-center p-3 <?= $conv['unread'] ? 'bg-light' : '' ?>">
                                    <div class="position-relative me-3">
                                        <img src="<?= !empty($conv['photo']) ? '/uploads/photos/' . $conv['photo'] : '/assets/images/default-user.jpg' ?>" 
                                             class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                        <?php if ($conv['unread']): ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                <?= $conv['unread_count'] ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 <?= $conv['unread'] ? 'fw-bold' : '' ?>"><?= htmlspecialchars($conv['name']) ?></h6>
                                            <small class="text-muted"><?= date('M d', strtotime($conv['last_message_at'])) ?></small>
                                        </div>
                                        <small class="text-muted"><?= htmlspecialchars($conv['profile_id']) ?></small>
                                        <p class="mb-0 text-muted small text-truncate" style="max-width: 300px;">
                                            <?= htmlspecialchars($conv['last_message']) ?>
                                        </p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card glass-card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-chat-dots display-1 text-muted mb-3"></i>
                            <h5>No Messages Yet</h5>
                            <p class="text-muted mb-4">Start connecting with profiles to begin messaging.</p>
                            <a href="/search" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Search Profiles
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
