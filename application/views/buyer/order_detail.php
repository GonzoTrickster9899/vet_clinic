<?php
$status_colors = [
    'pending' => '#f39c12',
    'processing' => '#3498db',
    'completed' => '#27ae60',
    'cancelled' => '#e74c3c'
];
$status_color = $status_colors[$order['status']] ?? '#7f8c8d';
?>
<div class="card">
    <h2>📦 Order Details - #<?= $order['id'] ?></h2>
    <a href="<?= base_url('buyer/orders') ?>" class="btn">← Back to Orders</a>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
        <div>
            <h3 style="color: #2c3e50; margin-bottom: 15px;">Order Information</h3>
            <table style="width: 100%;">
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Order ID:</td>
                    <td>#<?= $order['id'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Order Date:</td>
                    <td><?= date('F j, Y g:i A', strtotime($order['order_date'])) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Status:</td>
                    <td>
                        <span style="background: <?= $status_color ?>; color: #fff; padding: 5px 15px; border-radius: 12px; font-weight: bold;">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Payment Method:</td>
                    <td><?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Total Amount:</td>
                    <td style="font-size: 24px; color: #27ae60; font-weight: bold;">₱<?= number_format($order['total'], 2) ?></td>
                </tr>
            </table>
            
            <h3 style="color: #2c3e50; margin: 30px 0 15px 0;">Delivery Information</h3>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <p><strong>Address:</strong><br><?= nl2br($order['delivery_address']) ?></p>
                <p style="margin-top: 10px;"><strong>Contact:</strong> <?= $order['contact_number'] ?></p>
                <?php if (!empty($order['notes'])): ?>
                    <p style="margin-top: 10px;"><strong>Notes:</strong> <?= $order['notes'] ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div>
            <h3 style="color: #2c3e50; margin-bottom: 15px;">Order Items</h3>
            <?php foreach ($order['items'] as $item): ?>
                <div style="display: flex; justify-content: space-between; padding: 15px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px;">
                    <div>
                        <strong><?= $item['name'] ?></strong><br>
                        <small>Qty: <?= $item['qty'] ?> × ₱<?= number_format($item['price'], 2) ?></small><br>
                        <small style="color: #7f8c8d;">SKU: <?= $item['sku'] ?></small>
                    </div>
                    <div style="font-weight: bold; color: #27ae60;">
                        ₱<?= number_format($item['subtotal'], 2) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>