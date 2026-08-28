<!-- Hero -->
<section style="padding: 6rem 0; border-bottom: 1px solid var(--border-color);">
    <div class="container text-center">
        <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem; line-height: 1.2;">
            We Turn <span style="color: var(--accent-blue);">Artwork</span> Into <span style="color: var(--accent-gold);">Stitches</span>
        </h1>
        <p style="font-size: 1.25rem; color: var(--gray-text); max-width: 750px; margin: 0 auto;">
            ThreadPixel is a professional embroidery digitizing studio serving apparel brands, promotional product companies, embroidery shops, and creators worldwide.
        </p>
    </div>
</section>

<!-- Mission -->
<section class="container" style="padding: 5rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;">
        <div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Our Mission</h2>
            <p style="color: var(--gray-text); margin-bottom: 1.5rem; line-height: 1.8;">
                Our mission is to make professional-grade embroidery digitizing accessible, fast, and reliable for businesses of all sizes — from one-person Etsy shops to large-scale contract embroiderers.
            </p>
            <p style="color: var(--gray-text); line-height: 1.8;">
                Every design we create is handled by a real human digitizer, reviewed for quality before delivery, and optimized to run cleanly on your specific machine type.
            </p>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div style="background: var(--secondary-bg); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent-blue);">500+</div>
                <div style="color: var(--gray-text); font-size: 0.9rem; margin-top: 0.5rem;">Designs Delivered</div>
            </div>
            <div style="background: var(--secondary-bg); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent-gold);">20+</div>
                <div style="color: var(--gray-text); font-size: 0.9rem; margin-top: 0.5rem;">Countries Served</div>
            </div>
            <div style="background: var(--secondary-bg); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--success);">12h</div>
                <div style="color: var(--gray-text); font-size: 0.9rem; margin-top: 0.5rem;">Avg. Turnaround</div>
            </div>
            <div style="background: var(--secondary-bg); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color); text-align: center;">
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--danger);">98%</div>
                <div style="color: var(--gray-text); font-size: 0.9rem; margin-top: 0.5rem;">Satisfaction Rate</div>
            </div>
        </div>
    </div>
</section>

<!-- What Makes Us Different -->
<section style="background: var(--secondary-bg); padding: 5rem 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem;">What Makes Us Different</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div style="padding: 2rem; background: var(--primary-bg); border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🧵</div>
                <h4 style="margin-bottom: 0.75rem;">Human Digitizers Only</h4>
                <p style="color: var(--gray-text); font-size: 0.9rem;">Every order is handled by an experienced digitizer. No auto-digitizing software is used on your final files.</p>
            </div>
            <div style="padding: 2rem; background: var(--primary-bg); border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⚡</div>
                <h4 style="margin-bottom: 0.75rem;">Fast Delivery</h4>
                <p style="color: var(--gray-text); font-size: 0.9rem;">Most designs are ready within 12–24 hours. Rush options are available for urgent orders.</p>
            </div>
            <div style="padding: 2rem; background: var(--primary-bg); border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🌍</div>
                <h4 style="margin-bottom: 0.75rem;">International Service</h4>
                <p style="color: var(--gray-text); font-size: 0.9rem;">We work with clients from USA, UK, Australia, Europe, and beyond. All formats supported globally.</p>
            </div>
            <div style="padding: 2rem; background: var(--primary-bg); border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🔁</div>
                <h4 style="margin-bottom: 0.75rem;">Free Revisions</h4>
                <p style="color: var(--gray-text); font-size: 0.9rem;">We stand behind our work. If something isn't right, we fix it until you're completely satisfied.</p>
            </div>
        </div>
    </div>
</section>

<!-- Process Timeline -->
<section class="container" style="padding: 5rem 0;">
    <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 1rem;">Our Process</h2>
    <p style="text-align: center; color: var(--gray-text); margin-bottom: 4rem;">From your artwork to production-ready files in 4 simple steps.</p>

    <div style="position: relative; max-width: 800px; margin: 0 auto;">
        <!-- Timeline Line -->
        <div style="position: absolute; left: 28px; top: 0; bottom: 0; width: 2px; background: var(--border-color);"></div>

        <?php 
        $steps = [
            ['icon' => '📤', 'title' => 'Submit Your Artwork', 'desc' => 'Upload your logo, design, or artwork through our secure quote form. Include any notes about size, format, and placement.'],
            ['icon' => '💬', 'title' => 'We Review & Quote', 'desc' => 'Our team reviews your design, assesses the stitch count and complexity, and sends you a competitive price quote.'],
            ['icon' => '🧵', 'title' => 'Digitizing Begins', 'desc' => 'Once approved, our digitizers get to work — carefully mapping out every stitch path, underlay, and color stop.'],
            ['icon' => '📦', 'title' => 'File Delivery', 'desc' => 'You receive your embroidery files in your required format (DST, PES, etc.) directly through your dashboard.'],
        ];
        foreach ($steps as $i => $step): 
        ?>
        <div style="display: flex; gap: 2rem; margin-bottom: 2.5rem; position: relative;">
            <div style="width: 56px; height: 56px; background: var(--secondary-bg); border: 2px solid var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; z-index: 1;">
                <?= $step['icon'] ?>
            </div>
            <div style="background: var(--secondary-bg); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1;">
                <h4 style="margin-bottom: 0.5rem; color: var(--accent-blue);">Step <?= $i + 1 ?>: <?= $step['title'] ?></h4>
                <p style="color: var(--gray-text); margin: 0; font-size: 0.95rem;"><?= $step['desc'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section style="padding: 5rem 0; text-align: center;">
    <div class="container" style="background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(234,179,8,0.05)); padding: 4rem 2rem; border-radius: 16px; border: 1px solid var(--border-color);">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Ready to Work With Us?</h2>
        <p style="color: var(--gray-text); margin-bottom: 2rem; font-size: 1.1rem;">Join hundreds of businesses who trust ThreadPixel with their embroidery digitizing needs.</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="<?= BASE_URL ?>/quote" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Get a Quote</a>
            <a href="<?= BASE_URL ?>/contact" class="btn btn-outline" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Contact Us</a>
        </div>
    </div>
</section>
