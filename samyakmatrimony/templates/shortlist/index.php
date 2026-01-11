<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3"><?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?></div>
            
            <div class="col-lg-9">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item"><a class="nav-link active" href="/shortlist"><i class="bi bi-bookmark me-2"></i>My Shortlist (<?= $totalShortlisted ?? 0 ?>)</a></li>
                    <li class="nav-item"><a class="nav-link" href="/shortlist/by"><i class="bi bi-people me-2"></i>Shortlisted By</a></li>
                </ul>
                
                <h2 class="mb-4">My Shortlist</h2>
                
                <?php if (!empty($shortlisted)): ?>
                    <div class="row g-4">
                        <?php foreach ($shortlisted as $profile): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="profile-card">
                                    <div class="profile-image-wrapper">
                                        <img src="<?= !empty($profile['photo']) ? '/uploads/photos/' . $profile['photo'] : '/assets/images/default-' . strtolower($profile['gender'] ?? 'male') . '.jpg' ?>" alt="<?= htmlspecialchars($profile['name']) ?>" class="profile-image">
                                    </div>
                                    <div class="profile-body">
                                        <h5 class="profile-name"><?= htmlspecialchars($profile['name']) ?></h5>
                                        <p class="profile-id"><?= htmlspecialchars($profile['profile_id']) ?></p>
                                        <div class="profile-details">
                                            <span class="profile-detail"><i class="bi bi-calendar3 me-1"></i><?= $profile['age'] ?? '25' ?> yrs</span>
                                            <span class="profile-detail"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($profile['city'] ?? 'India') ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-actions">
                                        <a href="/profile/<?= $profile['profile_id'] ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                        <button class="btn btn-primary flex-fill" onclick="sendInterest(<?= $profile['id'] ?>, this)"><i class="bi bi-heart me-1"></i>Send Interest</button>
                                        <button class="btn btn-danger" onclick="toggleShortlist(<?= $profile['id'] ?>, this)"><i class="bi bi-bookmark-x"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (($totalPages ?? 1) > 1): ?><nav class="mt-4"><ul class="pagination justify-content-center"><?php for ($i = 1; $i <= $totalPages; $i++): ?><li class="page-item <?= $i == ($currentPage ?? 1) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li><?php endfor; ?></ul></nav><?php endif; ?>
                <?php else: ?>
                    <div class="card glass-card"><div class="card-body text-center py-5"><i class="bi bi-bookmark display-1 text-muted mb-3"></i><h5>No Shortlisted Profiles</h5><p class="text-muted">Save profiles you like to view them later!</p><a href="/search" class="btn btn-primary"><i class="bi bi-search me-2"></i>Search Profiles</a></div></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
