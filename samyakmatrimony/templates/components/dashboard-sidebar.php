<div class="dashboard-sidebar">
    <div class="text-center mb-4">
        <img src="<?= !empty(\App\Core\Session::get('user_photo')) ? '/uploads/photos/' . \App\Core\Session::get('user_photo') : '/assets/images/default-user.jpg' ?>" 
             class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover; border: 3px solid var(--primary);">
        <h6 class="mb-1"><?= htmlspecialchars(\App\Core\Session::get('user_name', 'User')) ?></h6>
        <small class="text-muted"><?= \App\Core\Session::get('user_profile_id', '') ?></small>
    </div>
    
    <ul class="sidebar-menu">
        <li><a href="/dashboard" class="<?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="/profile" class="<?= $_SERVER['REQUEST_URI'] === '/profile' ? 'active' : '' ?>"><i class="bi bi-person"></i> My Profile</a></li>
        <li><a href="/profile/edit" class="<?= strpos($_SERVER['REQUEST_URI'], '/profile/edit') === 0 ? 'active' : '' ?>"><i class="bi bi-pencil-square"></i> Edit Profile</a></li>
        <li><a href="/messages" class="<?= strpos($_SERVER['REQUEST_URI'], '/messages') === 0 ? 'active' : '' ?>"><i class="bi bi-envelope"></i> Messages</a></li>
        <li><a href="/interests/received" class="<?= strpos($_SERVER['REQUEST_URI'], '/interests') === 0 ? 'active' : '' ?>"><i class="bi bi-heart"></i> Interests</a></li>
        <li><a href="/shortlist" class="<?= strpos($_SERVER['REQUEST_URI'], '/shortlist') === 0 ? 'active' : '' ?>"><i class="bi bi-bookmark"></i> Shortlist</a></li>
        <li><a href="/search" class="<?= strpos($_SERVER['REQUEST_URI'], '/search') === 0 ? 'active' : '' ?>"><i class="bi bi-search"></i> Search</a></li>
        <li><hr class="my-2"></li>
        <li><a href="/logout" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>
