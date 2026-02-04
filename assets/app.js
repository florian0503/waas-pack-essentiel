import './stimulus_bootstrap.js';
import './styles/app.css';

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

    // Show/hide scroll-to-top button
    const scrollTop = document.querySelector('.scroll-top');
    if (scrollTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        });
    }
});
