<div class="card">
    <h2>📦 My Orders</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if (!empty($orders)): ?>
        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
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
                    <td><?= date('M j, Y g:i A', strtotime($order['order_date'])) ?></td>
                    <td><?= count($order['items']) ?> items</td>
                    <td><strong>₱<?= number_format($order['total'], 2) ?></strong></td>
                    <td><?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></td>
                    <td>
                        <span style="background: <?= $status_color ?>; color: #fff; padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url('buyer/order_detail/' . $order['id']) ?>" class="btn">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h3>No orders yet</h3>
            <p style="color: #7f8c8d; margin: 20px 0;">Start shopping to place your first order!</p>
            <a href="<?= base_url('marketplace') ?>" class="btn btn-success">Browse Products</a>
        </div>
    <?php endif; ?>
</div>