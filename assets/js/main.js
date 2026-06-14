// Logica de interface e interatividade global

document.addEventListener('DOMContentLoaded', function () {
const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 15, 0.95)';
                navbar.style.borderBottom = '1px solid rgba(255,255,255,0.08)';
            } else {
                navbar.style.background = 'rgba(10, 10, 15, 0.8)';
                navbar.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
            }
        });
    }
const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');

    const observerOptions = {
        root: null,
        rootMargin: '-40% 0px -40% 0px',
        threshold: 0
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + entry.target.id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => sectionObserver.observe(section));
const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, i * 80);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        revealObserver.observe(el);
    });
const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.dataset.width || '0';
                setTimeout(() => { bar.style.width = width + '%'; }, 200);
                skillObserver.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.skill-bar-fill').forEach(bar => skillObserver.observe(bar));
const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            projectCards.forEach(card => {
                if (filter === 'all' || card.dataset.tech.toLowerCase().includes(filter.toLowerCase())) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
const searchInput = document.getElementById('project-search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            projectCards.forEach(card => {
                const title = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
                const tech = (card.dataset.tech || '').toLowerCase();
                card.style.display = (title.includes(query) || tech.includes(query)) ? 'block' : 'none';
            });
        });
    }
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return; // Skip empty hash links
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const offset = 80;
                const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top, behavior: 'smooth' });

                // Close mobile navbar
                const navCollapse = document.getElementById('navbarNav');
                if (navCollapse && navCollapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            }
        });
    });
const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mobileSidebarMq = window.matchMedia('(max-width: 991.98px)');

    const setSidebarOpen = (open) => {
        if (!sidebar) return;
        sidebar.classList.toggle('show', open);
        if (overlay) overlay.classList.toggle('show', open);
        if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('admin-sidebar-open', open);
    };

    const closeSidebar = () => setSidebarOpen(false);

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            setSidebarOpen(!sidebar.classList.contains('show'));
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    if (sidebar) {
        sidebar.querySelectorAll('.sidebar-link').forEach((link) => {
            link.addEventListener('click', () => {
                if (mobileSidebarMq.matches) closeSidebar();
            });
        });
    }

    const handleSidebarBreakpoint = () => {
        if (!mobileSidebarMq.matches) closeSidebar();
    };

    if (typeof mobileSidebarMq.addEventListener === 'function') {
        mobileSidebarMq.addEventListener('change', handleSidebarBreakpoint);
    } else if (typeof mobileSidebarMq.addListener === 'function') {
        mobileSidebarMq.addListener(handleSidebarBreakpoint);
    }

    window.addEventListener('resize', handleSidebarBreakpoint);
window.showToast = function (message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const id = 'toast-' + Date.now();
        const icons = {
            success: 'bi-check-circle-fill',
            danger: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };
        const colors = {
            success: '#10b981',
            danger: '#ef4444',
            warning: '#f59e0b',
            info: '#06b6d4'
        };

        const html = `
            <div id="${id}" class="toast align-items-center border-0 mb-2" role="alert" aria-live="assertive"
                 style="background: rgba(15,15,25,0.95); border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 14px; backdrop-filter: blur(20px);">
                <div class="d-flex align-items-center p-3 gap-3">
                    <i class="bi ${icons[type] || icons.info}" style="color: ${colors[type] || colors.info}; font-size: 1.2rem;"></i>
                    <div class="me-auto" style="color: #f1f5f9; font-weight: 500; font-size: 0.9rem;">${message}</div>
                    <button type="button" class="btn-close btn-close-white btn-close-sm" data-bs-dismiss="toast"></button>
                </div>
            </div>`;

        container.insertAdjacentHTML('beforeend', html);
        const toastEl = document.getElementById(id);
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    };
const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        showToast('OperaÃ§Ã£o realizada com sucesso!', 'success');
    }
    if (urlParams.get('error') === '1') {
        showToast('Ocorreu um erro. Tente novamente.', 'danger');
    }
    if (urlParams.get('deleted') === '1') {
        showToast('Item excluÃ­do com sucesso.', 'warning');
    }
window.confirmDelete = function (url, name) {
        const modal = document.getElementById('deleteModal');
        if (!modal) return;
        document.getElementById('deleteItemName').textContent = name || 'este item';
        document.getElementById('deleteConfirmBtn').href = url;
        new bootstrap.Modal(modal).show();
    };
document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', function () {
            const previewId = this.dataset.preview;
            const preview = document.getElementById(previewId);
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.count || '0');
                const duration = 1500;
                const step = target / (duration / 16);
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        el.textContent = target + (el.dataset.suffix || '');
                        clearInterval(timer);
                    } else {
                        el.textContent = Math.floor(current) + (el.dataset.suffix || '');
                    }
                }, 16);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));
const typingEl = document.getElementById('typing-text');
    if (typingEl) {
        const texts = JSON.parse(typingEl.dataset.texts || '[]');
        if (texts.length > 0) {
            let textIndex = 0;
            let charIndex = 0;
            let deleting = false;

            function type() {
                const current = texts[textIndex];
                if (deleting) {
                    typingEl.textContent = current.substring(0, charIndex--);
                    if (charIndex < 0) {
                        deleting = false;
                        textIndex = (textIndex + 1) % texts.length;
                        setTimeout(type, 500);
                        return;
                    }
                } else {
                    typingEl.textContent = current.substring(0, charIndex++);
                    if (charIndex > current.length) {
                        deleting = true;
                        setTimeout(type, 2000);
                        return;
                    }
                }
                setTimeout(type, deleting ? 60 : 100);
            }
            type();
        }
    }
const canvas = document.getElementById('particles-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

        const particles = [];
        for (let i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 2 + 0.5,
                dx: (Math.random() - 0.5) * 0.3,
                dy: (Math.random() - 0.5) * 0.3,
                alpha: Math.random() * 0.5 + 0.1
            });
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(124, 58, 237, ${p.alpha})`;
                ctx.fill();
                p.x += p.dx;
                p.y += p.dy;
                if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
            });
            requestAnimationFrame(animateParticles);
        }
        animateParticles();

        window.addEventListener('resize', () => {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        });
    }
const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
                btn.disabled = true;
            }
        });
    }

});


