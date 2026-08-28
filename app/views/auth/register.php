<div class="container py-5">
    <div style="max-width: 550px; margin: 0 auto; background-color: var(--secondary-bg); padding: 3rem; border-radius: 12px; border: 1px solid var(--border-color);">
        <div class="text-center mb-4">
            <h2>Create an Account</h2>
            <p style="color: var(--gray-text);">Join ThreadPixel to manage your digitizing projects.</p>
        </div>

        <form action="<?= BASE_URL ?>/auth/registerPost" method="POST">
            <?= CSRF::getTokenField() ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Business Name</label>
                    <input type="text" name="business_name" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" name="confirm_password" class="form-control" required minlength="8">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary mt-4" style="width: 100%;">Create Account</button>
        </form>
        
        <div class="text-center mt-4" style="color: var(--gray-text); font-size: 0.9rem;">
            Already have an account? <a href="<?= BASE_URL ?>/auth/login" style="font-weight: 600;">Log in</a>
        </div>
    </div>
</div>
