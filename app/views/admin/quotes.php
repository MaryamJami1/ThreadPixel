<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <h1 style="font-size: 1.8rem;">Manage Quotes</h1>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
    <?php if (empty($quotes)): ?>
        <p style="color: var(--gray-text); text-align: center; padding: 3rem 0;">No quotes found.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Quote #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($quotes as $quote): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= $quote->quote_number ?></td>
                        <td>
                            <div><?= htmlspecialchars($quote->customer_name) ?></div>
                            <div style="font-size: 0.8rem; color: var(--gray-text);"><?= htmlspecialchars($quote->customer_email) ?></div>
                        </td>
                        <td><?= date('M j, Y', strtotime($quote->created_at)) ?></td>
                        <td><?= $quote->service_name ?? 'Custom' ?></td>
                        <td>
                            <?php if($quote->status === 'Approved'): ?>
                                <span class="badge badge-success">Approved</span>
                            <?php elseif($quote->status === 'Pending' || $quote->status === 'Under Review'): ?>
                                <span class="badge badge-pending"><?= $quote->status ?></span>
                            <?php elseif($quote->status === 'Quoted'): ?>
                                <span class="badge badge-primary">Quoted ($<?= number_format($quote->quoted_price, 2) ?>)</span>
                            <?php else: ?>
                                <span class="badge" style="background: rgba(156, 163, 175, 0.2); color: var(--gray-text);"><?= $quote->status ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/quoteDetail/<?= $quote->id ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Review</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
