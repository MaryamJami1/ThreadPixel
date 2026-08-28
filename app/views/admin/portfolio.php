<?php $layout = 'dashboard'; ?>
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.8rem;">Manage Portfolio</h1>
    <a href="<?= BASE_URL ?>/admin/addPortfolio" class="btn btn-primary">Add Portfolio Item</a>
</div>

<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
    <?php if (empty($items)): ?>
        <p style="color: var(--gray-text); text-align: center; padding: 3rem 0;">No portfolio items found.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
            <?php foreach($items as $item): ?>
                <div style="background: var(--primary-bg); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                    <div style="height: 150px; background: #000; display: flex; align-items: center; justify-content: center;">
                        <?php if($item->digitized_preview_path): ?>
                            <img src="<?= BASE_URL ?>/<?= $item->digitized_preview_path ?>" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        <?php else: ?>
                            <span style="color: var(--gray-text);">No Image</span>
                        <?php endif; ?>
                    </div>
                    <div style="padding: 1rem;">
                        <h4 style="margin-bottom: 0.5rem; font-size: 1.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($item->title) ?></h4>
                        <div style="font-size: 0.8rem; color: var(--gray-text); margin-bottom: 1rem;">
                            <?= htmlspecialchars($item->category_name ?? 'Uncategorized') ?>
                            <?php if($item->is_featured): ?>
                                &bull; <span style="color: var(--accent-gold);">Featured</span>
                            <?php endif; ?>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?= BASE_URL ?>/admin/editPortfolio/<?= $item->id ?>" class="btn btn-outline" style="flex: 1; padding: 0.3rem 0; font-size: 0.8rem;">Edit</a>
                            <form action="<?= BASE_URL ?>/admin/deletePortfolio/<?= $item->id ?>" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this portfolio item?');">
                                <?= CSRF::getTokenField() ?>
                                <button type="submit" class="btn btn-outline" style="width: 100%; padding: 0.3rem 0; font-size: 0.8rem; border-color: var(--danger); color: var(--danger);">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
