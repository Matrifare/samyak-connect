<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="section-title">Contact Us</h1>
                    <p class="section-subtitle">We'd love to hear from you</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card glass-card h-100 text-center p-4">
                            <div class="stat-icon mx-auto"><i class="bi bi-geo-alt"></i></div>
                            <h5 class="mt-3">Address</h5>
                            <p class="text-muted mb-0">Mumbai, Maharashtra, India</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card glass-card h-100 text-center p-4">
                            <div class="stat-icon mx-auto"><i class="bi bi-envelope"></i></div>
                            <h5 class="mt-3">Email</h5>
                            <p class="text-muted mb-0"><a href="mailto:info@samyakmatrimony.com">info@samyakmatrimony.com</a></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card glass-card h-100 text-center p-4">
                            <div class="stat-icon mx-auto"><i class="bi bi-telephone"></i></div>
                            <h5 class="mt-3">Phone</h5>
                            <p class="text-muted mb-0"><a href="tel:+919876543210">+91 98765 43210</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="card glass-card mt-5">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Send us a Message</h4>
                        <form action="/contact/submit" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCsrfToken() ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subject</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send me-2"></i>Send Message</button>
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
