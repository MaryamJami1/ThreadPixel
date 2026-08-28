<!-- Page Hero -->
<section style="padding:4rem 0 3rem;border-bottom:1px solid var(--border);text-align:center;">
    <div class="container">
        <div class="section-tag reveal">Our Services</div>
        <h1 class="section-title reveal" style="font-size:clamp(2rem,4vw,3rem);margin-top:0.75rem;">Professional Digitizing for Every Need</h1>
        <p class="section-desc reveal">Every design is digitized by expert human hands — not software. Machine-specific, production-tested, and delivered fast.</p>
    </div>
</section>

<!-- Services Grid -->
<section class="section">
    <div class="container">
        <?php if (empty($services)): ?>
            <p class="text-center text-muted">No services available yet.</p>
        <?php else: ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.75rem;">
            <?php foreach ($services as $i => $service): ?>
            <div class="card card-glow reveal reveal-delay-<?= ($i%3)+1 ?>" style="padding:2.25rem;">
                <div style="width:52px;height:52px;background:rgba(37,99,235,0.08);border:1px solid rgba(37,99,235,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1.5rem;">🧵</div>
                <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:0.75rem;"><?= htmlspecialchars($service->name) ?></h2>
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

                <div style="border-top:1px solid var(--border);padding-top:1.25rem;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Starting from</div>
                        <div style="font-size:1.75rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;">$<?= number_format($service->starting_price, 2) ?></div>
                    </div>
                    <a href="<?= BASE_URL ?>/quote?service=<?= $service->id ?>" class="btn btn-primary" style="font-size:0.85rem;">Get Quote</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Technical Details -->
<section style="background:var(--bg-secondary);border-top:1px solid var(--border);padding:5rem 0;">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-tag">Technical Excellence</div>
            <h2 class="section-title">Inside the ThreadPixel Lab</h2>
            <p class="section-desc">Professional digitizing requires deep expertise — not just software access.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
            <?php
            $details = [
                ['title'=>'Stitch Direction','desc'=>'Carefully planned angles create natural texture and prevent distortion.','color'=>'var(--blue)'],
                ['title'=>'Proper Underlay','desc'=>'Fabric-specific underlay types for stability across stretch and density.','color'=>'var(--gold)'],
                ['title'=>'Pull Compensation','desc'=>'Outlines adjusted digitally so thread aligns perfectly on the machine.','color'=>'var(--success)'],
                ['title'=>'Minimized Trims','desc'=>'Color paths optimized to reduce thread cuts and speed up production.','color'=>'var(--warning)'],
            ];
            foreach ($details as $i => $d):
            ?>
            <div class="reveal reveal-delay-<?= $i+1 ?>" style="padding:1.5rem 0;border-left:2px solid <?= $d['color'] ?>;padding-left:1.5rem;">
                <h4 style="font-weight:700;color:<?= $d['color'] ?>;margin-bottom:0.5rem;"><?= $d['title'] ?></h4>
                <p style="color:var(--text-muted);font-size:0.875rem;line-height:1.7;"><?= $d['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
