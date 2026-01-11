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
                    <h2 class="mb-0">Edit Profile</h2>
                    <a href="/profile" class="btn btn-outline-secondary"><i class="bi bi-eye me-2"></i>View Profile</a>
                </div>
                
                <form action="/profile/update" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                    
                    <!-- Photo Upload -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-camera text-primary me-2"></i>Profile Photo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="<?= !empty($user['photo']) ? '/uploads/photos/' . $user['photo'] : '/assets/images/default-user.jpg' ?>" 
                                         id="photo-preview" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid var(--primary);">
                                </div>
                                <div class="col">
                                    <input type="file" class="form-control photo-upload-input" id="photo" name="photo" accept="image/*" data-preview="#photo-preview">
                                    <div class="form-text">Max size: 5MB. Formats: JPG, PNG, GIF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-person text-primary me-2"></i>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($user['dob'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Height</label>
                                    <select class="form-select" name="height">
                                        <option value="">Select</option>
                                        <?php 
                                        $heights = ["4'6\"", "4'7\"", "4'8\"", "4'9\"", "4'10\"", "4'11\"", "5'0\"", "5'1\"", "5'2\"", "5'3\"", "5'4\"", "5'5\"", "5'6\"", "5'7\"", "5'8\"", "5'9\"", "5'10\"", "5'11\"", "6'0\"", "6'1\"", "6'2\"", "6'3\"", "6'4\""];
                                        foreach ($heights as $h): ?>
                                            <option value="<?= $h ?>" <?= ($user['height'] ?? '') === $h ? 'selected' : '' ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="text" class="form-control" name="weight" value="<?= htmlspecialchars($user['weight'] ?? '') ?>" placeholder="e.g., 65 kg">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Complexion</label>
                                    <select class="form-select" name="complexion">
                                        <option value="">Select</option>
                                        <?php foreach (['Fair', 'Very Fair', 'Wheatish', 'Wheatish Brown', 'Dark'] as $c): ?>
                                            <option value="<?= $c ?>" <?= ($user['complexion'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Blood Group</label>
                                    <select class="form-select" name="blood_group">
                                        <option value="">Select</option>
                                        <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg): ?>
                                            <option value="<?= $bg ?>" <?= ($user['blood_group'] ?? '') === $bg ? 'selected' : '' ?>><?= $bg ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Marital Status</label>
                                    <select class="form-select" name="marital_status">
                                        <option value="">Select</option>
                                        <?php foreach (['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'] as $ms): ?>
                                            <option value="<?= $ms ?>" <?= ($user['marital_status'] ?? '') === $ms ? 'selected' : '' ?>><?= $ms ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mother Tongue</label>
                                    <select class="form-select" name="mother_tongue">
                                        <option value="">Select</option>
                                        <?php foreach (['Marathi', 'Hindi', 'Gujarati', 'Punjabi', 'Tamil', 'Telugu', 'Kannada', 'Malayalam', 'Bengali', 'Other'] as $mt): ?>
                                            <option value="<?= $mt ?>" <?= ($user['mother_tongue'] ?? '') === $mt ? 'selected' : '' ?>><?= $mt ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Caste Details -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-flag text-primary me-2"></i>Community Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Caste</label>
                                    <select class="form-select" name="caste">
                                        <option value="">Select</option>
                                        <?php foreach (['Mahar', 'Matang', 'Nav-Bauddh', 'Chambhar', 'Banjara', 'Dhor', 'Other'] as $c): ?>
                                            <option value="<?= $c ?>" <?= ($user['caste'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sub Caste</label>
                                    <input type="text" class="form-control" name="sub_caste" value="<?= htmlspecialchars($user['sub_caste'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Education & Career -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Education & Career</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Education</label>
                                    <select class="form-select" name="education">
                                        <option value="">Select</option>
                                        <?php foreach (['High School', '12th Pass', 'Diploma', 'Graduate', 'Post Graduate', 'Doctorate', 'Professional Degree'] as $e): ?>
                                            <option value="<?= $e ?>" <?= ($user['education'] ?? '') === $e ? 'selected' : '' ?>><?= $e ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Occupation</label>
                                    <select class="form-select" name="occupation">
                                        <option value="">Select</option>
                                        <?php foreach (['Private Job', 'Government Job', 'Business', 'Self Employed', 'Doctor', 'Engineer', 'Teacher', 'Lawyer', 'Student', 'Not Working', 'Other'] as $o): ?>
                                            <option value="<?= $o ?>" <?= ($user['occupation'] ?? '') === $o ? 'selected' : '' ?>><?= $o ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Annual Income</label>
                                    <select class="form-select" name="income">
                                        <option value="">Select</option>
                                        <?php foreach (['Below 2 Lakh', '2-4 Lakh', '4-6 Lakh', '6-8 Lakh', '8-10 Lakh', '10-15 Lakh', '15-20 Lakh', '20-30 Lakh', '30-50 Lakh', 'Above 50 Lakh'] as $i): ?>
                                            <option value="<?= $i ?>" <?= ($user['income'] ?? '') === $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <select class="form-select" name="state">
                                        <option value="">Select</option>
                                        <?php foreach (['Maharashtra', 'Karnataka', 'Gujarat', 'Madhya Pradesh', 'Rajasthan', 'Tamil Nadu', 'Andhra Pradesh', 'Telangana', 'Delhi', 'Uttar Pradesh', 'West Bengal', 'Kerala', 'Punjab', 'Haryana', 'Other'] as $s): ?>
                                            <option value="<?= $s ?>" <?= ($user['state'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <select class="form-select" name="country">
                                        <option value="India" selected>India</option>
                                        <option value="USA" <?= ($user['country'] ?? '') === 'USA' ? 'selected' : '' ?>>USA</option>
                                        <option value="UK" <?= ($user['country'] ?? '') === 'UK' ? 'selected' : '' ?>>UK</option>
                                        <option value="Canada" <?= ($user['country'] ?? '') === 'Canada' ? 'selected' : '' ?>>Canada</option>
                                        <option value="Australia" <?= ($user['country'] ?? '') === 'Australia' ? 'selected' : '' ?>>Australia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- About & Expectations -->
                    <div class="card glass-card mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-chat-quote text-primary me-2"></i>About & Expectations</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">About Me</label>
                                <textarea class="form-control" name="about_me" rows="4" placeholder="Write about yourself..."><?= htmlspecialchars($user['about_me'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Family Details</label>
                                <textarea class="form-control" name="family_details" rows="3" placeholder="Describe your family..."><?= htmlspecialchars($user['family_details'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Partner Expectations</label>
                                <textarea class="form-control" name="partner_expectations" rows="3" placeholder="Describe your ideal partner..."><?= htmlspecialchars($user['partner_expectations'] ?? '') ?></textarea>
                            </div>
                            <div>
                                <label class="form-label">Hobbies & Interests</label>
                                <input type="text" class="form-control" name="hobbies" value="<?= htmlspecialchars($user['hobbies'] ?? '') ?>" placeholder="e.g., Reading, Music, Traveling">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-lg me-2"></i>Save Changes
                        </button>
                        <a href="/profile" class="btn btn-outline-secondary btn-lg">Cancel</a>
                    </div>
                </form>
                
                <!-- Change Password -->
                <div class="card glass-card mt-5">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-shield-lock text-primary me-2"></i>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="/profile/change-password" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required minlength="8">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning mt-3">
                                <i class="bi bi-key me-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
