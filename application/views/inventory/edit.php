<div class="card">
    <h2>Edit Inventory Item</h2>
    
    <form method="post">
        <div class="form-group">
            <label>Item Name:</label>
            <input type="text" name="name" value="<?= $item['name'] ?>" required>
        </div>
        <div class="form-group">
            <label>Category:</label>
            <select name="category" required>
                <option value="Food" <?= $item['category'] == 'Food' ? 'selected' : '' ?>>Food</option>
                <option value="Medicine" <?= $item['category'] == 'Medicine' ? 'selected' : '' ?>>Medicine</option>
                <option value="Accessories" <?= $item['category'] == 'Accessories' ? 'selected' : '' ?>>Accessories</option>
                <option value="Toys" <?= $item['category'] == 'Toys' ? 'selected' : '' ?>>Toys</option>
                <option value="Grooming" <?= $item['category'] == 'Grooming' ? 'selected' : '' ?>>Grooming</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="3"><?= $item['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" required>
        </div>
        <div class="form-group">
            <label>Price (₱):</label>
            <input type="number" name="price" value="<?= $item['price'] ?>" step="0.01" required>
        </div>
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier" value="<?= $item['supplier'] ?>">
        </div>
        <button type="submit" class="btn">Update Item</button>
        <a href="<?= base_url('inventory') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>