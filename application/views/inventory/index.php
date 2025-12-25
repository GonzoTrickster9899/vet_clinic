<div class="card">
    <h2><?= $title ?></h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('inventory/add') ?>" class="btn">Add Item</a>
        <a href="<?= base_url('inventory/print_qrcodes') ?>" class="btn btn-success" target="_blank">Print All QR Codes</a>
        <a href="<?= base_url('inventory/scan') ?>" class="btn" style="background: #9b59b6;">Scan QR Code</a>
    </div>
    
    <table>
        <tr>
            <th>QR Code</th>
            <th>SKU</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($items as $item): 
            $sku = isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'];
            $qr_data = json_encode([
                'sku' => $sku,
                'name' => $item['name'],
                'id' => $item['id']
            ]);
            $qr_url = "https://quickchart.io/chart?chs=80x80&cht=qr&chl=" . urlencode($qr_data);
        ?>
        <tr>
            <td>
                <img src="<?= $qr_url ?>" alt="QR Code" style="width: 60px; height: 60px;">
            </td>
            <td><code><?= $sku ?></code></td>
            <td><?= $item['id'] ?></td>
            <td><strong><?= $item['name'] ?></strong></td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>₱<?= number_format($item['price'], 2) ?></td>
            <td>
                <a href="<?= base_url('inventory/view/' . $item['id']) ?>" class="btn btn-success">View</a>
                <a href="<?= base_url('inventory/edit/' . $item['id']) ?>" class="btn">Edit</a>
                <a href="<?= base_url('inventory/qrcode/' . $item['id']) ?>" class="btn" target="_blank" style="background: #9b59b6;">Print QR</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>