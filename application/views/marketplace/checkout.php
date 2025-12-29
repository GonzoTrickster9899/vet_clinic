<div class="card">
    <h2>💳 Checkout</h2>
    
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px; margin-top: 30px;">
        <div>
            <h3 style="margin-bottom: 20px; color: #2c3e50;">Delivery Information</h3>
            
            <form method="post" action="<?= base_url('marketplace/place_order') ?>">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" value="<?= $this->session->userdata('full_name') ?>" disabled style="background: #f8f9fa;">
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" value="<?= $this->session->userdata('email') ?>" disabled style="background: #f8f9fa;">
                </div>
                
                <div class="form-group">
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" required placeholder="Enter contact number">
                </div>
                
                <div class="form-group">
                    <label>Delivery Address:</label>
                    <textarea name="delivery_address" rows="3" required placeholder="Enter complete delivery address"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Payment Method:</label>
                    <select name="payment_method" required>
                        <option value="cash">Cash on Delivery</option>
                        <option value="gcash">GCash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Order Notes (Optional):</label>
                    <textarea name="notes" rows="3" placeholder="Any special instructions?"></textarea>
                </div>
                
                <button type="submit" class="btn btn-success" style="width: 100%; font-size: 18px; padding: 15px; margin-top: 20px;">
                    Place Order
                </button>
            </form>
        </div>
        
        <div>
            <div class="card" style="background: #f8f9fa;">
                <h3 style="margin-bottom: 20px; color: #2c3e50;">Order Summary</h3>
                
                <?php foreach ($this->cart->contents() as $item): ?>
                    <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ddd;">
                        <div>
                            <strong><?= $item['name'] ?></strong><br>
                            <small>Qty: <?= $item['qty'] ?> × ₱<?= number_format($item['price'], 2) ?></small>
                        </div>
                        <div style="font-weight: bold;">
                            ₱<?= number_format($item['subtotal'], 2) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #ddd;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Subtotal:</span>
                        <strong>₱<?= number_format($this->cart->total(), 2) ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Delivery Fee:</span>
                        <strong>FREE</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 20px; padding-top: 15px; border-top: 2px solid #27ae60;">
                        <strong>Total:</strong>
                        <strong style="color: #27ae60;">₱<?= number_format($this->cart->total(), 2) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>