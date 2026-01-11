<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3"><?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?></div>
            
            <div class="col-lg-9">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item"><a class="nav-link" href="/interests/received"><i class="bi bi-inbox me-2"></i>Received</a></li>
                    <li class="nav-item"><a class="nav-link" href="/interests/sent"><i class="bi bi-send me-2"></i>Sent</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/interests/accepted"><i class="bi bi-heart me-2"></i>Accepted (<?= $totalInterests ?? 0 ?>)</a></li>
                </ul>
                
                <h2 class="mb-4">Accepted Interests</h2>
                
                <?php if (!empty($interests)): ?>
                    <div class="row g-4">
                        <?php foreach ($interests as $interest): ?>
                            <div class="col-md-6">
                                <div class="card glass-card border-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= !empty($interest['photo']) ? '/uploads/photos/' . $interest['photo'] : '/assets/images/default-user.jpg' ?>" class="rounded-circle me-3" width="70" height="70" style="object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><?= htmlspecialchars($interest['name']) ?></h6>
                                                <small class="text-primary"><?= htmlspecialchars($interest['profile_id']) ?></small>
                                                <div class="mt-1"><span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Matched</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent d-flex gap-2">
                                        <a href="/profile/<?= $interest['profile_id'] ?>" class="btn btn-outline-primary btn-sm flex-fill"><i class="bi bi-eye"></i> View</a>
                                        <a href="/messages/<?= $interest['user_id'] ?>" class="btn btn-success btn-sm flex-fill"><i class="bi bi-chat-dots"></i> Message</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (($totalPages ?? 1) > 1): ?><nav class="mt-4"><ul class="pagination justify-content-center"><?php for ($i = 1; $i <= $totalPages; $i++): ?><li class="page-item <?= $i == ($currentPage ?? 1) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li><?php endfor; ?></ul></nav><?php endif; ?>
                <?php else: ?>
                    <div class="card glass-card"><div class="card-body text-center py-5"><i class="bi bi-heart display-1 text-muted mb-3"></i><h5>No Accepted Interests Yet</h5><p class="text-muted">When your interests are accepted, they'll appear here!</p></div></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
