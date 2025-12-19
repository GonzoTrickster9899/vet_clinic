<div class="card">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('inventory/add') ?>" class="btn" style="margin-bottom: 20px;">Add Item</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['name'] ?></td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₱<?= number_format($item['price'], 2) ?></td>
            <td><?= $item['supplier'] ?></td>
            <td>
                <a href="<?= base_url('inventory/edit/' . $item['id']) ?>" class="btn">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>