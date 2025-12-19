<h2><?= $title ?></h2>

<div class="stats">
    <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h3><?= $customers_count ?></h3>
        <p>Total Customers</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <h3><?= $pets_count ?></h3>
        <p>Registered Pets</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <h3><?= $appointments_today ?></h3>
        <p>Today's Appointments</p>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <h3><?= count($low_stock_items) ?></h3>
        <p>Low Stock Items</p>
    </div>
</div>

<?php if (count($low_stock_items) > 0): ?>
<div class="card">
    <h3>⚠️ Low Stock Alert</h3>
    <table>
        <tr>
            <th>Item</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php foreach ($low_stock_items as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><a href="<?= base_url('inventory/edit/' . $item['id']) ?>" class="btn btn-success">Restock</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>