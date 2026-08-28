<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/admin/portfolio" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Portfolio</a>
    <h1 style="font-size: 1.8rem; margin-top: 1rem;"><?= $item ? 'Edit' : 'Add' ?> Portfolio Item</h1>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 2rem; max-width: 800px;">
    <form action="<?= BASE_URL ?>/admin/<?= $item ? 'editPortfolio/' . $item->id : 'addPortfolio' ?>" method="POST" enctype="multipart/form-data">
        <?= CSRF::getTokenField() ?>
        
        <div class="form-group">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control" value="<?= $item ? htmlspecialchars($item->title) : '' ?>" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">None</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat->id ?>" <?= ($item && $item->category_id == $cat->id) ? 'selected' : '' ?>><?= htmlspecialchars($cat->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Stitch Count</label>
                <input type="number" name="stitch_count" class="form-control" value="<?= $item ? $item->stitch_count : '' ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Dimensions</label>
                <input type="text" name="dimensions" class="form-control" value="<?= $item ? htmlspecialchars($item->dimensions) : '' ?>" placeholder="e.g. 4x4 inches">
            </div>
            
            <div class="form-group">
                <label class="form-label">Machine Formats</label>
                <input type="text" name="machine_formats" class="form-control" value="<?= $item ? htmlspecialchars($item->machine_formats) : '' ?>" placeholder="e.g. DST, PES, EXP">
            </div>
        </div>
        
        <div class="form-group mt-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= $item ? htmlspecialchars($item->description) : '' ?></textarea>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Original Artwork (Image)</label>
                <input type="file" name="original_artwork" class="form-control" accept="image/*">
                <?php if($item && $item->original_artwork_path): ?>
                    <small style="color: var(--success); display: block; margin-top: 0.5rem;">Current file exists</small>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Digitized Preview (Image)</label>
                <input type="file" name="digitized_preview" class="form-control" accept="image/*">
                <?php if($item && $item->digitized_preview_path): ?>
                    <small style="color: var(--success); display: block; margin-top: 0.5rem;">Current file exists</small>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Actual Embroidery (Image)</label>
                <input type="file" name="actual_embroidery" class="form-control" accept="image/*">
                <?php if($item && $item->actual_embroidery_path): ?>
                    <small style="color: var(--success); display: block; margin-top: 0.5rem;">Current file exists</small>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-group mt-3">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" <?= ($item && $item->is_featured) ? 'checked' : '' ?>>
                <span>Feature this item on the homepage</span>
            </label>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4"><?= $item ? 'Update' : 'Save' ?> Portfolio Item</button>
    </form>
</div>
