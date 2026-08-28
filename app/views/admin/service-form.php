<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/admin/services" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Services</a>
    <h1 style="font-size: 1.8rem; margin-top: 1rem;"><?= $service ? 'Edit' : 'Add' ?> Service</h1>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 2rem; max-width: 800px;">
    <form action="<?= BASE_URL ?>/admin/<?= $service ? 'editService/' . $service->id : 'addService' ?>" method="POST">
        <?= CSRF::getTokenField() ?>
        
        <div class="form-group">
            <label class="form-label">Service Name *</label>
            <input type="text" name="name" class="form-control" value="<?= $service ? htmlspecialchars($service->name) : '' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Starting Price ($) *</label>
            <input type="number" step="0.01" name="starting_price" class="form-control" value="<?= $service ? $service->starting_price : '0.00' ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" rows="4" required><?= $service ? htmlspecialchars($service->description) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Suitable Applications (Comma separated)</label>
            <input type="text" name="suitable_applications" class="form-control" value="<?= $service ? htmlspecialchars($service->suitable_applications) : '' ?>" placeholder="e.g. Hats, Polos, Jackets">
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" <?= (!$service || $service->is_active) ? 'checked' : '' ?>>
                <span>Service is active and visible to customers</span>
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4"><?= $service ? 'Update' : 'Save' ?> Service</button>
    </form>
</div>
