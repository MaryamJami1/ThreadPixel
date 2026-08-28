<!-- Page Hero -->
<section class="inner-page-hero services-page-hero">
    <div class="container inner-hero-layout">
        <div class="inner-hero-copy">
            <div class="section-tag reveal">Our Services</div>
            <h1 class="section-title reveal" style="font-size:clamp(2rem,4vw,3rem);margin-top:0.75rem;">Professional Digitizing for Every Need</h1>
            <p class="section-desc reveal">Every design is digitized by expert human hands — not software. Machine-specific, production-tested, and delivered fast.</p>
        </div>
        <div class="inner-hero-art services-hero-art reveal reveal-delay-1" aria-hidden="true">
            <span class="hero-art-label">precision / 01</span><span class="hero-art-ring"></span><span class="hero-art-cross"></span><span class="hero-art-needle"></span><span class="hero-art-thread"></span><span class="hero-art-pixel pixel-a"></span><span class="hero-art-pixel pixel-b"></span><span class="hero-art-pixel pixel-c"></span><strong>STITCH<br><em>CRAFT</em></strong>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview">
    <div class="container services-overview-grid">
        <div class="overview-intro reveal"><span class="overview-index">01 / 03</span><h2>Every stitch has<br><em>a purpose.</em></h2><p>Choose the service that fits your next production run. We translate visual intent into files your machine can trust.</p></div>
        <div class="overview-metric reveal reveal-delay-1"><strong><?= count($services) ?></strong><span>specialist services</span></div>
        <div class="overview-metric reveal reveal-delay-2"><strong>12–24<span>h</span></strong><span>typical turnaround</span></div>
        <div class="overview-metric reveal reveal-delay-3"><strong>100<span>%</span></strong><span>human reviewed</span></div>
    </div>
</section>

<section class="service-choice-rail">
    <div class="container service-choice-inner">
        <span class="choice-label">Not sure where to start?</span>
        <a href="#service-1">Brand logo <span>→</span></a>
        <a href="#service-2">Headwear <span>→</span></a>
        <a href="#service-3">Raised detail <span>→</span></a>
        <a href="<?= BASE_URL ?>/quote" class="choice-cta">Send artwork <span>↗</span></a>
    </div>
</section>

<!-- Services Grid -->
<section class="section services-list-section">
    <div class="container">
        <?php if (empty($services)): ?>
            <p class="text-center text-muted">No services available yet.</p>
        <?php else: ?>
        <div class="services-list-grid">
            <?php foreach ($services as $i => $service): ?>
            <div class="card card-glow service-detail-card reveal reveal-delay-<?= ($i%3)+1 ?>" id="service-<?= $i + 1 ?>">
                <div class="service-card-top"><span class="service-card-index">0<?= $i + 1 ?></span><span class="service-card-mark">✦</span></div>
                <div class="service-detail-icon"><span></span></div>
                <h2><?= htmlspecialchars($service->name) ?></h2>
                <p style="color:var(--text-muted);font-size:0.9rem;line-height:1.75;margin-bottom:1.5rem;min-height:70px;"><?= htmlspecialchars($service->description) ?></p>

                <?php if ($service->suitable_applications): ?>
                <div style="margin-bottom:1.5rem;">
                    <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.6rem;">Best For</div>
                    <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                        <?php foreach (explode(',', $service->suitable_applications) as $app): ?>
                        <span style="background:rgba(255,255,255,0.04);border:1px solid var(--border);padding:0.2rem 0.65rem;border-radius:9999px;font-size:0.78rem;color:var(--text-secondary);"><?= htmlspecialchars(trim($app)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="service-card-footer">
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Starting from</div>
                        <div style="font-size:1.75rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;">$<?= number_format($service->starting_price, 2) ?></div>
                    </div>
                    <a href="<?= BASE_URL ?>/quote?service=<?= $service->id ?>" class="btn btn-primary" style="font-size:0.85rem;">Get Quote <span>↗</span></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Technical Details -->
<section class="technical-section">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag">Technical Excellence</div>
            <h2 class="section-title">Inside the ThreadPixel Lab</h2>
            <p class="section-desc">Professional digitizing requires deep expertise — not just software access.</p>
        </div>
        <div class="technical-grid">
            <?php
            $details = [
                ['title'=>'Stitch Direction','desc'=>'Carefully planned angles create natural texture and prevent distortion.','color'=>'var(--blue)'],
                ['title'=>'Proper Underlay','desc'=>'Fabric-specific underlay types for stability across stretch and density.','color'=>'var(--gold)'],
                ['title'=>'Pull Compensation','desc'=>'Outlines adjusted digitally so thread aligns perfectly on the machine.','color'=>'var(--success)'],
                ['title'=>'Minimized Trims','desc'=>'Color paths optimized to reduce thread cuts and speed up production.','color'=>'var(--warning)'],
            ];
            foreach ($details as $i => $d):
            ?>
            <div class="technical-detail reveal reveal-delay-<?= $i+1 ?>" style="--detail-color:<?= $d['color'] ?>;">
                <h4 style="font-weight:700;color:<?= $d['color'] ?>;margin-bottom:0.5rem;"><?= $d['title'] ?></h4>
                <p style="color:var(--text-muted);font-size:0.875rem;line-height:1.7;"><?= $d['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
