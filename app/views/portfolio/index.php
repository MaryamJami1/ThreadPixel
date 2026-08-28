<!-- Page Hero -->
<section style="padding:4rem 0 3rem;border-bottom:1px solid var(--border);text-align:center;">
    <div class="container">
        <div class="section-tag reveal">Our Work</div>
        <h1 class="section-title reveal" style="font-size:clamp(2rem,4vw,3rem);margin-top:0.75rem;">Digitizing Portfolio</h1>
        <p class="section-desc reveal">Real designs. Real stitches. Hover over any card to see the original artwork.</p>
    </div>
</section>

<!-- Filter Bar -->
<section class="section-sm">
    <div class="container">
        <?php if (!empty($categories)): ?>
        <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:0.6rem;margin-bottom:3rem;" class="reveal">
            <a href="<?= BASE_URL ?>/portfolio" class="btn <?= $activeCategory === null ? 'btn-primary' : 'btn-outline' ?>" style="font-size:0.8rem;padding:0.45rem 1.1rem;">All</a>
            <?php foreach($categories as $cat): ?>
            <a href="<?= BASE_URL ?>/portfolio?category=<?= $cat->id ?>" class="btn <?= $activeCategory == $cat->id ? 'btn-primary' : 'btn-outline' ?>" style="font-size:0.8rem;padding:0.45rem 1.1rem;">
                <?= htmlspecialchars($cat->name) ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
        <p class="text-center text-muted" style="padding:3rem 0;">No portfolio items found.</p>
        <?php else: ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.75rem;" id="portfolio-grid">
            <?php foreach ($items as $i => $item): ?>
            <div class="card reveal reveal-delay-<?= ($i%3)+1 ?>" style="overflow:hidden;">

                <!-- Image with Before/After hover -->
                <div class="portfolio-img-wrap" style="height:230px;background:#000;position:relative;overflow:hidden;cursor:pointer;">
                    <?php if ($item->actual_embroidery_path || $item->digitized_preview_path): ?>
                    <img class="portfolio-img-after" src="<?= BASE_URL ?>/<?= $item->actual_embroidery_path ?: $item->digitized_preview_path ?>" alt="Embroidery" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:opacity 0.4s;">
                    <?php endif; ?>
                    <?php if ($item->original_artwork_path): ?>
                    <img class="portfolio-img-before" src="<?= BASE_URL ?>/<?= $item->original_artwork_path ?>" alt="Original" style="position:absolute;inset:0;width:100%;height:100%;object-fit:contain;padding:1rem;opacity:0;transition:opacity 0.4s;background:#0A0B0F;">
                    <?php endif; ?>
                    <div style="position:absolute;bottom:0.75rem;left:0.75rem;right:0.75rem;display:flex;justify-content:space-between;opacity:0;transition:opacity 0.3s;" class="portfolio-labels">
                        <span style="background:rgba(0,0,0,0.8);color:var(--text-secondary);padding:0.2rem 0.6rem;border-radius:9999px;font-size:0.7rem;backdrop-filter:blur(4px);">Hover → Original</span>
                    </div>
                </div>

                <div style="padding:1.25rem 1.5rem;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.5rem;">
                        <h3 style="font-size:1rem;font-weight:700;"><?= htmlspecialchars($item->title) ?></h3>
                        <span style="background:rgba(37,99,235,0.1);color:var(--blue-light);padding:0.15rem 0.55rem;border-radius:9999px;font-size:0.72rem;font-weight:600;flex-shrink:0;margin-left:0.5rem;">
                            <?= htmlspecialchars($item->category_name ?? 'Design') ?>
                        </span>
                    </div>
                    <?php if ($item->description): ?>
                    <p style="color:var(--text-muted);font-size:0.82rem;line-height:1.6;margin-bottom:1rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= htmlspecialchars($item->description) ?></p>
                    <?php endif; ?>
                    <div style="display:flex;gap:1.5rem;font-size:0.8rem;color:var(--text-muted);border-top:1px solid var(--border);padding-top:0.75rem;">
                        <?php if ($item->stitch_count): ?><span>🧵 <?= number_format($item->stitch_count) ?> stitches</span><?php endif; ?>
                        <?php if ($item->dimensions): ?><span>📐 <?= htmlspecialchars($item->dimensions) ?></span><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section style="padding:3rem 0 5rem;">
    <div class="container text-center reveal">
        <h2 style="font-size:1.8rem;font-weight:800;margin-bottom:1rem;">Ready to see your design come to life?</h2>
        <p style="color:var(--text-muted);margin-bottom:2rem;">Upload your artwork and get a quote within hours.</p>
        <a href="<?= BASE_URL ?>/quote" class="btn btn-primary" style="font-size:1rem;padding:0.85rem 2rem;">Get a Quote →</a>
    </div>
</section>

<script>
document.querySelectorAll('.portfolio-img-wrap').forEach(wrap => {
    const before = wrap.querySelector('.portfolio-img-before');
    const after  = wrap.querySelector('.portfolio-img-after');
    const labels = wrap.querySelector('.portfolio-labels');
    wrap.addEventListener('mouseenter', () => {
        if (before) before.style.opacity = '1';
        if (after)  after.style.opacity  = '0';
        if (labels) labels.style.opacity = '1';
    });
    wrap.addEventListener('mouseleave', () => {
        if (before) before.style.opacity = '0';
        if (after)  after.style.opacity  = '1';
        if (labels) labels.style.opacity = '0';
    });
});
</script>
