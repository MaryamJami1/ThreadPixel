<div class="container py-5">
    <div class="text-center mb-4">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Frequently Asked Questions</h1>
        <p style="font-size: 1.2rem; color: var(--gray-text); max-width: 700px; margin: 0 auto;">
            Find answers to common questions about our digitizing process, file formats, turnaround times, and more.
        </p>
    </div>

    <div style="max-width: 900px; margin: 3rem auto 0;">
        <?php if (empty($grouped)): ?>
            <p style="text-align: center; color: var(--gray-text);">No FAQs available at the moment.</p>
        <?php else: ?>
            <?php foreach ($grouped as $category => $faqs): ?>
                <h3 style="color: var(--accent-blue); margin-top: 2.5rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <?= htmlspecialchars($category) ?>
                </h3>
                
                <div class="faq-group" style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($faqs as $faq): ?>
                        <div style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                            <div class="faq-question" style="padding: 1.25rem 1.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600;" onclick="toggleFaq(this)">
                                <?= htmlspecialchars($faq->question) ?>
                                <span class="faq-icon" style="color: var(--accent-blue); transition: transform 0.3s;">+</span>
                            </div>
                            <div class="faq-answer" style="padding: 0 1.5rem; max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out, padding 0.3s ease;">
                                <p style="color: var(--gray-text); padding-bottom: 1.25rem;">
                                    <?= nl2br(htmlspecialchars($faq->answer)) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 5rem; padding: 3rem; background: var(--secondary-bg); border-radius: 12px; border: 1px solid var(--border-color);">
        <h3 style="margin-bottom: 1rem;">Still have questions?</h3>
        <p style="color: var(--gray-text); margin-bottom: 1.5rem;">Our support team is here to help you with your custom requirements.</p>
        <a href="<?= BASE_URL ?>/contact" class="btn btn-outline">Contact Support</a>
    </div>
</div>

<script>
    function toggleFaq(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.faq-icon');
        const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';
        
        // Close all others (optional accordion style)
        document.querySelectorAll('.faq-answer').forEach(el => {
            el.style.maxHeight = null;
        });
        document.querySelectorAll('.faq-icon').forEach(el => {
            el.innerHTML = '+';
            el.style.transform = 'rotate(0deg)';
        });

        if (!isOpen) {
            answer.style.maxHeight = answer.scrollHeight + "px";
            icon.innerHTML = '−';
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>
