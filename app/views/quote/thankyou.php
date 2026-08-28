<div class="container py-5 text-center">
    <div style="max-width: 600px; margin: 0 auto; background-color: var(--secondary-bg); padding: 4rem; border-radius: 12px; border: 1px solid var(--success);">
        <div style="font-size: 4rem; color: var(--success); margin-bottom: 1rem;">&#10003;</div>
        <h1 style="margin-bottom: 1rem;">Request Received!</h1>
        <p style="color: var(--gray-text); font-size: 1.1rem; margin-bottom: 2rem;">
            Thank you for choosing ThreadPixel. Your quote request has been submitted successfully and is currently under review by our digitizing team.
        </p>
        <div style="background-color: var(--primary-bg); padding: 1.5rem; border-radius: 8px; font-size: 1.5rem; font-weight: 700; color: var(--accent-blue); margin-bottom: 2rem; border: 1px dashed var(--border-color);">
            <?= htmlspecialchars($quoteNumber) ?>
        </div>
        <p style="color: var(--gray-text); margin-bottom: 2rem; font-size: 0.9rem;">
            We will email you the pricing details soon. If you created an account, you can track the status in your dashboard.
        </p>
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-primary">Go to Dashboard</a>
    </div>
</div>
