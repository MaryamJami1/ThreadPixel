document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // File input label updates
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function () {
            const label = this.closest('.file-drop') || this.nextElementSibling;
            if (label && this.files.length > 0) {
                const names = Array.from(this.files).map(f => f.name).join(', ');
                const nameEl = label.querySelector('.file-name');
                if (nameEl) nameEl.textContent = names;
            }
        });
    });

    const processGrid = document.querySelector('.process-grid');
    if (processGrid && 'IntersectionObserver' in window) {
        const processObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    processGrid.classList.add('visible');
                    observer.unobserve(processGrid);
                }
            });
        }, { threshold: 0.25 });
        processObserver.observe(processGrid);
    }

    const hero = document.querySelector('.home-hero');
    if (hero && window.matchMedia('(pointer: fine)').matches) {
        hero.addEventListener('pointermove', event => {
            const bounds = hero.getBoundingClientRect();
            hero.style.setProperty('--pointer-x', `${event.clientX - bounds.left}px`);
            hero.style.setProperty('--pointer-y', `${event.clientY - bounds.top}px`);
        });
    }

    const motionTargets = document.querySelectorAll(
        '.card:not(.reveal), .stat-card, .faq-group > div, .form-group, .section-header:not(.reveal), .footer-grid > div, .dashboard-content > *:not(.alert)'
    );
    motionTargets.forEach((element, index) => {
        element.classList.add('motion-item');
        element.style.transitionDelay = `${Math.min(index % 5, 4) * 70}ms`;
    });

    document.querySelectorAll('.portfolio-img-wrap img, .featured-image img').forEach(image => {
        image.classList.add('motion-image');
    });

    const motionObserver = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('motion-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14 })
        : null;

    if (motionObserver) {
        document.querySelectorAll('.motion-item, .motion-image').forEach(element => motionObserver.observe(element));
    } else {
        document.querySelectorAll('.motion-item, .motion-image').forEach(element => element.classList.add('motion-visible'));
    }

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', () => {
            if (input.files.length) {
                input.closest('.form-group')?.classList.add('file-ready');
            }
        });
    });

    if (window.matchMedia('(pointer: fine)').matches) {
        document.querySelectorAll('main, .footer, .navbar-wrap').forEach(surface => {
            surface.classList.add('creative-surface');
            const shadow = document.createElement('span');
            shadow.className = 'motion-cursor-shadow';
            surface.appendChild(shadow);
            let lastParticle = 0;
            surface.addEventListener('pointermove', event => {
                const bounds = surface.getBoundingClientRect();
                const x = event.clientX - bounds.left;
                const y = event.clientY - bounds.top;
                shadow.style.left = `${x}px`;
                shadow.style.top = `${y}px`;

                const now = performance.now();
                if (now - lastParticle < 95) return;
                lastParticle = now;
                const particle = document.createElement('i');
                particle.className = 'motion-cursor-dot';
                particle.style.left = `${x + (Math.random() * 22 - 11)}px`;
                particle.style.top = `${y + (Math.random() * 22 - 11)}px`;
                particle.style.setProperty('--particle-size', `${Math.round(4 + Math.random() * 8)}px`);
                surface.appendChild(particle);
                particle.addEventListener('animationend', () => particle.remove(), { once: true });
            });
            surface.addEventListener('pointerleave', () => shadow.classList.add('is-hidden'));
            surface.addEventListener('pointerenter', () => shadow.classList.remove('is-hidden'));
        });
    }

    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener('click', event => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || link.target === '_blank' || link.hasAttribute('download')) return;
            if (href.startsWith('/') || href.startsWith(window.location.origin)) {
                document.body.classList.add('is-leaving');
            }
        });
    });
});

/* ---- Chatbot ---- */
const BASE = document.querySelector('meta[name="base-url"]')?.content || '';

async function sendChatMessage(message) {
    const chatBody = document.getElementById('chat-body');
    if (!chatBody) return;

    if (message) {
        const userEl = document.createElement('div');
        userEl.className = 'chat-msg user-msg';
        userEl.textContent = message;
        chatBody.appendChild(userEl);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Typing indicator
    const typing = document.createElement('div');
    typing.className = 'chat-msg bot-msg';
    typing.innerHTML = '<span style="animation:pulse 1s infinite;display:inline-block;">● ● ●</span>';
    chatBody.appendChild(typing);
    chatBody.scrollTop = chatBody.scrollHeight;

    try {
        const res = await fetch(window.location.origin + '/chatbot/respond', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message })
        });
        const data = await res.json();

        chatBody.removeChild(typing);

        // Bot message
        const botEl = document.createElement('div');
        botEl.className = 'chat-msg bot-msg';
        botEl.innerHTML = (data.response || '').replace(/\n/g, '<br>');
        chatBody.appendChild(botEl);

        // Quick-reply buttons
        if (data.buttons && data.buttons.length) {
            const btnWrap = document.createElement('div');
            btnWrap.className = 'chat-buttons';
            data.buttons.forEach(btn => {
                const b = document.createElement('button');
                b.className = 'chat-btn';
                b.textContent = btn;
                b.onclick = () => sendChatMessage(btn);
                btnWrap.appendChild(b);
            });
            chatBody.appendChild(btnWrap);
        }

        // Link button
        if (data.link) {
            const link = document.createElement('a');
            link.href = data.link;
            link.className = 'btn btn-primary';
            link.style.cssText = 'display:block;text-align:center;margin-top:0.5rem;font-size:0.8rem;padding:0.5rem 1rem;border-radius:9999px;';
            link.textContent = data.linkText || 'Open';
            chatBody.appendChild(link);
        }

    } catch (e) {
        chatBody.removeChild(typing);
        const errEl = document.createElement('div');
        errEl.className = 'chat-msg bot-msg';
        errEl.textContent = 'Sorry, I ran into an error. Please try again.';
        chatBody.appendChild(errEl);
    }

    chatBody.scrollTop = chatBody.scrollHeight;
}
