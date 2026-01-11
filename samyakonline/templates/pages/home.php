<?php
/**
 * Homepage Template
 * Modern Hero with Search
 */

$pageTitle = 'Home';
$currentPage = 'home';
include __DIR__ . '/../layouts/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge animate-fade-in">
                <i class="fas fa-star"></i> India's #1 Buddhist Matrimony
            </span>
            
            <h1 class="hero-title animate-fade-in">
                Find Your <span class="text-gradient">Perfect</span> Life Partner
            </h1>
            
            <p class="hero-subtitle animate-fade-in">
                Join thousands of verified Buddhist profiles. Start your journey 
                to finding lasting love and companionship.
            </p>
            
            <!-- Quick Search Form -->
            <div class="hero-search glass-effect animate-fade-in">
                <form action="/search" method="GET" class="search-form">
                    <div class="search-grid">
                        <div class="search-field">
                            <label>I'm looking for</label>
                            <select name="gender" class="form-control">
                                <option value="Bride">Bride</option>
                                <option value="Groom">Groom</option>
                            </select>
                        </div>
                        
                        <div class="search-field">
                            <label>Age</label>
                            <div class="age-range">
                                <select name="min_age" class="form-control">
                                    <?php for ($i = 18; $i <= 60; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i === 21 ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span>to</span>
                                <select name="max_age" class="form-control">
                                    <?php for ($i = 18; $i <= 60; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i === 35 ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="search-field">
                            <label>Religion</label>
                            <select name="religion" class="form-control">
                                <option value="">Any</option>
                                <option value="1" selected>Buddhist</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg btn-glow">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Stats -->
            <div class="hero-stats animate-fade-in">
                <div class="stat-item">
                    <span class="stat-number" data-count="50000">0</span>
                    <span class="stat-label">Verified Profiles</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="25000">0</span>
                    <span class="stat-label">Happy Couples</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="15">0</span>
                    <span class="stat-label">Years Experience</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features py-16">
    <div class="container">
        <div class="section-header text-center mb-12">
            <h2 class="section-title">Why Choose <span class="text-gradient">Samyak Matrimony</span></h2>
            <p class="section-subtitle">
                We're dedicated to helping Buddhist singles find their perfect match
            </p>
        </div>
        
        <div class="grid grid-cols-3 gap-6">
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>100% Verified Profiles</h3>
                <p>Every profile is manually verified by our team to ensure authenticity and safety.</p>
            </div>
            
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Secure & Private</h3>
                <p>Your privacy is our priority. Control who sees your profile and contact details.</p>
            </div>
            
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-dharmachakra"></i>
                </div>
                <h3>Buddhist Community</h3>
                <p>Exclusively for the Buddhist community, ensuring cultural and spiritual compatibility.</p>
            </div>
            
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Advanced Search</h3>
                <p>Find your ideal match with our comprehensive search filters and preferences.</p>
            </div>
            
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Access your profile and connect with matches anytime, anywhere on any device.</p>
            </div>
            
            <div class="feature-card glass-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Our dedicated support team is always here to help you on your journey.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works py-16 bg-gradient">
    <div class="container">
        <div class="section-header text-center mb-12">
            <h2 class="section-title text-white">How It Works</h2>
            <p class="section-subtitle text-white-muted">
                Finding your perfect partner is easy with Samyak Matrimony
            </p>
        </div>
        
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Create Profile</h3>
                    <p>Register and create your detailed profile with photos</p>
                </div>
            </div>
            
            <div class="step-connector"></div>
            
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Search Matches</h3>
                    <p>Browse profiles and find compatible matches</p>
                </div>
            </div>
            
            <div class="step-connector"></div>
            
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Connect</h3>
                    <p>Express interest and start conversations</p>
                </div>
            </div>
            
            <div class="step-connector"></div>
            
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Get Married</h3>
                    <p>Find your life partner and begin your journey</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/register" class="btn btn-lg" style="background: white; color: var(--primary-500);">
                <i class="fas fa-user-plus"></i> Register Free Now
            </a>
        </div>
    </div>
</section>

<!-- Featured Profiles -->
<section class="featured-profiles py-16">
    <div class="container">
        <div class="section-header text-center mb-12">
            <h2 class="section-title">Featured <span class="text-gradient">Profiles</span></h2>
            <p class="section-subtitle">
                Meet some of our verified members looking for their life partner
            </p>
        </div>
        
        <div class="grid grid-cols-4 gap-6">
            <!-- Profile cards will be loaded dynamically -->
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="card profile-card">
                <div class="card-img">
                    <img src="images/no-photo.jpg" alt="Profile Photo" loading="lazy">
                    <span class="card-badge"><i class="fas fa-check-circle"></i> Verified</span>
                </div>
                <div class="card-info">
                    <h3 class="card-title">Username</h3>
                    <p class="card-subtitle">25 yrs, 5'4" • Mumbai</p>
                </div>
                <div class="card-actions">
                    <button class="btn btn-sm btn-outline" onclick="ProfileActions.toggleShortlist('ID', this)">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="btn btn-sm btn-primary" onclick="ProfileActions.sendInterest('ID', this)">
                        <i class="fas fa-paper-plane"></i> Interest
                    </button>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        
        <div class="text-center mt-8">
            <a href="/search" class="btn btn-outline btn-lg">
                View All Profiles <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Success Stories -->
<section class="success-stories py-16 bg-tertiary">
    <div class="container">
        <div class="section-header text-center mb-12">
            <h2 class="section-title">Success <span class="text-gradient">Stories</span></h2>
            <p class="section-subtitle">
                Real couples who found love on Samyak Matrimony
            </p>
        </div>
        
        <div class="stories-slider">
            <div class="story-card glass-card">
                <div class="story-couple">
                    <img src="images/success/default-couple.jpg" alt="Happy Couple" loading="lazy" onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:200px;background:linear-gradient(135deg,var(--primary-500),var(--secondary-500));display:flex;align-items:center;justify-content:center;color:white;font-size:3rem;\'><i class=\'fas fa-heart\'></i></div>'">
                </div>
                <div class="story-content">
                    <h3>Rahul & Priya</h3>
                    <p class="story-date">Married on Dec 2023</p>
                    <p class="story-text">
                        "We found each other on Samyak Matrimony and instantly connected. 
                        Thank you for helping us find our perfect match!"
                    </p>
                    <div class="story-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="/success-stories" class="btn btn-outline">
                Read More Stories <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta py-16">
    <div class="container">
        <div class="cta-card glass-effect">
            <div class="cta-content">
                <h2>Start Your Journey Today</h2>
                <p>Join thousands of happy couples who found their perfect match on Samyak Matrimony</p>
            </div>
            <div class="cta-actions">
                <a href="/register" class="btn btn-primary btn-lg btn-glow">
                    <i class="fas fa-user-plus"></i> Register Free
                </a>
                <a href="/search" class="btn btn-outline btn-lg">
                    <i class="fas fa-search"></i> Search Profiles
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Styles */
.hero {
    position: relative;
    min-height: 90vh;
    display: flex;
    align-items: center;
    padding: var(--spacing-20) 0;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    z-index: -1;
}

.hero-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, 
        rgba(245, 135, 37, 0.1) 0%, 
        rgba(124, 58, 237, 0.1) 50%,
        rgba(16, 185, 129, 0.1) 100%);
}

.hero-pattern {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 2px 2px, var(--border-color) 1px, transparent 0);
    background-size: 40px 40px;
    opacity: 0.5;
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    padding: var(--spacing-2) var(--spacing-4);
    background: rgba(245, 135, 37, 0.1);
    border: 1px solid rgba(245, 135, 37, 0.3);
    border-radius: var(--radius-full);
    color: var(--primary-500);
    font-weight: 600;
    margin-bottom: var(--spacing-6);
}

.hero-title {
    font-family: var(--font-display);
    font-size: var(--text-5xl);
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: var(--spacing-6);
}

.hero-subtitle {
    font-size: var(--text-xl);
    color: var(--text-secondary);
    margin-bottom: var(--spacing-8);
}

.hero-search {
    padding: var(--spacing-6);
    border-radius: var(--radius-2xl);
    margin-bottom: var(--spacing-8);
}

.search-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--spacing-4);
    align-items: end;
}

@media (max-width: 768px) {
    .search-grid {
        grid-template-columns: 1fr;
    }
}

.search-field label {
    display: block;
    font-size: var(--text-sm);
    font-weight: 500;
    margin-bottom: var(--spacing-2);
}

.age-range {
    display: flex;
    align-items: center;
    gap: var(--spacing-2);
}

.age-range select {
    flex: 1;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: var(--spacing-12);
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: var(--text-4xl);
    font-weight: 700;
    color: var(--primary-500);
}

.stat-label {
    font-size: var(--text-sm);
    color: var(--text-tertiary);
}

/* Features */
.feature-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-500), var(--secondary-500));
    border-radius: var(--radius-xl);
    color: white;
    font-size: var(--text-2xl);
    margin-bottom: var(--spacing-4);
}

.feature-card h3 {
    font-size: var(--text-lg);
    font-weight: 600;
    margin-bottom: var(--spacing-2);
}

.feature-card p {
    color: var(--text-secondary);
    font-size: var(--text-sm);
}

/* How It Works */
.bg-gradient {
    background: linear-gradient(135deg, var(--primary-500), var(--secondary-500));
}

.text-white-muted {
    color: rgba(255, 255, 255, 0.8);
}

.steps-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-4);
}

@media (max-width: 768px) {
    .steps-container {
        flex-direction: column;
    }
    
    .step-connector {
        width: 2px !important;
        height: 40px !important;
    }
}

.step {
    text-align: center;
    color: white;
}

.step-number {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid white;
    border-radius: var(--radius-full);
    font-size: var(--text-2xl);
    font-weight: 700;
    margin: 0 auto var(--spacing-4);
}

.step-content h3 {
    font-size: var(--text-lg);
    margin-bottom: var(--spacing-2);
}

.step-content p {
    font-size: var(--text-sm);
    opacity: 0.8;
}

.step-connector {
    width: 60px;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
}

/* CTA */
.cta-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--spacing-10);
    border-radius: var(--radius-2xl);
    background: linear-gradient(135deg, 
        rgba(245, 135, 37, 0.1), 
        rgba(124, 58, 237, 0.1));
}

@media (max-width: 768px) {
    .cta-card {
        flex-direction: column;
        text-align: center;
        gap: var(--spacing-6);
    }
}

.cta-content h2 {
    font-size: var(--text-3xl);
    margin-bottom: var(--spacing-2);
}

.cta-content p {
    color: var(--text-secondary);
}

.cta-actions {
    display: flex;
    gap: var(--spacing-4);
}

@media (max-width: 640px) {
    .cta-actions {
        flex-direction: column;
    }
}

/* Stories */
.story-card {
    display: flex;
    gap: var(--spacing-6);
    max-width: 600px;
    margin: 0 auto;
}

@media (max-width: 640px) {
    .story-card {
        flex-direction: column;
    }
}

.story-couple img {
    width: 200px;
    height: 200px;
    border-radius: var(--radius-xl);
    object-fit: cover;
}

.story-content h3 {
    font-size: var(--text-xl);
    margin-bottom: var(--spacing-1);
}

.story-date {
    font-size: var(--text-sm);
    color: var(--primary-500);
    margin-bottom: var(--spacing-3);
}

.story-text {
    font-style: italic;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-3);
}

.story-rating {
    color: var(--accent-gold);
}

.bg-tertiary {
    background: var(--bg-tertiary);
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
