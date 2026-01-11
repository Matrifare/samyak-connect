<?php 
$formData = \App\Core\Session::get('form_data', []);
\App\Core\Session::remove('form_data');
include __DIR__ . '/../layouts/header.php'; 
?>

<section class="auth-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="auth-card">
                    <div class="auth-card-body">
                        <div class="text-center mb-4">
                            <a href="/" class="navbar-brand d-inline-block mb-3">
                                <span class="text-gradient">Samyak</span> Matrimony
                            </a>
                            <h1 class="auth-title">Create Your Account</h1>
                            <p class="auth-subtitle">Register free and find your perfect life partner</p>
                        </div>
                        
                        <form action="/register" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            
                            <!-- Profile For -->
                            <div class="mb-4">
                                <label class="form-label">Creating profile for</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <?php 
                                    $profileForOptions = ['self' => 'Myself', 'son' => 'Son', 'daughter' => 'Daughter', 'brother' => 'Brother', 'sister' => 'Sister', 'relative' => 'Relative'];
                                    foreach ($profileForOptions as $value => $label):
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="profile_for" id="profile_for_<?= $value ?>" 
                                                   value="<?= $value ?>" <?= ($formData['profile_for'] ?? 'self') === $value ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="profile_for_<?= $value ?>"><?= $label ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= htmlspecialchars($formData['name'] ?? '') ?>"
                                           placeholder="Enter full name" required minlength="2" maxlength="100">
                                    <div class="invalid-feedback">Please enter a valid name (2-100 characters).</div>
                                </div>
                                
                                <!-- Gender -->
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?= ($formData['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                        <option value="Female" <?= ($formData['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a gender.</div>
                                </div>
                                
                                <!-- Date of Birth -->
                                <div class="col-md-6">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dob" name="dob" 
                                           value="<?= htmlspecialchars($formData['dob'] ?? '') ?>"
                                           max="<?= date('Y-m-d', strtotime('-18 years')) ?>" required>
                                    <div class="invalid-feedback">Please enter a valid date of birth (must be 18+).</div>
                                </div>
                                
                                <!-- Mobile -->
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+91</span>
                                        <input type="tel" class="form-control" id="mobile" name="mobile" 
                                               value="<?= htmlspecialchars($formData['mobile'] ?? '') ?>"
                                               placeholder="10-digit mobile number" 
                                               pattern="[0-9]{10}" required>
                                    </div>
                                    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                                </div>
                                
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                                           placeholder="Enter email address" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                
                                <!-- Caste -->
                                <div class="col-md-6">
                                    <label for="caste" class="form-label">Caste <span class="text-danger">*</span></label>
                                    <select class="form-select" id="caste" name="caste" required>
                                        <option value="">Select Caste</option>
                                        <option value="Mahar" <?= ($formData['caste'] ?? '') === 'Mahar' ? 'selected' : '' ?>>Mahar</option>
                                        <option value="Matang" <?= ($formData['caste'] ?? '') === 'Matang' ? 'selected' : '' ?>>Matang</option>
                                        <option value="Nav-Bauddh" <?= ($formData['caste'] ?? '') === 'Nav-Bauddh' ? 'selected' : '' ?>>Nav-Bauddh</option>
                                        <option value="Chambhar" <?= ($formData['caste'] ?? '') === 'Chambhar' ? 'selected' : '' ?>>Chambhar</option>
                                        <option value="Banjara" <?= ($formData['caste'] ?? '') === 'Banjara' ? 'selected' : '' ?>>Banjara</option>
                                        <option value="Dhor" <?= ($formData['caste'] ?? '') === 'Dhor' ? 'selected' : '' ?>>Dhor</option>
                                        <option value="Other" <?= ($formData['caste'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a caste.</div>
                                </div>
                                
                                <!-- Password -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Create a strong password" 
                                               pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" required>
                                        <button type="button" class="input-group-text password-toggle" style="cursor: pointer;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Min 8 chars with uppercase, lowercase & number</div>
                                    <div class="invalid-feedback">Password must be at least 8 characters with uppercase, lowercase, and number.</div>
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                               placeholder="Confirm your password" required>
                                        <button type="button" class="input-group-text password-toggle" style="cursor: pointer;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Passwords do not match.</div>
                                </div>
                            </div>
                            
                            <!-- Terms -->
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="/terms" target="_blank">Terms & Conditions</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                                </label>
                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                                <i class="bi bi-person-plus me-2"></i>Register Free
                            </button>
                        </form>
                        
                        <div class="auth-divider">
                            <span>OR</span>
                        </div>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="/login" class="fw-semibold">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    if (this.value !== document.getElementById('password').value) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function() {
    const confirm = document.getElementById('confirm_password');
    if (confirm.value && confirm.value !== this.value) {
        confirm.setCustomValidity('Passwords do not match');
    } else {
        confirm.setCustomValidity('');
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
