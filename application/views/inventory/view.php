<div class="card">
    <h2>📦 Item Details</h2>
    <a href="<?= base_url('inventory') ?>" class="btn" style="margin-bottom: 20px;">← Back to Inventory</a>
    <a href="<?= base_url('inventory/edit/' . $item['id']) ?>" class="btn" style="margin-bottom: 20px;">Edit Item</a>
    <a href="<?= base_url('inventory/qrcode/' . $item['id']) ?>" class="btn" target="_blank" style="background: #9b59b6; margin-bottom: 20px;">Print QR Code</a>
    
    <div style="display: grid; grid-template-columns: 400px 1fr; gap: 30px; margin-top: 20px;">
        <div>
            <!-- Product Image -->
            <?php 
            $image_url = isset($item['image']) && !empty($item['image']) 
                ? base_url('assets/images/inventory/' . $item['image']) 
                : base_url('assets/images/inventory/default-item.png');
            ?>
            <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
                 style="width: 100%; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 20px;"
                 onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
            
            <!-- QR Code -->
            <div style="text-align: center; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <h4 style="margin-bottom: 15px; color: #2c3e50;">QR Code</h4>
                <img src="<?= $qr_code_url ?>" alt="QR Code" style="width: 200px; height: 200px; border: 2px solid #ddd; padding: 10px; border-radius: 8px; background: #fff;">
                <p style="margin-top: 10px; color: #666; font-size: 12px;">
                    <strong>SKU:</strong><br>
                    <code style="background: #fff; padding: 5px 10px; border-radius: 4px; display: inline-block; margin-top: 5px;">
                        <?= isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'] ?>
                    </code>
                </p>
            </div>
        </div>
        
        <div>
            <h3 style="margin-bottom: 20px; color: #2c3e50;"><?= $item['name'] ?></h3>
            
            <table style="width: 100%;">
                <tr>
                    <td style="font-weight: bold; padding: 10px 0; width: 200px;">ID:</td>
                    <td><?= $item['id'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">SKU:</td>
                    <td><code style="background: #f4f4f4; padding: 5px 10px; border-radius: 4px;"><?= isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'] ?></code></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Category:</td>
                    <td><?= $item['category'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Price:</td>
                    <td style="font-size: 32px; color: #27ae60; font-weight: bold;">₱<?= number_format($item['price'], 2) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Quantity:</td>
                    <td>
                        <span style="background: <?= $item['quantity'] < 10 ? '#e74c3c' : '#27ae60' ?>; color: #fff; padding: 8px 20px; border-radius: 20px; font-weight: bold; font-size: 18px;">
                            <?= $item['quantity'] ?> units
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Supplier:</td>
                    <td><?= $item['supplier'] ?: 'N/A' ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Added:</td>
                    <td><?= date('F j, Y g:i A', strtotime($item['created_at'])) ?></td>
                </tr>
            </table>
            
            <?php if (!empty($item['description'])): ?>
            <div style="margin-top: 30px;">
                <h4 style="color: #2c3e50; margin-bottom: 10px;">📝 Description</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #3498db;">
                    <?= nl2br($item['description']) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>