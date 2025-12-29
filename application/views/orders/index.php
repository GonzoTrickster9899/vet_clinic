<div class="card">
    <h2>📦 Orders Management</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Buyer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): 
                $status_colors = [
                    'pending' => '#f39c12',
                    'processing' => '#3498db',
                    'completed' => '#27ae60',
                    'cancelled' => '#e74c3c'
                ];
                $status_color = $status_colors[$order['status']] ?? '#7f8c8d';
            ?>
            <tr>
                <td><strong>#<?= $order['id'] ?></strong></td>
                <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                <td><?= $order['buyer_name'] ?></td>
                <td><?= count($order['items']) ?> items</td>
                <td><strong>₱<?= number_format($order['total'], 2) ?></strong></td>
                <td><?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></td>
                <td>
                    <span style="background: <?= $status_color ?>; color: #fff; padding: 5px 12px; border-radius: 12px; font-size: 12px;">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('orders/view/' . $order['id']) ?>" class="btn">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>