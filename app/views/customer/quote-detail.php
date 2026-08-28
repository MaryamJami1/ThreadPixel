<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/dashboard/quotes" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Quotes</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
        <h1 style="font-size: 1.8rem;">Quote #<?= $quote->quote_number ?></h1>
        <div>
            <?php if($quote->status === 'Approved'): ?>
                <span class="badge badge-success" style="font-size: 1rem; padding: 0.5rem 1rem;">Approved</span>
            <?php elseif($quote->status === 'Pending' || $quote->status === 'Under Review'): ?>
                <span class="badge badge-pending" style="font-size: 1rem; padding: 0.5rem 1rem;"><?= $quote->status ?></span>
            <?php elseif($quote->status === 'Quoted'): ?>
                <span class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">Quoted: $<?= number_format($quote->quoted_price, 2) ?></span>
            <?php else: ?>
                <span class="badge" style="background: rgba(156, 163, 175, 0.2); color: var(--gray-text); font-size: 1rem; padding: 0.5rem 1rem;"><?= $quote->status ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Project Details</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Service</span><strong><?= $quote->service_name ?? 'Custom' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Machine Format</span><strong><?= $quote->machine_format ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Design Size</span><strong><?= $quote->design_size ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Garment Type</span><strong><?= $quote->garment_type ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Quantity</span><strong><?= $quote->quantity ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Rush Order</span><strong><?= $quote->is_rush ? 'Yes' : 'No' ?></strong></div>
            </div>

            <?php if($quote->additional_instructions): ?>
                <div style="margin-top: 1.5rem;">
                    <span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Additional Instructions</span>
                    <p style="background: var(--primary-bg); padding: 1rem; border-radius: 4px; margin-top: 0.5rem; border: 1px solid var(--border-color);"><?= nl2br(htmlspecialchars($quote->additional_instructions)) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Uploaded Files</h3>
            <?php if(empty($files)): ?>
                <p style="color: var(--gray-text);">No files attached.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($files as $file): ?>
                        <li style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 4px; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center; background: var(--primary-bg);">
                            <span><?= htmlspecialchars($file->file_name) ?></span>
                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($file->file_path) ?>" target="_blank" class="btn btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">View</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <?php if($quote->status === 'Quoted'): ?>
            <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--accent-blue); padding: 1.5rem; position: sticky; top: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1rem; color: var(--accent-blue);">Action Required</h3>
                <p style="color: var(--gray-text); margin-bottom: 1.5rem; font-size: 0.9rem;">Your quote is ready! Please approve the quote to proceed with the order, or reject it if you wish to cancel.</p>
                
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center;">
                    $<?= number_format($quote->quoted_price, 2) ?>
                </div>

                <form action="<?= BASE_URL ?>/dashboard/approveQuote/<?= $quote->id ?>" method="POST" style="margin-bottom: 1rem;">
                    <?= CSRF::getTokenField() ?>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Approve & Proceed</button>
                </form>

                <form action="<?= BASE_URL ?>/dashboard/rejectQuote/<?= $quote->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to reject this quote?');">
                    <?= CSRF::getTokenField() ?>
                    <button type="submit" class="btn btn-outline" style="width: 100%; border-color: var(--danger); color: var(--danger);">Reject Quote</button>
                </form>
            </div>
        <?php endif; ?>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-top: <?= $quote->status === 'Quoted' ? '2rem' : '0' ?>;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1rem;">Need Help?</h3>
            <p style="color: var(--gray-text); font-size: 0.9rem; margin-bottom: 1.5rem;">Have questions about this quote? Send us a message.</p>
            <a href="<?= BASE_URL ?>/dashboard/messages" class="btn btn-outline" style="width: 100%;">Message Us</a>
        </div>
    </div>
</div>
