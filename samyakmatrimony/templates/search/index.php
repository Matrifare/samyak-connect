<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Search Profiles</h1>
            <p class="section-subtitle">Find your perfect Buddhist life partner</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Quick Search by Profile ID -->
                <div class="card glass-card mb-4">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-person-badge text-primary me-2"></i>Search by Profile ID</h5>
                        <form action="/search/profile-id" method="GET" class="d-flex gap-2">
                            <input type="text" class="form-control" name="profile_id" placeholder="Enter Profile ID (e.g., SM12345)" required>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                </div>
                
                <!-- Main Search Form -->
                <div class="card glass-card">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="bi bi-funnel text-primary me-2"></i>Advanced Search</h5>
                        <form action="/search/results" method="GET">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Looking For</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Any</option>
                                        <option value="Female">Bride</option>
                                        <option value="Male">Groom</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Caste</label>
                                    <select name="caste" class="form-select">
                                        <option value="">Any</option>
                                        <option value="Mahar">Mahar</option>
                                        <option value="Matang">Matang</option>
                                        <option value="Nav-Bauddh">Nav-Bauddh</option>
                                        <option value="Chambhar">Chambhar</option>
                                        <option value="Banjara">Banjara</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Age From</label>
                                    <select name="age_from" class="form-select">
                                        <?php for ($i = 18; $i <= 60; $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == 21 ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Age To</label>
                                    <select name="age_to" class="form-select">
                                        <?php for ($i = 18; $i <= 60; $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == 35 ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Marital Status</label>
                                    <select name="marital_status" class="form-select">
                                        <option value="">Any</option>
                                        <option value="Never Married">Never Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Education</label>
                                    <select name="education" class="form-select">
                                        <option value="">Any</option>
                                        <option value="High School">High School</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                        <option value="Doctorate">Doctorate</option>
                                        <option value="Professional Degree">Professional Degree</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Occupation</label>
                                    <select name="occupation" class="form-select">
                                        <option value="">Any</option>
                                        <option value="Private Job">Private Job</option>
                                        <option value="Government Job">Government Job</option>
                                        <option value="Business">Business</option>
                                        <option value="Doctor">Doctor</option>
                                        <option value="Engineer">Engineer</option>
                                        <option value="Teacher">Teacher</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <select name="state" class="form-select">
                                        <option value="">Any</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-search me-2"></i>Search Profiles
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
