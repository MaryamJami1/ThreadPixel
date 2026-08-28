<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <h1 style="font-size: 1.8rem;">Admin Overview</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Total Customers</h4>
        <div class="stat-value"><?= $totalCustomers ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Pending Quotes</h4>
        <div class="stat-value" style="<?= $pendingQuotes > 0 ? 'color: var(--warning);' : '' ?>"><?= $pendingQuotes ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Active Orders</h4>
        <div class="stat-value" style="<?= $activeOrders > 0 ? 'color: var(--accent-blue);' : '' ?>"><?= $activeOrders ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Completed Orders</h4>
        <div class="stat-value"><?= $completedOrders ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Total Revenue</h4>
        <div class="stat-value" style="color: var(--success);">$<?= number_format($revenue, 2) ?></div>
    </div>
    <div class="stat-card">
        <h4 style="color: var(--gray-text); font-size: 0.9rem; text-transform: uppercase;">Unread Messages</h4>
        <div class="stat-value" style="<?= $unreadMessages > 0 ? 'color: var(--danger);' : '' ?>"><?= $unreadMessages ?></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Quick Actions -->
    <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
        <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Quick Actions</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <a href="<?= BASE_URL ?>/admin/quotes" class="btn btn-outline" style="text-align: left;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem;">Review Quotes</div>
                <div style="font-size: 0.8rem; color: var(--gray-text);">Process pending quote requests</div>
            </a>
            <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-outline" style="text-align: left;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem;">Manage Orders</div>
                <div style="font-size: 0.8rem; color: var(--gray-text);">Update status and upload files</div>
            </a>
            <a href="<?= BASE_URL ?>/admin/portfolio" class="btn btn-outline" style="text-align: left;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem;">Update Portfolio</div>
                <div style="font-size: 0.8rem; color: var(--gray-text);">Add new digitizing examples</div>
            </a>
            <a href="<?= BASE_URL ?>/admin/messages" class="btn btn-outline" style="text-align: left;">
                <div style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem;">Messages</div>
                <div style="font-size: 0.8rem; color: var(--gray-text);">Reply to customer inquiries</div>
            </a>
        </div>
    </div>
</div>
