<?php $layout = 'dashboard'; ?>
<div class="mb-4">
    <a href="<?= BASE_URL ?>/dashboard/orders" style="font-size: 0.9rem; color: var(--gray-text);">&larr; Back to Orders</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
        <h1 style="font-size: 1.8rem;">Order #<?= $order->order_number ?></h1>
        <div>
            <?php if($order->status === 'Delivered'): ?>
                <span class="badge badge-success" style="font-size: 1rem; padding: 0.5rem 1rem;">Delivered</span>
            <?php elseif($order->status === 'Cancelled'): ?>
                <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: var(--danger); font-size: 1rem; padding: 0.5rem 1rem;">Cancelled</span>
            <?php else: ?>
                <span class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;"><?= $order->status ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Progress Tracker -->
<?php
$steps = [
    'Awaiting Payment' => 1,
    'Paid' => 2,
    'In Digitizing' => 3,
    'Quality Check' => 4,
    'Completed' => 5,
    'Delivered' => 6
];
$currentStep = $steps[$order->status] ?? 0;
?>

<?php if($order->status !== 'Cancelled'): ?>
<div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 2rem; margin-bottom: 2rem;">
    <h3 style="font-size: 1.2rem; margin-bottom: 2rem;">Order Progress</h3>
    
    <div style="display: flex; justify-content: space-between; position: relative;">
        <!-- Connecting Line -->
        <div style="position: absolute; top: 15px; left: 0; width: 100%; height: 2px; background-color: var(--border-color); z-index: 1;"></div>
        <div style="position: absolute; top: 15px; left: 0; height: 2px; background-color: var(--accent-blue); z-index: 2; width: <?= ($currentStep > 0) ? (($currentStep - 1) / (count($steps) - 1)) * 100 : 0 ?>%; transition: width 0.5s ease;"></div>

        <?php $i = 1; foreach($steps as $name => $stepIndex): ?>
            <div style="position: relative; z-index: 3; text-align: center; width: 120px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background-color: <?= $stepIndex <= $currentStep ? 'var(--accent-blue)' : 'var(--primary-bg)' ?>; border: 2px solid <?= $stepIndex <= $currentStep ? 'var(--accent-blue)' : 'var(--border-color)' ?>; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem auto; color: white; font-size: 0.8rem;">
                    <?php if($stepIndex < $currentStep): ?>
                        &#10003;
                    <?php else: ?>
                        <?= $i ?>
                    <?php endif; ?>
                </div>
                <div style="font-size: 0.8rem; color: <?= $stepIndex <= $currentStep ? 'var(--primary-text)' : 'var(--gray-text)' ?>; font-weight: <?= $stepIndex == $currentStep ? '600' : '400' ?>;">
                    <?= $name ?>
                </div>
            </div>
        <?php $i++; endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Order Details</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Quote Ref</span><strong><a href="<?= BASE_URL ?>/dashboard/quoteDetail/<?= $order->quote_id ?>"><?= $order->quote_number ?></a></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Total Price</span><strong>$<?= number_format($order->total_price, 2) ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Service</span><strong><?= $order->service_name ?? 'Custom' ?></strong></div>
                <div><span style="color: var(--gray-text); font-size: 0.9rem; display: block;">Machine Format</span><strong><?= $order->machine_format ?: 'N/A' ?></strong></div>
            </div>
        </div>
    </div>

    <div>
        <div style="background: var(--secondary-bg); border-radius: 8px; border: 1px solid var(--border-color); padding: 1.5rem;">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Final Delivery Files</h3>
            
            <?php 
            $finalFiles = array_filter($files, fn($f) => $f->file_type === 'final_design');
            if(empty($finalFiles)): 
            ?>
                <div style="text-align: center; padding: 1rem 0;">
                    <svg style="color: var(--gray-text); width: 48px; height: 48px; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p style="color: var(--gray-text); font-size: 0.9rem;">Files will appear here once digitizing is complete.</p>
                </div>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach($finalFiles as $file): ?>
                        <li style="padding: 1rem; border: 1px solid var(--border-color); border-radius: 4px; margin-bottom: 0.5rem; background: var(--primary-bg);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-weight: 500; word-break: break-all;"><?= htmlspecialchars($file->file_name) ?></span>
                            </div>
                            <a href="<?= BASE_URL ?>/dashboard/downloadFile/<?= $file->id ?>" class="btn btn-primary" style="width: 100%; padding: 0.5rem; font-size: 0.9rem;">Download File</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
