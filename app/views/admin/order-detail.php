<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/admin/orders" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Orders</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
        <h1 style="font-size: 1.8rem;">Manage Order #<?= $order->order_number ?></h1>
        <span class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;"><?= $order->status ?></span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Order Details</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Customer</span><strong><?= htmlspecialchars($order->customer_name) ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Email</span><strong><a href="mailto:<?= htmlspecialchars($order->customer_email) ?>"><?= htmlspecialchars($order->customer_email) ?></a></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Quote Ref</span><strong><a href="<?= BASE_URL ?>/admin/quoteDetail/<?= $order->quote_id ?>"><?= $order->quote_number ?></a></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Total Price</span><strong style="color: var(--success);">$<?= number_format($order->total_price, 2) ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Service</span><strong><?= $order->service_name ?? 'Custom' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Machine Format</span><strong><?= htmlspecialchars($order->machine_format) ?: 'N/A' ?></strong></div>
            </div>
            
            <?php if($order->additional_instructions): ?>
                <div style="margin-top: 1.5rem;">
                    <span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Instructions from Quote</span>
                    <p style="background: var(--primary-bg); padding: 1rem; border-radius: 4px; margin-top: 0.5rem; border: 1px solid var(--border-color);"><?= nl2br(htmlspecialchars($order->additional_instructions)) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Delivered Files</h3>
            <?php if(empty($files)): ?>
                <p style="color: var(--gray-text);">No files uploaded yet.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($files as $file): ?>
                        <li style="padding: 1rem; border: 1px solid var(--border-color); border-radius: 4px; margin-bottom: 0.5rem; background: var(--primary-bg); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 500;"><?= htmlspecialchars($file->file_name) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-text);">Type: <?= $file->file_type === 'final_design' ? 'Final Design File' : 'Preview Image' ?></div>
                            </div>
                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($file->file_path) ?>" target="_blank" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Download</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Update Status</h3>
            
            <form action="<?= BASE_URL ?>/admin/updateOrderStatus/<?= $order->id ?>" method="POST">
                <?= CSRF::getTokenField() ?>
                <div class="form-group">
                    <label class="form-label">Order Status</label>
                    <select name="status" class="form-control" required>
                        <?php 
                        $statuses = ['Awaiting Payment', 'Paid', 'In Digitizing', 'Quality Check', 'Revision Requested', 'Completed', 'Delivered', 'Cancelled'];
                        foreach($statuses as $status):
                        ?>
                            <option value="<?= $status ?>" <?= $order->status === $status ? 'selected' : '' ?>><?= $status ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Update Status</button>
            </form>
        </div>

        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--accent-blue); padding: 1.5rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; color: var(--accent-blue);">Upload Delivery File</h3>
            
            <form action="<?= BASE_URL ?>/admin/uploadOrderFile/<?= $order->id ?>" method="POST" enctype="multipart/form-data">
                <?= CSRF::getTokenField() ?>
                
                <div class="form-group">
                    <label class="form-label">File Type</label>
                    <select name="file_type" class="form-control" required>
                        <option value="final_design">Final Embroidery File (DST, PES, etc.)</option>
                        <option value="preview">Digital Preview / Production Sheet (PDF, JPG)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-outline" style="width: 100%; border-color: var(--accent-blue); color: var(--primary-text);">Upload File</button>
            </form>
        </div>
    </div>
</div>
