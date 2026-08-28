<?php $layout = 'dashboard'; ?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.8rem;">My Quotes</h1>
    <a href="<?= BASE_URL ?>/quote" class="btn btn-primary">Request New Quote</a>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
    <?php if (empty($quotes)): ?>
        <p style="color: var(--gray-text); text-align: center; padding: 3rem 0;">You haven't requested any quotes yet.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Quote #</th>
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
                            <a href="<?= BASE_URL ?>/dashboard/quoteDetail/<?= $quote->id ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
