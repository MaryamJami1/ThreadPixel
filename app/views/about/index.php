<section class="about-hero">
    <div class="container about-hero-grid">
        <div class="about-hero-copy reveal">
            <div class="eyebrow"><span class="eyebrow-dot"></span> The studio behind the stitches</div>
            <h1>Where creative<br><em>meets precise.</em></h1>
            <p>ThreadPixel turns artwork into embroidery that looks right on screen and runs beautifully on fabric.</p>
            <a href="<?= BASE_URL ?>/contact" class="btn btn-primary">Start a conversation <span>↗</span></a>
        </div>
        <div class="about-art reveal reveal-delay-1" aria-hidden="true"><div class="about-art-circle"></div><div class="about-art-thread"></div><div class="about-art-needle"></div><div class="about-art-pixels"><i></i><i></i><i></i><i></i><i></i></div><strong>CRAFT<br><em>THE DETAIL</em></strong><span>est. for makers / 01</span></div>
    </div>
</section>

<section class="about-mission section">
    <div class="container mission-grid">
        <div class="mission-copy reveal"><div class="eyebrow">Our point of view</div><h2>Technology gives us speed.<br><em>Craft gives us judgment.</em></h2><p>Professional digitizing is more than converting an image. It is understanding fabric, thread behavior, stitch direction, and the small decisions that make a finished piece feel intentional.</p><p>Our human-first approach combines production knowledge with careful digital preparation, giving brands and makers files they can send straight to the machine with confidence.</p></div>
        <div class="about-stats">
            <div class="about-stat reveal reveal-delay-1"><strong data-count="500">0</strong><span>designs delivered</span></div>
            <div class="about-stat reveal reveal-delay-2"><strong data-count="20">0</strong><span>countries served</span></div>
            <div class="about-stat reveal reveal-delay-3"><strong data-count="12">0</strong><span>hour average turnaround</span></div>
            <div class="about-stat reveal reveal-delay-1"><strong data-count="98">0</strong><span>percent satisfaction</span></div>
        </div>
    </div>
</section>

<section class="principles-section">
    <div class="container">
        <div class="section-heading-row reveal"><div><div class="eyebrow">What we believe</div><h2>A sharper eye<br>for the <em>small stuff.</em></h2></div><p>Every project is a conversation between your artwork and the material it will live on.</p></div>
        <div class="principles-layout">
            <div class="principle-tabs" role="tablist">
                <button class="principle-tab active" type="button" data-principle="quality"><span>01</span> Professional quality <b>↗</b></button>
                <button class="principle-tab" type="button" data-principle="speed"><span>02</span> Built for momentum <b>↗</b></button>
                <button class="principle-tab" type="button" data-principle="partnership"><span>03</span> A real partner <b>↗</b></button>
            </div>
            <div class="principle-panel" data-panel="quality"><span class="panel-mark">✦</span><h3>Details that survive the stitch.</h3><p>We prepare files around real production conditions, balancing clean edges, stable underlay, density, and thread economy.</p></div>
            <div class="principle-panel is-hidden" data-panel="speed"><span class="panel-mark">↗</span><h3>Clear work, quick decisions.</h3><p>Fast does not mean rushed. Our process keeps feedback, pricing, and file delivery simple so your next run keeps moving.</p></div>
            <div class="principle-panel is-hidden" data-panel="partnership"><span class="panel-mark">∞</span><h3>Built around your workflow.</h3><p>From a one-off logo to a growing apparel line, we learn what matters to your production and stay close to the details.</p></div>
        </div>
    </div>
</section>

<section class="about-process section">
    <div class="container">
        <div class="section-heading-centered reveal"><div class="eyebrow">How we work</div><h2>A thoughtful path from<br><em>pixel to product.</em></h2><p>Four clear stages. One finished design you can trust.</p></div>
        <div class="about-timeline">
            <?php $steps = [['01','Listen','We learn about your artwork, garment, size, and production goal.'],['02','Build','A digitizer maps every path, layer, underlay, and color stop.'],['03','Review','We inspect the file for clean movement and reliable machine output.'],['04','Deliver','You receive the formats you need, ready for the next stitch.']]; foreach ($steps as $i => $step): ?>
            <div class="about-timeline-item reveal reveal-delay-<?= $i + 1 ?>"><div class="timeline-node"><?= $step[0] ?></div><div><h3><?= $step[1] ?></h3><p><?= $step[2] ?></p></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="about-cta"><div class="container about-cta-inner reveal"><div><div class="eyebrow">Make it tangible</div><h2>Have a design<br>in mind?</h2></div><p>Tell us what you are making. We will help you find the clearest path from artwork to embroidery.</p><a href="<?= BASE_URL ?>/quote" class="btn btn-primary">Get a Free Quote <span>↗</span></a></div></section>

<script>
document.querySelectorAll('.principle-tab').forEach(tab => tab.addEventListener('click', () => {
    document.querySelectorAll('.principle-tab').forEach(item => item.classList.remove('active'));
    document.querySelectorAll('.principle-panel').forEach(panel => panel.classList.add('is-hidden'));
    tab.classList.add('active');
    document.querySelector(`[data-panel="${tab.dataset.principle}"]`).classList.remove('is-hidden');
}));

const aboutStats = document.querySelectorAll('.about-stat strong[data-count]');
if ('IntersectionObserver' in window && aboutStats.length) {
    const statsObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const target = entry.target;
            const end = Number(target.dataset.count);
            const start = performance.now();
            const update = now => {
                const progress = Math.min((now - start) / 900, 1);
                target.textContent = Math.floor(end * (1 - Math.pow(1 - progress, 3))) + (end === 12 ? 'h' : end === 98 ? '%' : '+');
                if (progress < 1) requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
            observer.unobserve(target);
        });
    }, { threshold: .65 });
    aboutStats.forEach(stat => statsObserver.observe(stat));
}
</script>
