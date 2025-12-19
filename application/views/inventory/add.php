<div class="card">
    <h2>Add Inventory Item</h2>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post">
        <div class="form-group">
            <label>Item Name:</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Category:</label>
            <select name="category" required>
                <option value="Food">Food</option>
                <option value="Medicine">Medicine</option>
                <option value="Accessories">Accessories</option>
                <option value="Toys">Toys</option>
                <option value="Grooming">Grooming</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="0" required>
        </div>
        <div class="form-group">
            <label>Price (₱):</label>
            <input type="number" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier">
        </div>
        <button type="submit" class="btn">Save Item</button>
        <a href="<?= base_url('inventory') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>