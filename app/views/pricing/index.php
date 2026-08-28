<div class="container py-5">
    <div class="text-center mb-4">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Transparent, Honest Pricing</h1>
        <p style="font-size: 1.2rem; color: var(--gray-text); max-width: 700px; margin: 0 auto;">
            No hidden charges. No surprises. Get a clear picture of what professional embroidery digitizing costs before you order.
        </p>
    </div>

    <!-- Pricing Cards -->
    <?php if (!empty($services)): ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
        <?php foreach ($services as $index => $service): ?>
        <div style="background-color: var(--secondary-bg); padding: 2.5rem; border-radius: 12px; border: <?= $index === 1 ? '2px solid var(--accent-blue)' : '1px solid var(--border-color)' ?>; position: relative;">
            <?php if ($index === 1): ?>
                <div style="position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--accent-blue); color: white; padding: 0.25rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Most Popular</div>
            <?php endif; ?>

            <h3 style="font-size: 1.4rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($service->name) ?></h3>
            <p style="color: var(--gray-text); font-size: 0.9rem; margin-bottom: 2rem; min-height: 50px;"><?= htmlspecialchars($service->description) ?></p>

            <div style="margin-bottom: 2rem;">
                <span style="font-size: 0.9rem; color: var(--gray-text);">Starting from</span>
                <div style="font-size: 3rem; font-weight: 800; color: var(--primary-text); line-height: 1.1;">
                    $<?= number_format($service->starting_price, 2) ?>
                </div>
                <span style="color: var(--gray-text); font-size: 0.85rem;">per design</span>
            </div>

            <?php if ($service->suitable_applications): ?>
            <ul style="list-style: none; padding: 0; margin-bottom: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <?php foreach (explode(',', $service->suitable_applications) as $app): ?>
                <li style="color: var(--gray-text); font-size: 0.9rem; padding: 0.3rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="color: var(--success); font-weight: 700;">✓</span> <?= htmlspecialchars(trim($app)) ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/quote?service=<?= $service->id ?>" class="btn <?= $index === 1 ? 'btn-primary' : 'btn-outline' ?>" style="width: 100%; text-align: center; display: block;">Get a Quote</a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="text-align: center; color: var(--gray-text); padding: 3rem 0;">Pricing information coming soon.</p>
    <?php endif; ?>

    <!-- Pricing FAQ -->
    <div style="max-width: 800px; margin: 5rem auto 0;">
        <h2 style="text-align: center; margin-bottom: 3rem;">Pricing FAQ</h2>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="background: var(--secondary-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <h4 style="margin-bottom: 0.5rem; color: var(--accent-blue);">What affects the final price?</h4>
                <p style="color: var(--gray-text); margin: 0;">Stitch count, design complexity, number of color changes, size, and rush order requirements all affect final pricing.</p>
            </div>
            <div style="background: var(--secondary-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <h4 style="margin-bottom: 0.5rem; color: var(--accent-blue);">Do you offer revisions?</h4>
                <p style="color: var(--gray-text); margin: 0;">Yes. Minor revisions are included with every order. Major redesigns may incur additional fees.</p>
            </div>
            <div style="background: var(--secondary-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <h4 style="margin-bottom: 0.5rem; color: var(--accent-blue);">Is there a bulk discount?</h4>
                <p style="color: var(--gray-text); margin: 0;">Yes! We offer custom bulk pricing for agencies and embroidery businesses with regular volume. Contact us to discuss.</p>
            </div>
            <div style="background: var(--secondary-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <h4 style="margin-bottom: 0.5rem; color: var(--accent-blue);">What formats are included in the price?</h4>
                <p style="color: var(--gray-text); margin: 0;">You receive your chosen primary format (DST, PES, EXP, JEF, VP3, etc.) at no extra cost. Additional formats may be requested.</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div style="text-align: center; margin-top: 5rem; padding: 4rem 2rem; background: var(--secondary-bg); border-radius: 12px; border: 1px solid var(--border-color);">
        <h2 style="margin-bottom: 1rem;">Not sure what you need?</h2>
        <p style="color: var(--gray-text); margin-bottom: 2rem;">Submit your artwork and requirements. We'll review it and send you an exact quote within a few hours.</p>
        <a href="<?= BASE_URL ?>/quote" class="btn btn-primary" style="padding: 1rem 3rem; font-size: 1.1rem;">Get a Free Quote</a>
    </div>
</div>
