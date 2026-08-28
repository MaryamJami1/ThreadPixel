<section class="contact-hero">
    <div class="container contact-hero-grid">
        <div class="contact-hero-copy reveal">
            <div class="eyebrow"><span class="eyebrow-dot"></span> Let’s talk about your next piece</div>
            <h1>Good work<br>starts with a<br><em>good brief.</em></h1>
            <p>Have a design in mind, a production question, or an existing order to discuss? Our team is ready to help you find the right next stitch.</p>
        </div>
        <div class="contact-hero-art reveal reveal-delay-1" aria-hidden="true"><div class="contact-orbit"></div><div class="contact-thread"></div><div class="contact-needle"></div><span class="contact-pixel cp-one"></span><span class="contact-pixel cp-two"></span><span class="contact-pixel cp-three"></span><strong>OPEN<br><em>CHANNEL</em></strong></div>
    </div>
</section>

<section class="contact-main section">
    <div class="container contact-layout">
        <aside class="contact-sidebar">
            <div class="eyebrow reveal">Find your way in</div>
            <h2 class="reveal">A real person<br>is on the other end.</h2>
            <p class="contact-intro reveal">Whether you are preparing a first logo or managing a full apparel run, send the details you have. We will help shape the rest.</p>
            <div class="contact-channel-list">
                <a class="contact-channel reveal reveal-delay-1" href="mailto:support@threadpixel.com"><span class="channel-icon">@</span><span><small>General support</small><strong>support@threadpixel.com</strong></span><b>↗</b></a>
                <a class="contact-channel reveal reveal-delay-2" href="mailto:quotes@threadpixel.com"><span class="channel-icon">$</span><span><small>Quote questions</small><strong>quotes@threadpixel.com</strong></span><b>↗</b></a>
                <div class="contact-channel reveal reveal-delay-3"><span class="channel-icon">◷</span><span><small>Response window</small><strong>Monday – Saturday / 24h support</strong></span></div>
            </div>
            <div class="contact-side-note reveal"><span class="note-dot"></span> Serving brands, shops, and creators worldwide.</div>
        </aside>

        <div class="contact-form-panel reveal reveal-delay-1">
            <div class="form-panel-heading"><div><span class="eyebrow">Start a conversation</span><h2>Tell us what you’re making.</h2></div><span class="form-index">01 / 01</span></div>
            <p class="form-note">For a price estimate, include your artwork, size, garment, and deadline in the message.</p>
            <form action="<?= BASE_URL ?>/contact/store" method="POST" class="contact-form">
                <?= CSRF::getTokenField() ?>
                <div class="contact-form-grid">
                    <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" value="<?= Session::userName() ?? '' ?>" placeholder="Your name" required></div>
                    <div class="form-group"><label class="form-label">Email Address *</label><input type="email" name="email" class="form-control" value="<?= Session::userId() ? Session::get('user_email') : '' ?>" placeholder="you@company.com" required></div>
                    <div class="form-group form-wide"><label class="form-label">Subject</label><input type="text" name="subject" class="form-control" placeholder="What can we help with?" required></div>
                    <div class="form-group form-wide"><label class="form-label">Message *</label><textarea name="message" class="form-control" rows="6" placeholder="Tell us about your design, fabric, size, or deadline..." required></textarea></div>
                </div>
                <div class="form-submit-row"><span>We usually reply within one business day.</span><button type="submit" class="btn btn-primary">Send Message <span>↗</span></button></div>
            </form>
        </div>
    </div>
</section>

<section class="contact-bottom"><div class="container contact-bottom-inner reveal"><div><span class="eyebrow">Need pricing instead?</span><h2>Take the direct route.</h2></div><p>Upload your artwork and receive a professional quote built around your production needs.</p><a href="<?= BASE_URL ?>/quote" class="btn btn-outline">Get a Free Quote <span>→</span></a></div></section>
