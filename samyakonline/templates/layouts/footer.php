    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z" fill="currentColor"/>
            </svg>
        </div>
        
        <div class="footer-content">
            <div class="container">
                <div class="footer-grid">
                    <!-- About -->
                    <div class="footer-section">
                        <a href="/" class="footer-logo">
                            <img src="logo/logo.png" alt="Samyak Matrimony" onerror="this.style.display='none'">
                            <span>Samyak Matrimony</span>
                        </a>
                        <p class="footer-desc">
                            India's #1 Buddhist Matrimony platform. Find your perfect life partner 
                            with verified profiles and secure matchmaking.
                        </p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="footer-section">
                        <h4>Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/search">Search Profiles</a></li>
                            <li><a href="/success-stories">Success Stories</a></li>
                            <li><a href="/membership">Premium Plans</a></li>
                            <li><a href="/faq">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <!-- Help & Support -->
                    <div class="footer-section">
                        <h4>Help & Support</h4>
                        <ul class="footer-links">
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                            <li><a href="/terms">Terms of Use</a></li>
                            <li><a href="/safe-matrimony">Safe Matrimony</a></li>
                            <li><a href="/report">Report Abuse</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div class="footer-section">
                        <h4>Contact Us</h4>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+91 98198 86759</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>support@samyakmatrimony.com</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>Mon - Sat: 9:00 AM - 9:00 PM</span>
                            </li>
                            <li>
                                <i class="fab fa-whatsapp"></i>
                                <a href="https://wa.me/919819886759">WhatsApp Support</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- App Download -->
                <div class="app-download">
                    <p>Download Our App</p>
                    <div class="app-buttons">
                        <a href="#" class="app-btn">
                            <i class="fab fa-google-play"></i>
                            <span>Google Play</span>
                        </a>
                        <a href="#" class="app-btn">
                            <i class="fab fa-apple"></i>
                            <span>App Store</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?= date('Y') ?> Samyak Matrimony. All rights reserved.</p>
                <p>Made with <i class="fas fa-heart text-primary"></i> for the Buddhist Community</p>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Scripts -->
    <script src="templates/assets/js/modern.js"></script>
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= htmlspecialchars($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
