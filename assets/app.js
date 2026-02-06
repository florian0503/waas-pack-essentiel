import './stimulus_bootstrap.js';
import './styles/app.css';

// Hide preloader
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('hidden');
        setTimeout(() => preloader.remove(), 400);
    }
});

// Scroll reveal animations
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.reveal').forEach((el) => {
        observer.observe(el);
    });

    // Staggered children animation
    const staggerObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const children = entry.target.querySelectorAll('.reveal-child');
                children.forEach((child, index) => {
                    child.style.transitionDelay = `${index * 150}ms`;
                    child.classList.add('revealed');
                    // Nettoyer le delay après l'animation pour ne pas affecter le hover
                    child.addEventListener('transitionend', () => {
                        child.style.transitionDelay = '';
                    }, { once: true });
                });
                staggerObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.reveal-stagger').forEach((el) => {
        staggerObserver.observe(el);
    });

    // Counter animation for badge number
    const counterEl = document.querySelector('.badge-number');
    if (counterEl) {
        const target = parseInt(counterEl.textContent, 10);
        counterEl.textContent = '0';
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    let current = 0;
                    const animate = () => {
                        current++;
                        counterEl.textContent = current;
                        if (current < target) {
                            const progress = current / target;
                            const delay = 80 + (progress * progress * 300);
                            setTimeout(animate, delay);
                        }
                    };
                    animate();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counterObserver.observe(counterEl);
    }

    // Counter animation for chiffres clés
    const chiffreElements = document.querySelectorAll('.chiffre-nombre[data-target]');
    if (chiffreElements.length) {
        const chiffreObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target, 10);
                    let current = 0;
                    const duration = 2000;
                    const stepTime = Math.max(Math.floor(duration / target), 20);
                    const increment = Math.max(1, Math.floor(target / (duration / stepTime)));
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = current.toLocaleString('fr-FR');
                    }, stepTime);
                    chiffreObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        chiffreElements.forEach((el) => chiffreObserver.observe(el));
    }

    // FAQ accordion
    document.querySelectorAll('.faq-question').forEach((btn) => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('active');

            // Close all other items
            document.querySelectorAll('.faq-item.active').forEach((openItem) => {
                if (openItem !== item) {
                    openItem.classList.remove('active');
                    openItem.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                    openItem.querySelector('.faq-answer').style.maxHeight = '0';
                }
            });

            if (isOpen) {
                item.classList.remove('active');
                btn.setAttribute('aria-expanded', 'false');
                answer.style.maxHeight = '0';
            } else {
                item.classList.add('active');
                btn.setAttribute('aria-expanded', 'true');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    // Close burger menu on nav link click (mobile)
    const header = document.querySelector('.header');
    document.querySelectorAll('.nav-section .nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            if (header) header.classList.remove('menu-open');
        });
    });

    // Show/hide scroll-to-top button + hide topbar on scroll
    const scrollTop = document.querySelector('.scroll-top');
    const topbar = document.querySelector('.topbar');
    if (scrollTop || topbar) {
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            if (scrollTop) {
                scrollTop.classList.toggle('visible', y > 300);
            }
            if (topbar) {
                topbar.classList.toggle('topbar-hidden', y > 50);
            }
        });
    }

    // Lightbox réalisations
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    if (lightbox) {
        document.querySelectorAll('.realisation-card img').forEach((img) => {
            img.addEventListener('click', () => {
                lightboxImg.src = img.src;
                lightboxImg.alt = img.alt;
                lightbox.classList.add('visible');
            });
        });

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
                lightbox.classList.remove('visible');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') lightbox.classList.remove('visible');
        });
    }

    // Contact form AJAX submit
    const contactForm = document.querySelector('.contact-form-card form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = contactForm.querySelector('.btn-submit');
            const originalText = btn.textContent;

            // Loader state
            btn.disabled = true;
            btn.innerHTML = '<span class="btn-spinner"></span> Envoi en cours...';

            const formData = new FormData(contactForm);

            fetch('/', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        // Success message
                        btn.innerHTML = 'Message envoyé !';
                        btn.classList.add('btn-success');
                        contactForm.reset();

                        // Remove existing success message if any
                        const existing = contactForm.parentElement.querySelector('.contact-success');
                        if (existing) existing.remove();

                        const msg = document.createElement('div');
                        msg.className = 'contact-success';
                        msg.innerHTML = '<p>Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.</p>';
                        contactForm.parentElement.insertBefore(msg, contactForm);

                        setTimeout(() => {
                            btn.textContent = originalText;
                            btn.classList.remove('btn-success');
                            btn.disabled = false;
                        }, 3000);
                    }
                })
                .catch(() => {
                    btn.textContent = originalText;
                    btn.disabled = false;
                });
        });
    }

    // Active nav link on scroll (spy)
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-section .nav-link');
    if (sections.length && navLinks.length) {
        const spyObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    navLinks.forEach((link) => {
                        link.classList.toggle('active', link.getAttribute('href') === '#' + id);
                    });
                }
            });
        }, { threshold: 0.3, rootMargin: '-80px 0px -50% 0px' });

        sections.forEach((section) => spyObserver.observe(section));
    }

    // Voir plus buttons
    document.querySelectorAll('.btn-voir-plus').forEach((btn) => {
        const gridSelector = btn.dataset.grid;
        const childSelector = btn.dataset.child;
        const grid = document.querySelector(gridSelector);
        if (!grid) return;

        const children = grid.querySelectorAll(childSelector);
        const limitDesktop = parseInt(grid.dataset.limitDesktop, 10);
        const limitMobile = parseInt(grid.dataset.limitMobile, 10);

        function updateButtonVisibility() {
            const isMobile = window.innerWidth <= 768;
            const limit = isMobile ? limitMobile : limitDesktop;
            const isExpanded = grid.classList.contains('expanded');
            btn.parentElement.style.display = (children.length > limit || isExpanded) ? '' : 'none';
        }

        updateButtonVisibility();
        window.addEventListener('resize', updateButtonVisibility);

        btn.addEventListener('click', () => {
            const isExpanded = grid.classList.contains('expanded');
            grid.classList.toggle('expanded');
            btn.classList.toggle('expanded');
            btn.textContent = isExpanded ? 'Voir plus' : 'Voir moins';
        });
    });

    // Cookie banner & modal
    const cookieBanner = document.getElementById('cookie-banner');
    const cookieOverlay = document.getElementById('cookie-modal-overlay');

    if (cookieBanner && !localStorage.getItem('cookie-consent')) {
        setTimeout(() => cookieBanner.classList.add('visible'), 1000);

        function closeBanner() {
            cookieBanner.classList.remove('visible');
        }

        function closeModal() {
            if (cookieOverlay) cookieOverlay.classList.remove('visible');
        }

        function saveConsent(analytics, marketing) {
            localStorage.setItem('cookie-consent', JSON.stringify({
                essential: true,
                analytics: analytics,
                marketing: marketing,
            }));
            closeBanner();
            closeModal();
        }

        document.getElementById('cookie-accept').addEventListener('click', () => saveConsent(true, true));
        document.getElementById('cookie-refuse').addEventListener('click', () => saveConsent(false, false));

        // Open modal
        document.getElementById('cookie-settings').addEventListener('click', () => {
            cookieOverlay.classList.add('visible');
        });

        // Close modal
        document.getElementById('cookie-modal-close').addEventListener('click', closeModal);
        cookieOverlay.addEventListener('click', (e) => {
            if (e.target === cookieOverlay) closeModal();
        });

        // Modal buttons
        document.getElementById('cookie-refuse-all').addEventListener('click', () => saveConsent(false, false));
        document.getElementById('cookie-save').addEventListener('click', () => {
            const analytics = document.getElementById('cookie-analytics').checked;
            const marketing = document.getElementById('cookie-marketing').checked;
            saveConsent(analytics, marketing);
        });
    }
});
