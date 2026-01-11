<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <!-- Search Filters -->
                <div class="card glass-card">
                    <div class="card-header bg-transparent"><h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5></div>
                    <div class="card-body">
                        <form action="/search/results" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Looking For</label>
                                <select name="gender" class="form-select">
                                    <option value="">Any</option>
                                    <option value="Female" <?= ($criteria['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Bride</option>
                                    <option value="Male" <?= ($criteria['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Groom</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Age From</label>
                                    <select name="age_from" class="form-select">
                                        <?php for ($i = 18; $i <= 60; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($criteria['age_from'] ?? 18) == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Age To</label>
                                    <select name="age_to" class="form-select">
                                        <?php for ($i = 18; $i <= 60; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($criteria['age_to'] ?? 60) == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Caste</label>
                                <select name="caste" class="form-select">
                                    <option value="">Any</option>
                                    <option value="Mahar">Mahar</option>
                                    <option value="Matang">Matang</option>
                                    <option value="Nav-Bauddh">Nav-Bauddh</option>
                                    <option value="Chambhar">Chambhar</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" class="form-select">
                                    <option value="">Any</option>
                                    <option value="Never Married">Never Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Search</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><?= isset($totalResults) ? number_format($totalResults) . ' Profiles Found' : 'Search Profiles' ?></h4>
                </div>
                
                <div class="row g-4">
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $profile): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="profile-card">
                                    <div class="profile-image-wrapper">
                                        <img src="<?= !empty($profile['photo']) ? '/uploads/photos/' . $profile['photo'] : '/assets/images/default-' . strtolower($profile['gender']) . '.jpg' ?>" alt="<?= htmlspecialchars($profile['name']) ?>" class="profile-image">
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
                                        <a href="/profile/<?= $profile['profile_id'] ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i> View</a>
                                        <button type="button" class="btn btn-outline-danger" onclick="toggleShortlist(<?= $profile['id'] ?>, this)"><i class="bi bi-heart"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-search display-1 text-muted"></i>
                            <h5 class="mt-3">No profiles found</h5>
                            <p class="text-muted">Try adjusting your search filters</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($criteria, ['page' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
