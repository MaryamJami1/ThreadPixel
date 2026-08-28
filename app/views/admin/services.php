<?php $layout = 'dashboard'; ?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.8rem;">Manage Services & Pricing</h1>
    <a href="<?= BASE_URL ?>/admin/addService" class="btn btn-primary">Add New Service</a>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
    <?php if (empty($services)): ?>
        <p style="color: var(--gray-text); text-align: center; padding: 3rem 0;">No services found.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Starting Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($services as $service): ?>
                    <tr>
                        <td><?= $service->id ?></td>
                        <td style="font-weight: 600;"><?= htmlspecialchars($service->name) ?></td>
                        <td>$<?= number_format($service->starting_price, 2) ?></td>
                        <td>
                            <?php if($service->is_active): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge" style="background: rgba(156, 163, 175, 0.2); color: var(--gray-text);">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/editService/<?= $service->id ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Edit</a>
                            
                            <form action="<?= BASE_URL ?>/admin/deleteService/<?= $service->id ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Delete this service?');">
                                <?= CSRF::getTokenField() ?>
                                <button type="submit" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; border-color: var(--danger); color: var(--danger);">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
