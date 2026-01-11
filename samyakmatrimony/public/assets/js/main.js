/**
 * Samyak Matrimony - Main JavaScript
 * Bootstrap 5 + Glassmorphism Design
 */

(function() {
    'use strict';

    // ============================================
    // NAVBAR SCROLL EFFECT
    // ============================================
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ============================================
    // FORM VALIDATION
    // ============================================
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // ============================================
    // PASSWORD TOGGLE
    // ============================================
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // ============================================
    // AJAX FORM SUBMIT HELPER
    // ============================================
    window.submitFormAjax = function(formId, successCallback, errorCallback) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : '';
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            }

            fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
                
                if (data.success) {
                    if (typeof successCallback === 'function') {
                        successCallback(data);
                    }
                } else {
                    if (typeof errorCallback === 'function') {
                        errorCallback(data);
                    }
                }
            })
            .catch(error => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
                console.error('Error:', error);
                if (typeof errorCallback === 'function') {
                    errorCallback({ success: false, message: 'An error occurred. Please try again.' });
                }
            });
        });
    };

    // ============================================
    // TOAST NOTIFICATIONS
    // ============================================
    window.showToast = function(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.style.zIndex = '1100';
            document.body.appendChild(container);
        }

        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : 
                       type === 'error' ? 'bg-danger' : 
                       type === 'warning' ? 'bg-warning' : 'bg-info';
        
        const toastHtml = `
            <div id="${toastId}" class="toast ${bgClass} text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHtml);
        
        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    };

    // ============================================
    // SHORTLIST TOGGLE
    // ============================================
    window.toggleShortlist = function(profileId, button) {
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('/shortlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'profile_id=' + profileId
        })
        .then(response => response.json())
        .then(data => {
            button.disabled = false;
            if (data.success) {
                if (data.isShortlisted) {
                    button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-danger');
                } else {
                    button.innerHTML = '<i class="bi bi-heart"></i>';
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-danger');
                }
                showToast(data.message, 'success');
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.innerHTML = originalHtml;
            showToast('An error occurred', 'error');
        });
    };

    // ============================================
    // SEND INTEREST
    // ============================================
    window.sendInterest = function(userId, button) {
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('/interest/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'to_user_id=' + userId
        })
        .then(response => response.json())
        .then(data => {
            button.disabled = false;
            if (data.success) {
                button.innerHTML = '<i class="bi bi-check-lg me-1"></i>Interest Sent';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                button.disabled = true;
                showToast(data.message, 'success');
            } else {
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.innerHTML = originalHtml;
            showToast('An error occurred', 'error');
        });
    };

    // ============================================
    // ACCEPT/DECLINE INTEREST
    // ============================================
    window.acceptInterest = function(interestId, button) {
        handleInterest(interestId, 'accept', button);
    };

    window.declineInterest = function(interestId, button) {
        handleInterest(interestId, 'decline', button);
    };

    function handleInterest(interestId, action, button) {
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('/interest/' + action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'interest_id=' + interestId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = button.closest('.interest-card');
                if (card) {
                    card.style.opacity = '0.5';
                    setTimeout(() => card.remove(), 500);
                }
                showToast(data.message, 'success');
            } else {
                button.disabled = false;
                button.innerHTML = originalHtml;
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            button.disabled = false;
            button.innerHTML = originalHtml;
            showToast('An error occurred', 'error');
        });
    }

    // ============================================
    // FILE UPLOAD PREVIEW
    // ============================================
    document.querySelectorAll('.photo-upload-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const preview = document.querySelector(this.dataset.preview);
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ============================================
    // AGE CALCULATOR FROM DOB
    // ============================================
    window.calculateAge = function(dob) {
        const today = new Date();
        const birthDate = new Date(dob);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    };

    // Auto-calculate age when DOB changes
    const dobInput = document.getElementById('dob');
    const ageDisplay = document.getElementById('age-display');
    
    if (dobInput && ageDisplay) {
        dobInput.addEventListener('change', function() {
            const age = calculateAge(this.value);
            ageDisplay.textContent = age + ' years';
        });
    }

    // ============================================
    // MESSAGE POLLING (Simple Real-time)
    // ============================================
    let messagePolling = null;

    window.startMessagePolling = function(otherUserId, lastMessageId, container) {
        if (messagePolling) clearInterval(messagePolling);

        messagePolling = setInterval(() => {
            fetch(`/messages/new?other_user_id=${otherUserId}&last_message_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            appendMessage(container, msg, false);
                            lastMessageId = Math.max(lastMessageId, msg.id);
                        });
                        container.scrollTop = container.scrollHeight;
                    }
                })
                .catch(error => console.error('Polling error:', error));
        }, 5000); // Poll every 5 seconds
    };

    window.stopMessagePolling = function() {
        if (messagePolling) {
            clearInterval(messagePolling);
            messagePolling = null;
        }
    };

    function appendMessage(container, message, isSent) {
        const msgHtml = `
            <div class="message ${isSent ? 'message-sent' : 'message-received'}">
                <div class="message-content">${message.content}</div>
                <div class="message-time">${message.created_at}</div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', msgHtml);
    }

    // ============================================
    // LAZY LOAD IMAGES
    // ============================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ============================================
    // COUNTER ANIMATION
    // ============================================
    const counters = document.querySelectorAll('.stat-number');
    
    if (counters.length > 0 && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.dataset.count) || parseInt(counter.textContent);
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            counter.textContent = target.toLocaleString() + '+';
                            clearInterval(timer);
                        } else {
                            counter.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 30);
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // ============================================
    // INITIALIZE TOOLTIPS
    // ============================================
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

    // ============================================
    // INITIALIZE POPOVERS
    // ============================================
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(el => new bootstrap.Popover(el));

    // ============================================
    // AUTO-DISMISS ALERTS
    // ============================================
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

})();
