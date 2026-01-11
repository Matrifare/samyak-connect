<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <!-- Profile Photo & Actions -->
            <div class="col-lg-4">
                <div class="card glass-card text-center p-4 sticky-lg-top" style="top: 100px;">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="<?= !empty($profile['photo']) ? '/uploads/photos/' . $profile['photo'] : '/assets/images/default-' . strtolower($profile['gender'] ?? 'male') . '.jpg' ?>" 
                             class="rounded-circle" width="180" height="180" style="object-fit: cover; border: 4px solid var(--primary);">
                        <?php if (!empty($profile['is_verified'])): ?>
                            <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-2" title="Verified">
                                <i class="bi bi-check-lg"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <h4 class="mb-1"><?= htmlspecialchars($profile['name'] ?? 'User') ?></h4>
                    <p class="text-primary fw-semibold mb-3"><?= htmlspecialchars($profile['profile_id'] ?? '') ?></p>
                    
                    <div class="d-flex gap-2 justify-content-center flex-wrap mb-3">
                        <span class="badge bg-light text-dark"><i class="bi bi-calendar3 me-1"></i><?= $profile['age'] ?? '25' ?> years</span>
                        <span class="badge bg-light text-dark"><i class="bi bi-rulers me-1"></i><?= htmlspecialchars($profile['height'] ?? 'N/A') ?></span>
                        <span class="badge bg-light text-dark"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($profile['city'] ?? 'India') ?></span>
                    </div>
                    
                    <?php if (\App\Core\Session::isLoggedIn() && $profile['id'] != \App\Core\Session::getUserId()): ?>
                        <div class="d-grid gap-2">
                            <?php if ($interestStatus === 'accepted'): ?>
                                <a href="/messages/<?= $profile['id'] ?>" class="btn btn-success">
                                    <i class="bi bi-chat-dots me-2"></i>Send Message
                                </a>
                            <?php elseif ($interestStatus === 'pending'): ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-clock me-2"></i>Interest Pending
                                </button>
                            <?php elseif ($interestStatus === 'sent'): ?>
                                <button class="btn btn-info text-white" disabled>
                                    <i class="bi bi-check me-2"></i>Interest Sent
                                </button>
                            <?php else: ?>
                                <button class="btn btn-primary" onclick="sendInterest(<?= $profile['id'] ?>, this)">
                                    <i class="bi bi-heart me-2"></i>Send Interest
                                </button>
                            <?php endif; ?>
                            
                            <button class="btn <?= $isShortlisted ? 'btn-danger' : 'btn-outline-danger' ?>" onclick="toggleShortlist(<?= $profile['id'] ?>, this)">
                                <i class="bi bi-bookmark<?= $isShortlisted ? '-fill' : '' ?> me-2"></i><?= $isShortlisted ? 'Shortlisted' : 'Add to Shortlist' ?>
                            </button>
                        </div>
                    <?php elseif (!\App\Core\Session::isLoggedIn()): ?>
                        <a href="/login" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login to Connect
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Profile Details -->
            <div class="col-lg-8">
                <!-- Basic Info -->
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-person text-primary me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Name</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['name'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Age</label>
                                <p class="mb-0 fw-semibold"><?= $profile['age'] ?? 'N/A' ?> years</p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Height</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['height'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Weight</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['weight'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Complexion</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['complexion'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Blood Group</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['blood_group'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Marital Status</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['marital_status'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Mother Tongue</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['mother_tongue'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Religion</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['religion'] ?? 'Buddhist') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- About Me -->
                <?php if (!empty($profile['about_me'])): ?>
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-chat-quote text-primary me-2"></i>About Me</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(htmlspecialchars($profile['about_me'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Education & Career -->
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Education & Career</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Education</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['education'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Occupation</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['occupation'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Annual Income</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['income'] ?? 'N/A') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Location -->
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-geo-alt text-primary me-2"></i>Location</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">City</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['city'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">State</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['state'] ?? 'N/A') ?></p>
                            </div>
                            <div class="col-md-4 col-6">
                                <label class="text-muted small">Country</label>
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($profile['country'] ?? 'India') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Family Details -->
                <?php if (!empty($profile['family_details'])): ?>
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-people text-primary me-2"></i>Family Details</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(htmlspecialchars($profile['family_details'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Partner Expectations -->
                <?php if (!empty($profile['partner_expectations'])): ?>
                <div class="card glass-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-heart text-primary me-2"></i>Partner Expectations</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= nl2br(htmlspecialchars($profile['partner_expectations'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
