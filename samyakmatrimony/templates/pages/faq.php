<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Frequently Asked Questions</h1>
            <p class="section-subtitle">Find answers to common questions about Samyak Matrimony</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php
                    $faqs = [
                        ['q' => 'How do I register on Samyak Matrimony?', 'a' => 'Click on "Register Free" and fill in your basic details including name, email, mobile, gender, and date of birth. After registration, you can complete your profile with additional information.'],
                        ['q' => 'Is registration free?', 'a' => 'Yes! Registration is completely free. You can create your profile, upload photos, and browse other profiles at no cost.'],
                        ['q' => 'How do I search for matches?', 'a' => 'Use our search feature to filter profiles by age, caste, education, location, and more. You can also search by Profile ID if you have a specific profile in mind.'],
                        ['q' => 'How do I express interest in a profile?', 'a' => 'When viewing a profile, click the "Send Interest" button. The other person will receive a notification and can accept or decline your interest.'],
                        ['q' => 'How can I contact a profile I\'m interested in?', 'a' => 'Once your interest is accepted by the other person, you can message each other directly through our platform.'],
                        ['q' => 'How do I hide my profile temporarily?', 'a' => 'Go to Settings > Privacy Settings and select "Hide Profile". You can unhide it anytime.'],
                        ['q' => 'How do I delete my account?', 'a' => 'Go to Settings > Delete Account. Please note this action is permanent and cannot be undone.'],
                        ['q' => 'Is my information safe?', 'a' => 'Yes, we take privacy seriously. Your contact details are only shared with members whose interest you accept.'],
                    ];
                    foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item glass-card mb-3 border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $i ?>">
                                <?= htmlspecialchars($faq['q']) ?>
                            </button>
                        </h2>
                        <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body"><?= htmlspecialchars($faq['a']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-5">
                    <p class="text-muted">Still have questions?</p>
                    <a href="/contact" class="btn btn-primary"><i class="bi bi-envelope me-2"></i>Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
