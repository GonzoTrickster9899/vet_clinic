<?php
$image_url = isset($item['image']) && !empty($item['image']) 
    ? base_url('assets/images/inventory/' . $item['image']) 
    : base_url('assets/images/inventory/default-item.png');
?>
<div class="card">
    <a href="<?= base_url('marketplace') ?>" class="btn">← Back to Shop</a>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px;">
        <div>
            <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
                 style="width: 100%; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
                 onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
        </div>
        
        <div>
            <h2 style="color: #2c3e50; margin-bottom: 15px;"><?= $item['name'] ?></h2>
            <p style="color: #7f8c8d; margin-bottom: 20px;"><?= $item['category'] ?></p>
            
            <div style="font-size: 36px; color: #27ae60; font-weight: bold; margin: 20px 0;">
                ₱<?= number_format($item['price'], 2) ?>
            </div>
            
            <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <?php if ($item['quantity'] > 10): ?>
                    <span style="color: #27ae60; font-weight: bold;">✓ In Stock</span>
                    <p style="color: #7f8c8d; margin-top: 5px;"><?= $item['quantity'] ?> units available</p>
                <?php elseif ($item['quantity'] > 0): ?>
                    <span style="color: #f39c12; font-weight: bold;">⚠ Low Stock</span>
                    <p style="color: #7f8c8d; margin-top: 5px;">Only <?= $item['quantity'] ?> units left!</p>
                <?php else: ?>
                    <span style="color: #e74c3c; font-weight: bold;">✗ Out of Stock</span>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($item['description'])): ?>
                <div style="margin: 20px 0;">
                    <h4 style="color: #2c3e50; margin-bottom: 10px;">Description</h4>
                    <p style="color: #555; line-height: 1.6;"><?= nl2br($item['description']) ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($item['quantity'] > 0): ?>
                <form method="post" action="<?= base_url('marketplace/add_to_cart') ?>">
                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                    <div class="form-group">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?= $item['quantity'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%; font-size: 18px; padding: 15px;">
                        🛒 Add to Cart
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-danger" style="width: 100%; font-size: 18px; padding: 15px;" disabled>
                    Out of Stock
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>