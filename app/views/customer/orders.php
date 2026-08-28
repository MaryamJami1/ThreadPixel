<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <h1 style="font-size: 1.8rem;">My Orders</h1>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
    <?php if (empty($orders)): ?>
        <p style="color: var(--gray-text); text-align: center; padding: 3rem 0;">You don't have any orders yet.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= $order->order_number ?></td>
                        <td><?= date('M j, Y', strtotime($order->created_at)) ?></td>
                        <td><?= $order->service_name ?? 'Custom' ?></td>
                        <td>$<?= number_format($order->total_price, 2) ?></td>
                        <td>
                            <?php if($order->status === 'Delivered'): ?>
                                <span class="badge badge-success">Delivered</span>
                            <?php elseif($order->status === 'Cancelled'): ?>
                                <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: var(--danger);">Cancelled</span>
                            <?php else: ?>
                                <span class="badge badge-primary"><?= $order->status ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/dashboard/orderDetail/<?= $order->id ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View Status</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
