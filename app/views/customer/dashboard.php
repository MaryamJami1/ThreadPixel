<?php
// Set layout for this view
$layout = 'dashboard';
?>

<div class="mb-4">
    <h1 style="font-size: 1.8rem;">Dashboard Overview</h1>
    <p style="color: var(--gray-text);">Welcome back, track your recent quotes and orders.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Active Quotes</h4>
        <div class="stat-value"><?= count(array_filter($quotes, fn($q) => !in_array($q->status, ['Rejected', 'Converted to Order', 'Expired']))) ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Pending Orders</h4>
        <div class="stat-value"><?= count(array_filter($orders, fn($o) => !in_array($o->status, ['Delivered', 'Cancelled']))) ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Completed Orders</h4>
        <div class="stat-value"><?= count(array_filter($orders, fn($o) => $o->status === 'Delivered')) ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Unread Messages</h4>
        <div class="stat-value" style="<?= $unreadMessages > 0 ? 'color: var(--accent-gold);' : '' ?>"><?= $unreadMessages ?></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Recent Quotes -->
    <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.2rem;">Recent Quotes</h3>
            <a href="<?= BASE_URL ?>/dashboard/quotes" style="font-size: 0.9rem;">View All</a>
        </div>
        
        <?php if (empty($quotes)): ?>
            <p style="color: var(--gray-text); text-align: center; padding: 2rem 0;">You have no quotes yet.</p>
        <?php else: ?>
            <table class="data-table">
                <tbody>
                    <?php foreach(array_slice($quotes, 0, 5) as $quote): ?>
                        <tr>
                            <td>
                                <div><a href="<?= BASE_URL ?>/dashboard/quoteDetail/<?= $quote->id ?>"><?= $quote->quote_number ?></a></div>
                                <div style="font-size: 0.8rem; color: var(--gray-text);"><?= date('M j, Y', strtotime($quote->created_at)) ?></div>
                            </td>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Recent Orders -->
    <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.2rem;">Recent Orders</h3>
            <a href="<?= BASE_URL ?>/dashboard/orders" style="font-size: 0.9rem;">View All</a>
        </div>
        
        <?php if (empty($orders)): ?>
            <p style="color: var(--gray-text); text-align: center; padding: 2rem 0;">You have no active orders.</p>
        <?php else: ?>
            <table class="data-table">
                <tbody>
                    <?php foreach(array_slice($orders, 0, 5) as $order): ?>
                        <tr>
                            <td>
                                <div><a href="<?= BASE_URL ?>/dashboard/orderDetail/<?= $order->id ?>"><?= $order->order_number ?></a></div>
                                <div style="font-size: 0.8rem; color: var(--gray-text);"><?= date('M j, Y', strtotime($order->created_at)) ?></div>
                            </td>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
