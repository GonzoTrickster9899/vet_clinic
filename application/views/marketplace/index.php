<h2>🛍️ Shop Our Products</h2>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="product-grid">
    <?php foreach ($items as $item): 
        $image_url = isset($item['image']) && !empty($item['image']) 
            ? base_url('assets/images/inventory/' . $item['image']) 
            : base_url('assets/images/inventory/default-item.png');
    ?>
    <div class="product-card">
        <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
             onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
        <div class="content">
            <h3><?= $item['name'] ?></h3>
            <p style="color: #7f8c8d; font-size: 14px;"><?= $item['category'] ?></p>
            <div class="price">₱<?= number_format($item['price'], 2) ?></div>
            <div class="stock">
                <?php if ($item['quantity'] > 10): ?>
                    <span style="color: #27ae60;">✓ In Stock (<?= $item['quantity'] ?> available)</span>
                <?php elseif ($item['quantity'] > 0): ?>
                    <span style="color: #f39c12;">⚠ Low Stock (<?= $item['quantity'] ?> left)</span>
                <?php else: ?>
                    <span style="color: #e74c3c;">✗ Out of Stock</span>
                <?php endif; ?>
            </div>
            <a href="<?= base_url('marketplace/product/' . $item['id']) ?>" class="btn" style="width: 100%; text-align: center; margin-top: 10px;">
                View Details
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($items)): ?>
    <div class="card" style="text-align: center; padding: 50px;">
        <h3>No products available at the moment</h3>
        <p style="color: #7f8c8d; margin-top: 10px;">Please check back later!</p>
    </div>
<?php endif; ?>