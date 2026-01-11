<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">Find Your Perfect <br>Buddhist Life Partner</h1>
                    <p class="hero-subtitle">
                        Join thousands of verified Buddhist profiles and begin your journey to find true love and companionship.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/register" class="btn btn-white btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Register Free
                        </a>
                        <a href="/search" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-search me-2"></i>Search Profiles
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <!-- Search Box -->
                <div class="hero-search-box">
                    <h4 class="mb-4 text-center">
                        <i class="bi bi-search text-primary me-2"></i>Quick Search
                    </h4>
                    <form action="/search/quick" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Looking For</label>
                            <select name="looking_for" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Female">Bride</option>
                                <option value="Male">Groom</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Caste</label>
                            <select name="caste" class="form-select">
                                <option value="">Any Caste</option>
                                <option value="Mahar">Mahar</option>
                                <option value="Matang">Matang</option>
                                <option value="Nav-Bauddh">Nav-Bauddh</option>
                                <option value="Chambhar">Chambhar</option>
                                <option value="Banjara">Banjara</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Age From</label>
                            <select name="age_from" class="form-select">
                                <?php for ($i = 18; $i <= 60; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == 21 ? 'selected' : '' ?>><?= $i ?> Years</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Age To</label>
                            <select name="age_to" class="form-select">
                                <?php for ($i = 18; $i <= 60; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == 35 ? 'selected' : '' ?>><?= $i ?> Years</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-search me-2"></i>Search Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-number" data-count="<?= $stats['total_profiles'] ?? 5000 ?>"><?= number_format($stats['total_profiles'] ?? 5000) ?>+</div>
                    <div class="stat-label">Registered Profiles</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-gender-male"></i>
                    </div>
                    <div class="stat-number" data-count="<?= $stats['male_profiles'] ?? 2500 ?>"><?= number_format($stats['male_profiles'] ?? 2500) ?>+</div>
                    <div class="stat-label">Groom Profiles</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-gender-female"></i>
                    </div>
                    <div class="stat-number" data-count="<?= $stats['female_profiles'] ?? 2500 ?>"><?= number_format($stats['female_profiles'] ?? 2500) ?>+</div>
                    <div class="stat-label">Bride Profiles</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <div class="stat-number" data-count="<?= $stats['success_stories'] ?? 150 ?>"><?= number_format($stats['success_stories'] ?? 150) ?>+</div>
                    <div class="stat-label">Success Stories</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Profiles -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Featured Profiles</h2>
            <p class="section-subtitle">Discover our verified and premium profiles looking for their life partners</p>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($featuredProfiles)): ?>
                <?php foreach ($featuredProfiles as $profile): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="profile-card">
                            <div class="profile-image-wrapper">
                                <img src="<?= !empty($profile['photo']) ? '/uploads/photos/' . $profile['photo'] : '/assets/images/default-' . strtolower($profile['gender']) . '.jpg' ?>" 
                                     alt="<?= htmlspecialchars($profile['name']) ?>" 
                                     class="profile-image">
                                <?php if (!empty($profile['is_verified'])): ?>
                                    <div class="verified-badge" title="Verified Profile">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="profile-body">
                                <h5 class="profile-name"><?= htmlspecialchars($profile['name']) ?></h5>
                                <p class="profile-id"><?= htmlspecialchars($profile['profile_id']) ?></p>
                                <div class="profile-details">
                                    <span class="profile-detail">
                                        <i class="bi bi-calendar3 me-1"></i><?= $profile['age'] ?? '25' ?> yrs
                                    </span>
                                    <span class="profile-detail">
                                        <i class="bi bi-rulers me-1"></i><?= htmlspecialchars($profile['height'] ?? '5\'5"') ?>
                                    </span>
                                    <span class="profile-detail">
                                        <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($profile['city'] ?? 'Mumbai') ?>
                                    </span>
                                </div>
                            </div>
                            <div class="profile-actions">
                                <a href="/profile/<?= $profile['profile_id'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="toggleShortlist(<?= $profile['id'] ?>, this)">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Sample profiles when database is empty -->
                <?php 
                $sampleProfiles = [
                    ['name' => 'Priya Sharma', 'id' => 'SF001', 'age' => 25, 'height' => "5'4\"", 'city' => 'Mumbai', 'gender' => 'Female'],
                    ['name' => 'Rahul Kamble', 'id' => 'SM001', 'age' => 28, 'height' => "5'8\"", 'city' => 'Pune', 'gender' => 'Male'],
                    ['name' => 'Anjali More', 'id' => 'SF002', 'age' => 24, 'height' => "5'3\"", 'city' => 'Nagpur', 'gender' => 'Female'],
                    ['name' => 'Amit Jadhav', 'id' => 'SM002', 'age' => 30, 'height' => "5'10\"", 'city' => 'Delhi', 'gender' => 'Male'],
                ];
                foreach ($sampleProfiles as $profile): 
                ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="profile-card">
                            <div class="profile-image-wrapper">
                                <img src="/assets/images/default-<?= strtolower($profile['gender']) ?>.jpg" 
                                     alt="<?= $profile['name'] ?>" 
                                     class="profile-image">
                                <div class="verified-badge" title="Verified Profile">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                            </div>
                            <div class="profile-body">
                                <h5 class="profile-name"><?= $profile['name'] ?></h5>
                                <p class="profile-id"><?= $profile['id'] ?></p>
                                <div class="profile-details">
                                    <span class="profile-detail">
                                        <i class="bi bi-calendar3 me-1"></i><?= $profile['age'] ?> yrs
                                    </span>
                                    <span class="profile-detail">
                                        <i class="bi bi-rulers me-1"></i><?= $profile['height'] ?>
                                    </span>
                                    <span class="profile-detail">
                                        <i class="bi bi-geo-alt me-1"></i><?= $profile['city'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="profile-actions">
                                <a href="/register" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <button type="button" class="btn btn-outline-danger">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="/search" class="btn btn-primary btn-lg">
                <i class="bi bi-grid me-2"></i>View All Profiles
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Find your perfect match in just 4 simple steps</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5 class="step-title">Register Free</h5>
                    <p class="step-description">Create your profile in minutes with your basic details and preferences.</p>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5 class="step-title">Complete Profile</h5>
                    <p class="step-description">Add photos, family details, and partner preferences to get better matches.</p>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5 class="step-title">Search & Connect</h5>
                    <p class="step-description">Browse profiles, send interests, and connect with potential matches.</p>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h5 class="step-title">Find Your Match</h5>
                    <p class="step-description">Communicate with interested profiles and find your life partner.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories -->
<section class="success-stories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Success Stories</h2>
            <p class="section-subtitle">Real couples who found love on Samyak Matrimony</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="story-card text-center">
                    <img src="/assets/images/couple-1.jpg" alt="Rahul & Priya" class="story-couple-image">
                    <p class="story-quote">
                        We found each other on Samyak Matrimony and knew instantly that we were meant to be together. Thank you for making this possible!
                    </p>
                    <h5 class="story-names">Rahul & Priya</h5>
                    <p class="story-date">Married in December 2023</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="story-card text-center">
                    <img src="/assets/images/couple-2.jpg" alt="Amit & Sneha" class="story-couple-image">
                    <p class="story-quote">
                        After searching for years, we finally found each other here. The matching system really works! We are grateful forever.
                    </p>
                    <h5 class="story-names">Amit & Sneha</h5>
                    <p class="story-date">Married in February 2024</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="story-card text-center">
                    <img src="/assets/images/couple-3.jpg" alt="Vikram & Anjali" class="story-couple-image">
                    <p class="story-quote">
                        A perfect platform for Buddhist community. We connected, met, and married within 6 months. Highly recommended!
                    </p>
                    <h5 class="story-names">Vikram & Anjali</h5>
                    <p class="story-date">Married in March 2024</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="/success-stories" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-heart me-2"></i>Read More Stories
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Find Your Perfect Match?</h2>
            <p class="cta-subtitle">Join thousands of happy couples who found love on Samyak Matrimony. Register today - it's free!</p>
            <a href="/register" class="btn btn-white btn-lg">
                <i class="bi bi-person-plus me-2"></i>Register Free Now
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
