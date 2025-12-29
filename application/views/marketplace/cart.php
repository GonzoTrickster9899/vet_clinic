<div class="card">
    <h2>🛒 Shopping Cart</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <?php if ($this->cart->total_items() > 0): ?>
        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->cart->contents() as $item): 
                    $image_url = !empty($item['options']['image']) 
                        ? base_url('assets/images/inventory/' . $item['options']['image']) 
                        : base_url('assets/images/inventory/default-item.png');
                ?>
                <tr>
                    <td>
                        <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                             onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
                    </td>
                    <td>
                        <strong><?= $item['name'] ?></strong><br>
                        <small style="color: #7f8c8d;"><?= $item['options']['category'] ?></small>
                    </td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td>
                        <form method="post" action="<?= base_url('marketplace/update_cart') ?>" style="display: inline;">
                            <input type="hidden" name="rowid" value="<?= $item['rowid'] ?>">
                            <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1" style="width: 80px; padding: 5px;">
                            <button type="submit" class="btn" style="padding: 5px 10px;">Update</button>
                        </form>
                    </td>
                    <td><strong>₱<?= number_format($item['subtotal'], 2) ?></strong></td>
                    <td>
                        <a href="<?= base_url('marketplace/remove_item/' . $item['rowid']) ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Remove this item?')">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f8f9fa;">
                    <td colspan="4" style="text-align: right; font-weight: bold; font-size: 18px;">Total:</td>
                    <td colspan="2" style="font-weight: bold; font-size: 24px; color: #27ae60;">₱<?= number_format($this->cart->total(), 2) ?></td>
                </tr>
            </tfoot>
        </table>
        
        <div style="display: flex; justify-content: space-between; margin-top: 30px;">
            <div>
                <a href="<?= base_url('marketplace') ?>" class="btn">← Continue Shopping</a>
                <a href="<?= base_url('marketplace/clear_cart') ?>" class="btn btn-danger" onclick="return confirm('Clear entire cart?')">Clear Cart</a>
            </div>
            <a href="<?= base_url('marketplace/checkout') ?>" class="btn btn-success" style="font-size: 18px; padding: 15px 30px;">
                Proceed to Checkout →
            </a>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h3>Your cart is empty</h3>
            <p style="color: #7f8c8d; margin: 20px 0;">Start shopping to add items to your cart!</p>
            <a href="<?= base_url('marketplace') ?>" class="btn btn-success">Browse Products</a>
        </div>
    <?php endif; ?>
</div>