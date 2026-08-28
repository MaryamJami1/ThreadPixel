<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/admin/quotes" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Quotes</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
        <h1 style="font-size: 1.8rem;">Review Quote #<?= $quote->quote_number ?></h1>
        <span class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;"><?= $quote->status ?></span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Customer Information</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Name</span><strong><?= htmlspecialchars($quote->customer_name) ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Email</span><strong><a href="mailto:<?= htmlspecialchars($quote->customer_email) ?>"><?= htmlspecialchars($quote->customer_email) ?></a></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Business Name</span><strong><?= htmlspecialchars($quote->business_name) ?: 'N/A' ?></strong></div>
            </div>
        </div>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Project Requirements</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Service</span><strong><?= $quote->service_name ?? 'Custom' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Machine Format</span><strong><?= htmlspecialchars($quote->machine_format) ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Design Size</span><strong><?= htmlspecialchars($quote->design_size) ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Garment Type</span><strong><?= htmlspecialchars($quote->garment_type) ?: 'N/A' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Quantity</span><strong><?= $quote->quantity ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Rush Order</span><strong style="<?= $quote->is_rush ? 'color: var(--warning);' : '' ?>"><?= $quote->is_rush ? 'Yes (24h)' : 'No' ?></strong></div>
            </div>

            <?php if($quote->additional_instructions): ?>
                <div style="margin-top: 1.5rem;">
                    <span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Additional Instructions</span>
                    <p style="background: var(--primary-bg); padding: 1rem; border-radius: 4px; margin-top: 0.5rem; border: 1px solid var(--border-color);"><?= nl2br(htmlspecialchars($quote->additional_instructions)) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Customer Artwork Files</h3>
            <?php if(empty($files)): ?>
                <p style="color: var(--gray-text);">No files attached.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($files as $file): ?>
                        <li style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 4px; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center; background: var(--primary-bg);">
                            <span><?= htmlspecialchars($file->file_name) ?></span>
                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($file->file_path) ?>" target="_blank" class="btn btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Download</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; position: sticky; top: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Process Quote</h3>
            
            <?php if($quote->status === 'Approved'): ?>
                <div style="margin-bottom: 1.5rem;">
                    <p style="color: var(--success); font-weight: 600; margin-bottom: 1rem;">Customer has approved this quote.</p>
                    <form action="<?= BASE_URL ?>/admin/convertToOrder/<?= $quote->id ?>" method="POST">
                        <?= CSRF::getTokenField() ?>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Convert to Order</button>
                    </form>
                </div>
            <?php else: ?>
                <form action="<?= BASE_URL ?>/admin/updateQuoteStatus/<?= $quote->id ?>" method="POST">
                    <?= CSRF::getTokenField() ?>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Pending" <?= $quote->status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Under Review" <?= $quote->status === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                            <option value="Quoted" <?= $quote->status === 'Quoted' ? 'selected' : '' ?>>Quoted (Send to Customer)</option>
                            <option value="Rejected" <?= $quote->status === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                            <option value="Expired" <?= $quote->status === 'Expired' ? 'selected' : '' ?>>Expired</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Price Quote ($)</label>
                        <input type="number" step="0.01" name="quoted_price" class="form-control" value="<?= $quote->quoted_price ?>">
                        <small style="color: var(--gray-text);">Required if status is "Quoted".</small>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Update Status</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
