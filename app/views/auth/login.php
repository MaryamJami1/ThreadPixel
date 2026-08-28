<div class="container py-5">
    <div style="max-width: 450px; margin: 0 auto; background-color: var(--secondary-bg); padding: 3rem; border-radius: 12px; border: 1px solid var(--border-color);">
        <div class="text-center mb-4">
            <h2>Welcome Back</h2>
            <p style="color: var(--gray-text);">Log in to manage your quotes and orders.</p>
        </div>

        <form action="<?= BASE_URL ?>/auth/loginPost" method="POST">
            <?= CSRF::getTokenField() ?>
            
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            
            <div class="form-group mb-4">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <label class="form-label" style="margin-bottom: 0;">Password</label>
                    <a href="<?= BASE_URL ?>/auth/forgotPassword" style="font-size: 0.85rem;">Forgot?</a>
                </div>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Log In</button>
        </form>
        
        <div class="text-center mt-4" style="color: var(--gray-text); font-size: 0.9rem;">
            Don't have an account? <a href="<?= BASE_URL ?>/auth/register" style="font-weight: 600;">Create one</a>
        </div>
    </div>
</div>
