<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ThreadPixel — From Pixels to Stitches' ?></title>
    <meta name="description" content="Professional embroidery digitizing for businesses, brands, and creators worldwide.">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="navbar-wrap">
    <nav class="navbar">
        <a href="<?= BASE_URL ?>/" class="navbar-brand"><img src="<?= BASE_URL ?>/assets/images/logo.png" alt="ThreadPixel Digitizing logo"></a>
        <ul class="nav-links">
            <li><a href="<?= BASE_URL ?>/">Home</a></li>
            <li><a href="<?= BASE_URL ?>/services">Services</a></li>
            <li><a href="<?= BASE_URL ?>/#process">How It Works</a></li>
            <li><a href="<?= BASE_URL ?>/portfolio">Portfolio</a></li>
            <li><a href="<?= BASE_URL ?>/about">About</a></li>
            <li><a href="<?= BASE_URL ?>/contact">Contact</a></li>
        </ul>
        <div class="nav-auth">
            <?php if (Session::isLoggedIn()): ?>
                <a href="<?= BASE_URL ?>/<?= Session::isAdmin() ? 'admin' : 'dashboard' ?>" class="btn btn-outline">Dashboard</a>
                <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline">Logout</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline">Login</a>
                <a href="<?= BASE_URL ?>/quote" class="btn btn-primary">Get a Quote</a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<main>
    <?php if (Session::hasFlash('success')): ?>
        <div class="container" style="padding-top:1.5rem;">
            <div class="alert alert-success">✓ <?= Session::getFlash('success') ?></div>
        </div>
    <?php endif; ?>
    <?php if (Session::hasFlash('error')): ?>
        <div class="container" style="padding-top:1.5rem;">
            <div class="alert alert-error">✕ <?= Session::getFlash('error') ?></div>
        </div>
    <?php endif; ?>

    <?= $viewContent ?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand"><img src="<?= BASE_URL ?>/assets/images/logo.png" alt="ThreadPixel Digitizing logo"></div>
                <p class="footer-desc">Professional embroidery digitizing for businesses, brands, and creators worldwide. Turn your artwork into clean, production-ready embroidery files.</p>
            </div>
            <div>
                <div class="footer-heading">Services</div>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>/services">Logo Digitizing</a></li>
                    <li><a href="<?= BASE_URL ?>/services">Cap Digitizing</a></li>
                    <li><a href="<?= BASE_URL ?>/services">3D Puff Digitizing</a></li>
                    <li><a href="<?= BASE_URL ?>/services">Jacket Back</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Company</div>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>/about">About Us</a></li>
                    <li><a href="<?= BASE_URL ?>/portfolio">Portfolio</a></li>
                    <li><a href="<?= BASE_URL ?>/faq">FAQ</a></li>
                    <li><a href="<?= BASE_URL ?>/contact">Contact</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Get Started</div>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>/quote">Get a Quote</a></li>
                    <li><a href="<?= BASE_URL ?>/pricing">Pricing</a></li>
                    <li><a href="<?= BASE_URL ?>/auth/register">Create Account</a></li>
                    <li><a href="<?= BASE_URL ?>/auth/login">Login</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-socials">
            <a href="<?= BASE_URL ?>/contact" aria-label="Contact ThreadPixel">Contact us</a>
            <span>Instagram</span>
            <span>LinkedIn</span>
        </div>
        <div class="footer-bottom">
            <span class="footer-copy">&copy; <?= date('Y') ?> ThreadPixel. All rights reserved.</span>
            <span class="footer-copy">Professional Embroidery Digitizing — Worldwide</span>
        </div>
    </div>
</footer>

<!-- Chatbot Widget -->
<div class="chatbot-widget">
    <div class="chatbot-window" id="chatbot-window" style="display:none;">
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">🧵</div>
                <div>
                    <div class="chat-name">ThreadPixel Assistant</div>
                    <div class="chat-status">Online &amp; Ready</div>
                </div>
            </div>
            <button onclick="document.getElementById('chatbot-window').style.display='none'" style="background:none;border:none;color:rgba(255,255,255,0.7);cursor:pointer;font-size:1.2rem;">✕</button>
        </div>
        <div id="chat-body" class="chat-body"></div>
        <div class="chat-footer">
            <input type="text" id="chat-input" class="chat-input" placeholder="Ask about digitizing...">
            <button onclick="sendInput()" class="chat-send">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </div>
    </div>
    <button class="chatbot-toggle" id="chatbot-toggle" title="Chat with us">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
    </button>
</div>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
<script>
// Scroll reveal
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Chatbot
const chatbotToggle = document.getElementById('chatbot-toggle');
const chatbotWindow = document.getElementById('chatbot-window');
let chatInitialized = false;
chatbotToggle.addEventListener('click', () => {
    const isOpen = chatbotWindow.style.display === 'flex';
    chatbotWindow.style.display = isOpen ? 'none' : 'flex';
    if (!isOpen && !chatInitialized) { sendChatMessage(''); chatInitialized = true; }
});

function sendInput() {
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (msg) { sendChatMessage(msg); input.value = ''; }
}
document.getElementById('chat-input').addEventListener('keypress', e => { if (e.key === 'Enter') sendInput(); });
</script>
</body>
</html>
