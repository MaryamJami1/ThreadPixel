<?php
$featuredWork = $portfolio[0] ?? null;
$servicesToShow = array_slice($services, 0, 6);
?>

<section class="home-hero">
    <div class="hero-thread hero-thread-one"></div>
    <div class="hero-thread hero-thread-two"></div>
    <div class="container hero-layout">
        <div class="hero-copy reveal">
            <div class="eyebrow"><span class="eyebrow-dot"></span> Embroidery digitizing studio</div>
            <h1>Your design.<br><em>Digitized to perfection.</em></h1>
            <p>Professional embroidery digitizing and vector artwork that turns your ideas into clean, production-ready designs.</p>
            <div class="hero-actions">
                <a href="<?= BASE_URL ?>/quote" class="btn btn-primary">Get a Free Quote <span>↗</span></a>
                <a href="<?= BASE_URL ?>/portfolio" class="btn btn-text">View Our Work <span>→</span></a>
            </div>
            <div class="hero-proof"><span class="proof-stars">★★★★★</span><span>Trusted by brands worldwide</span></div>
        </div>

        <div class="hero-art reveal reveal-delay-1" aria-label="Digital pixels transforming into embroidery stitches">
            <div class="art-label art-label-top">digital artwork</div>
            <div class="pixel-field"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
            <div class="stitch-orbit"></div>
            <div class="stitch-letter">T</div>
            <div class="needle"><span></span></div>
            <div class="art-label art-label-bottom">production ready</div>
            <div class="art-caption"><span class="caption-line"></span> pixels to stitches</div>
        </div>
    </div>
    <div class="container hero-scroll"><span>Scroll to explore</span><span class="scroll-line"></span></div>
</section>

<section class="logo-strip"><div class="container logo-strip-inner"><span>Precision for every thread</span><span>Apparel brands</span><span>Embroidery shops</span><span>Creators & makers</span></div></section>

<section class="section services-section" id="services">
    <div class="container">
        <div class="section-heading-row reveal"><div><div class="eyebrow">What we create</div><h2>Made for the way<br>you work.</h2></div><p>From first sketch to final stitch file, we make every detail count.</p></div>
        <div class="services-grid">
            <?php foreach ($servicesToShow as $i => $service): ?>
            <a href="<?= BASE_URL ?>/quote?service=<?= $service->id ?>" class="service-tile reveal reveal-delay-<?= ($i % 3) + 1 ?>">
                <span class="service-number">0<?= $i + 1 ?></span><span class="service-icon"><span></span></span>
                <h3><?= htmlspecialchars($service->name) ?></h3><p><?= htmlspecialchars($service->description) ?></p>
                <span class="service-link">Explore service <b>↗</b></span>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="text-center section-action"><a href="<?= BASE_URL ?>/services" class="btn btn-outline">View all services <span>→</span></a></div>
    </div>
</section>

<section class="process-section" id="process">
    <div class="container">
        <div class="section-heading-centered reveal"><div class="eyebrow">A clear process</div><h2>From upload to<br><em>unmissable.</em></h2><p>Simple, transparent, and built around your production schedule.</p></div>
        <div class="process-grid">
            <?php $steps = [['01','Send your design','Upload artwork and tell us what you need.'],['02','We digitize it','Our specialists map every stitch and detail.'],['03','Quality check','We test, review, and refine your file.'],['04','Receive your files','Download production-ready formats securely.']]; foreach ($steps as $i => $step): ?>
            <div class="process-step reveal reveal-delay-<?= $i + 1 ?>"><div class="step-top"><span><?= $step[0] ?></span><span class="step-arrow"><?= $i < 3 ? '↗' : '✦' ?></span></div><h3><?= $step[1] ?></h3><p><?= $step[2] ?></p></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section work-section" id="work">
    <div class="container">
        <div class="section-heading-row reveal"><div><div class="eyebrow">Selected work</div><h2>Small details.<br>Big impact.</h2></div><a href="<?= BASE_URL ?>/portfolio" class="btn btn-text">See full portfolio <span>↗</span></a></div>
        <?php if ($featuredWork): ?>
        <a href="<?= BASE_URL ?>/portfolio" class="featured-work reveal">
            <div class="featured-image">
                <?php $workImage = $featuredWork->actual_embroidery_path ?: ($featuredWork->digitized_preview_path ?: $featuredWork->original_artwork_path); ?>
                <?php if ($workImage): ?><img src="<?= BASE_URL ?>/<?= htmlspecialchars($workImage) ?>" alt="<?= htmlspecialchars($featuredWork->title) ?> embroidery work"><?php else: ?><div class="image-placeholder">ThreadPixel</div><?php endif; ?>
                <span class="work-overlay">View case study ↗</span>
            </div>
            <div class="featured-meta"><div><span class="eyebrow">Featured project</span><h3><?= htmlspecialchars($featuredWork->title) ?></h3></div><span class="work-category"><?= htmlspecialchars($featuredWork->category_name ?? 'Digitizing') ?></span></div>
        </a>
        <?php else: ?><div class="empty-state">New work is being stitched. Explore our services to start your project.</div><?php endif; ?>
    </div>
</section>

<section class="comparison-section">
    <div class="container comparison-layout">
        <div class="comparison-copy reveal"><div class="eyebrow">The ThreadPixel difference</div><h2>Clean files.<br><em>Confident production.</em></h2><p>Every path, density, and underlay is considered for how your design will actually run on fabric.</p><a href="<?= BASE_URL ?>/about" class="btn btn-outline">Why ThreadPixel <span>→</span></a></div>
        <div class="comparison-card reveal reveal-delay-1"><div class="comparison-side comparison-original"><span>Original artwork</span><div class="mini-pixels"><i></i><i></i><i></i><i></i><i></i></div><strong>YOUR<br>IDEA</strong></div><div class="comparison-divider"><span>→</span></div><div class="comparison-side comparison-finished"><span>Digitized result</span><div class="mini-stitches">T</div><strong>READY<br>TO STITCH</strong></div></div>
    </div>
</section>

<section class="cta-section"><div class="container cta-inner reveal"><div><div class="eyebrow">Let’s make something lasting</div><h2>Ready to bring your<br><em>design to life?</em></h2></div><div><p>Send us your artwork and get a professional digitizing quote.</p><a href="<?= BASE_URL ?>/quote" class="btn btn-primary">Get a Free Quote <span>↗</span></a></div><div class="cta-pixels"><i></i><i></i><i></i><i></i><i></i></div></div></section>
