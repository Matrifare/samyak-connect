/**
 * Modern JavaScript
 * Mobile navigation, theme toggle, AJAX utilities
 */

(function() {
    'use strict';

    // =========================================
    // Theme Toggle
    // =========================================
    const themeToggle = document.getElementById('themeToggle');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Announce change for screen readers
            const announcement = document.createElement('div');
            announcement.setAttribute('role', 'status');
            announcement.setAttribute('aria-live', 'polite');
            announcement.className = 'sr-only';
            announcement.textContent = `Theme changed to ${newTheme} mode`;
            document.body.appendChild(announcement);
            setTimeout(() => announcement.remove(), 1000);
        });
    }

    // =========================================
    // Mobile Navigation
    // =========================================
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            // Toggle body scroll
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // =========================================
    // Back to Top Button
    // =========================================
    const backToTop = document.getElementById('backToTop');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // =========================================
    // Toast Notifications
    // =========================================
    const toasts = document.querySelectorAll('.toast');
    
    toasts.forEach(toast => {
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 5000);

        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                toast.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            });
        }
    });

    // Add slideOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // =========================================
    // AJAX Utilities
    // =========================================
    window.SamyakAPI = {
        /**
         * Make an AJAX request
         */
        async request(url, options = {}) {
            const defaults = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };

            const config = { ...defaults, ...options };

            if (config.data && config.method !== 'GET') {
                config.body = JSON.stringify(config.data);
                delete config.data;
            }

            try {
                const response = await fetch(url, config);
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error || 'Request failed');
                }
                
                return data;
            } catch (error) {
                console.error('API Error:', error);
                throw error;
            }
        },

        /**
         * GET request
         */
        get(url, params = {}) {
            const queryString = new URLSearchParams(params).toString();
            const fullUrl = queryString ? `${url}?${queryString}` : url;
            return this.request(fullUrl);
        },

        /**
         * POST request
         */
        post(url, data) {
            return this.request(url, { method: 'POST', data });
        },

        /**
         * PUT request
         */
        put(url, data) {
            return this.request(url, { method: 'PUT', data });
        },

        /**
         * DELETE request
         */
        delete(url) {
            return this.request(url, { method: 'DELETE' });
        }
    };

    // =========================================
    // Profile Actions
    // =========================================
    window.ProfileActions = {
        /**
         * Toggle shortlist
         */
        async toggleShortlist(profileId, button) {
            try {
                button.disabled = true;
                const response = await SamyakAPI.post('/api/shortlist', { profile_id: profileId });
                
                if (response.success) {
                    button.classList.toggle('active');
                    const icon = button.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fas');
                        icon.classList.toggle('far');
                    }
                    showToast(response.message, 'success');
                }
            } catch (error) {
                showToast(error.message, 'error');
            } finally {
                button.disabled = false;
            }
        },

        /**
         * Send interest
         */
        async sendInterest(profileId, button) {
            try {
                button.disabled = true;
                const response = await SamyakAPI.post('/api/interests', { to: profileId });
                
                if (response.success) {
                    button.innerHTML = '<i class="fas fa-check"></i> Interest Sent';
                    button.classList.add('btn-success');
                    showToast(response.message, 'success');
                }
            } catch (error) {
                showToast(error.message, 'error');
            } finally {
                button.disabled = false;
            }
        },

        /**
         * Accept/Decline interest
         */
        async respondToInterest(interestId, status, button) {
            try {
                button.disabled = true;
                const response = await SamyakAPI.put(`/api/interests/${interestId}`, { status });
                
                if (response.success) {
                    const card = button.closest('.interest-card');
                    if (card) {
                        card.classList.add('animate-fade-out');
                        setTimeout(() => card.remove(), 300);
                    }
                    showToast(response.message, 'success');
                }
            } catch (error) {
                showToast(error.message, 'error');
                button.disabled = false;
            }
        }
    };

    // =========================================
    // Toast Helper
    // =========================================
    window.showToast = function(message, type = 'info') {
        const container = document.querySelector('.toast-container') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${escapeHtml(message)}</span>
            <button class="toast-close" aria-label="Close">&times;</button>
        `;
        
        container.appendChild(toast);
        
        // Auto dismiss
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
        
        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        });
    };

    function createToastContainer() {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // =========================================
    // Form Validation
    // =========================================
    window.FormValidator = {
        /**
         * Validate a form
         */
        validate(form) {
            const inputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!this.validateField(input)) {
                    isValid = false;
                }
            });
            
            return isValid;
        },

        /**
         * Validate a single field
         */
        validateField(field) {
            const value = field.value.trim();
            const type = field.type;
            let isValid = true;
            let errorMessage = '';

            // Required check
            if (field.required && !value) {
                isValid = false;
                errorMessage = 'This field is required';
            }

            // Email validation
            if (isValid && type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address';
                }
            }

            // Phone validation
            if (isValid && type === 'tel' && value) {
                const phoneRegex = /^[0-9]{10}$/;
                if (!phoneRegex.test(value.replace(/\D/g, ''))) {
                    isValid = false;
                    errorMessage = 'Please enter a valid 10-digit phone number';
                }
            }

            // Min length
            if (isValid && field.minLength && value.length < field.minLength) {
                isValid = false;
                errorMessage = `Minimum ${field.minLength} characters required`;
            }

            // Show/hide error
            this.showFieldError(field, isValid ? '' : errorMessage);
            
            return isValid;
        },

        /**
         * Show field error
         */
        showFieldError(field, message) {
            const formGroup = field.closest('.form-group');
            if (!formGroup) return;

            // Remove existing error
            const existingError = formGroup.querySelector('.form-error');
            if (existingError) existingError.remove();

            if (message) {
                field.classList.add('is-invalid');
                const error = document.createElement('div');
                error.className = 'form-error text-danger text-sm mt-1';
                error.textContent = message;
                formGroup.appendChild(error);
            } else {
                field.classList.remove('is-invalid');
            }
        }
    };

    // Auto-validate forms on submit
    document.querySelectorAll('form[data-validate]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!FormValidator.validate(this)) {
                e.preventDefault();
            }
        });

        // Real-time validation
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', function() {
                FormValidator.validateField(this);
            });
        });
    });

    // =========================================
    // Lazy Loading Images
    // =========================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // =========================================
    // Dropdown Toggle for Mobile
    // =========================================
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth < 1024) {
                e.preventDefault();
                const dropdown = this.closest('.nav-dropdown');
                dropdown.classList.toggle('active');
            }
        });
    });

    // =========================================
    // Smooth Scroll for Anchor Links
    // =========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // =========================================
    // Stats Counter Animation
    // =========================================
    const animateCounter = (element, target) => {
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                element.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    };

    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.count);
                    animateCounter(entry.target, target);
                    counterObserver.unobserve(entry.target);
                }
            });
        });

        document.querySelectorAll('[data-count]').forEach(counter => {
            counterObserver.observe(counter);
        });
    }

})();
