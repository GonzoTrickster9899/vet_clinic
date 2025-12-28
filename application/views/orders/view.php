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
    <a href="<?= base_url('orders') ?>" class="btn">← Back to Orders</a>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success" style="margin-top: 20px;"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
        <div>
            <h3 style="color: #2c3e50; margin-bottom: 15px;">Order Information</h3>
            <table style="width: 100%;">
                <tr>
                    <td style="font-weight: bold; padding: 10px 0; width: 200px;">Order ID:</td>
                    <td>#<?= $order['id'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Order Date:</td>
                    <td><?= date('F j, Y g:i A', strtotime($order['order_date'])) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Buyer Name:</td>
                    <td><strong><?= $order['buyer_name'] ?></strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Buyer Email:</td>
                    <td><?= $order['buyer_email'] ?></td>
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
            
            <h3 style="color: #2c3e50; margin: 30px 0 15px 0;">Update Order Status</h3>
            <form method="post" action="<?= base_url('orders/update_status/' . $order['id']) ?>">
                <div class="form-group">
                    <label>Current Status: 
                        <span style="background: <?= $status_color ?>; color: #fff; padding: 5px 15px; border-radius: 12px; font-weight: bold; margin-left: 10px;">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </label>
                    <select name="status" style="margin-top: 10px;">
                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Status</button>
            </form>
            
            <h3 style="color: #2c3e50; margin: 30px 0 15px 0;">Delivery Information</h3>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <p><strong>Contact Number:</strong> <?= $order['contact_number'] ?></p>
                <p style="margin-top: 10px;"><strong>Delivery Address:</strong><br><?= nl2br($order['delivery_address']) ?></p>
                <?php if (!empty($order['notes'])): ?>
                    <p style="margin-top: 10px;"><strong>Customer Notes:</strong><br><?= nl2br($order['notes']) ?></p>
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
            
            <div style="background: #2c3e50; color: #fff; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 18px;">
                    <strong>Order Total:</strong>
                    <strong>₱<?= number_format($order['total'], 2) ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>