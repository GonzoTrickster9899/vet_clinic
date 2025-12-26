<div class="card">
    <h2><?= $title ?></h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('inventory/add') ?>" class="btn">Add Item</a>
        <a href="<?= base_url('inventory/print_qrcodes') ?>" class="btn btn-success" target="_blank">Print All QR Codes</a>
        <a href="<?= base_url('inventory/scan') ?>" class="btn" style="background: #9b59b6;">Scan QR Code</a>
    </div>
    
    <table>
        <tr>
            <th>Image</th>
            <th>SKU</th>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($items as $item): 
            $sku = isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'];
            $image_url = isset($item['image']) && !empty($item['image']) 
                ? base_url('assets/images/inventory/' . $item['image']) 
                : base_url('assets/images/inventory/default-item.png');
        ?>
        <tr>
            <td>
                <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;"
                     onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
            </td>
            <td><code style="font-size: 11px;"><?= $sku ?></code></td>
            <td><strong><?= $item['name'] ?></strong></td>
            <td><?= $item['category'] ?></td>
            <td>
                <span style="background: <?= $item['quantity'] < 10 ? '#e74c3c' : '#27ae60' ?>; color: #fff; padding: 3px 8px; border-radius: 12px; font-size: 12px;">
                    <?= $item['quantity'] ?>
                </span>
            </td>
            <td>₱<?= number_format($item['price'], 2) ?></td>
            <td><?= $item['supplier'] ?></td>
            <td>
                <a href="<?= base_url('inventory/view/' . $item['id']) ?>" class="btn btn-success">View</a>
                <a href="<?= base_url('inventory/edit/' . $item['id']) ?>" class="btn">Edit</a>
                <a href="<?= base_url('inventory/delete/' . $item['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this item and its image?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>