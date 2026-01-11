<?php include __DIR__ . '/../layouts/header.php'; ?>
<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="text-center mb-5"><h1 class="section-title">Success Stories</h1><p class="section-subtitle">Real couples who found love on Samyak Matrimony</p></div>
        <div class="row g-4">
            <?php 
            $stories = [
                ['names' => 'Rahul & Priya', 'date' => 'December 2023', 'quote' => 'We found each other on Samyak Matrimony and knew instantly that we were meant to be together. The platform made it easy to connect with like-minded people from our community.'],
                ['names' => 'Amit & Sneha', 'date' => 'February 2024', 'quote' => 'After searching for years, we finally found each other here. The matching system really works! We are grateful for this platform.'],
                ['names' => 'Vikram & Anjali', 'date' => 'March 2024', 'quote' => 'A perfect platform for the Buddhist community. We connected, met, and married within 6 months. Highly recommended to everyone!'],
                ['names' => 'Suresh & Kavita', 'date' => 'June 2024', 'quote' => 'What started as a simple profile view turned into a beautiful love story. Thank you Samyak Matrimony for bringing us together.'],
                ['names' => 'Nitin & Pooja', 'date' => 'August 2024', 'quote' => 'We were hesitant about online matrimony but Samyak Matrimony changed our minds. Found my soulmate within 2 months of registering!'],
                ['names' => 'Anil & Meera', 'date' => 'October 2024', 'quote' => 'The verified profiles gave us confidence. We are now happily married and recommend this platform to all Buddhist families.'],
            ];
            foreach ($stories as $story): ?>
            <div class="col-md-6 col-lg-4">
                <div class="story-card text-center">
                    <img src="/assets/images/couple-placeholder.jpg" alt="<?= $story['names'] ?>" class="story-couple-image">
                    <p class="story-quote"><?= $story['quote'] ?></p>
                    <h5 class="story-names"><?= $story['names'] ?></h5>
                    <p class="story-date">Married in <?= $story['date'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5"><p class="lead">Have your own success story?</p><a href="/contact" class="btn btn-primary btn-lg"><i class="bi bi-heart me-2"></i>Share Your Story</a></div>
    </div>
</section>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
