<div class="container py-5">
    <div class="text-center mb-4">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Get in Touch</h1>
        <p style="font-size: 1.2rem; color: var(--gray-text); max-width: 700px; margin: 0 auto;">
            Have a question about a complex design? Need help with an existing order? Drop us a message below.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 4rem; max-width: 1000px; margin: 4rem auto 0;">
        
        <div>
            <div style="margin-bottom: 2rem;">
                <h3 style="color: var(--accent-blue); margin-bottom: 0.5rem; font-size: 1.2rem;">Worldwide Service</h3>
                <p style="color: var(--gray-text);">ThreadPixel serves embroidery businesses, brands, and individuals internationally.</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <h3 style="color: var(--accent-blue); margin-bottom: 0.5rem; font-size: 1.2rem;">Email Us</h3>
                <p style="color: var(--gray-text);">support@threadpixel.com<br>quotes@threadpixel.com</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <h3 style="color: var(--accent-blue); margin-bottom: 0.5rem; font-size: 1.2rem;">Operating Hours</h3>
                <p style="color: var(--gray-text);">Monday - Saturday<br>24 Hours Support</p>
            </div>
            
            <div style="padding: 1.5rem; background: rgba(37,99,235,0.1); border-radius: 8px; border: 1px solid rgba(37,99,235,0.3);">
                <p style="font-size: 0.9rem; margin-bottom: 1rem;"><strong>Need a price estimate?</strong></p>
                <a href="<?= BASE_URL ?>/quote" class="btn btn-primary" style="width: 100%; font-size: 0.9rem; padding: 0.5rem;">Use Quote Form</a>
            </div>
        </div>
        
        <div style="background-color: var(--secondary-bg); padding: 3rem; border-radius: 12px; border: 1px solid var(--border-color);">
            <form action="<?= BASE_URL ?>/contact/store" method="POST">
                <?= CSRF::getTokenField() ?>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= Session::userName() ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" value="<?= Session::userId() ? Session::get('user_email') : '' ?>" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="6" required></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3" style="width: 100%; padding: 1rem;">Send Message</button>
            </form>
        </div>
        
    </div>
</div>
