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
});
