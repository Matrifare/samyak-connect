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
                        <li class="breadcrumb-item active">Privacy Settings</li>
                    </ol>
                </nav>
                
                <h2 class="mb-4"><i class="bi bi-shield-check text-primary me-2"></i>Privacy Settings</h2>
                
                <form action="/settings/privacy" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <!-- Photo Visibility -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-image me-2"></i>Photo Visibility</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Who can see your photos?</label>
                                <select class="form-select" name="photo_visibility">
                                    <option value="all" <?= ($user['photo_view_status'] ?? 'all') === 'all' ? 'selected' : '' ?>>All Members</option>
                                    <option value="accepted" <?= ($user['photo_view_status'] ?? '') === 'accepted' ? 'selected' : '' ?>>Only Accepted Interests</option>
                                    <option value="none" <?= ($user['photo_view_status'] ?? '') === 'none' ? 'selected' : '' ?>>No One (Hidden)</option>
                                </select>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="photo_protect" id="photo_protect" 
                                       value="1" <?= !empty($user['photo_protect']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="photo_protect">
                                    Password protect my photos
                                </label>
                                <div class="form-text">Members will need to request access to view your photos</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Visibility -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="show_contact" id="show_contact" 
                                       value="1" <?= !empty($user['show_contact']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="show_contact">
                                    Show my contact details to accepted interests
                                </label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_income" id="show_income" 
                                       value="1" <?= !empty($user['show_income']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="show_income">
                                    Show my income to other members
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Visibility -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-eye-slash me-2"></i>Profile Visibility</h5>
                        </div>
                        <div class="card-body">
                            <?php if (($user['status'] ?? '') === 'HIDDEN'): ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-eye-slash me-2"></i>
                                    Your profile is currently hidden.
                                    <?php if (!empty($user['hidden_until'])): ?>
                                        It will be visible again on <?= date('d M Y', strtotime($user['hidden_until'])) ?>.
                                    <?php endif; ?>
                                </div>
                                <form action="/settings/unhide-profile" method="POST" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-eye me-2"></i>Show My Profile
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="text-muted">Temporarily hide your profile from search results.</p>
                                <div class="row align-items-end g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Hide until</label>
                                        <input type="date" class="form-control" id="hide_until" 
                                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" 
                                               max="<?= date('Y-m-d', strtotime('+6 months')) ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-warning" onclick="hideProfile()">
                                            <i class="bi bi-eye-slash me-2"></i>Hide Profile
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
                        </button>
                        <a href="/settings" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function hideProfile() {
    const hideUntil = document.getElementById('hide_until').value;
    if (!hideUntil) {
        alert('Please select a date');
        return;
    }
    
    if (confirm('Are you sure you want to hide your profile? It will not appear in search results.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/settings/hide-profile';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="hide_until" value="${hideUntil}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
