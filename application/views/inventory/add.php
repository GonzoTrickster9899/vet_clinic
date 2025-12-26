<div class="card">
    <h2>Add Inventory Item</h2>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Item Photo:</label>
            <input type="file" name="item_image" accept="image/*" onchange="previewImage(event)">
            <small style="color: #666; display: block; margin-top: 5px;">
                Accepted formats: JPG, JPEG, PNG, GIF (Max 2MB)
            </small>
            <div id="imagePreview" style="margin-top: 15px;"></div>
        </div>
        
        <div class="form-group">
            <label>Item Name:</label>
            <input type="text" name="name" value="<?= set_value('name') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Category:</label>
            <select name="category" required>
                <option value="Food">🍖 Food</option>
                <option value="Medicine">💊 Medicine</option>
                <option value="Accessories">🎀 Accessories</option>
                <option value="Toys">🎾 Toys</option>
                <option value="Grooming">✂️ Grooming</option>
                <option value="Supplies">📦 Supplies</option>
                <option value="Equipment">🔧 Equipment</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="3"><?= set_value('description') ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?= set_value('quantity', 0) ?>" required min="0">
        </div>
        
        <div class="form-group">
            <label>Price (₱):</label>
            <input type="number" name="price" value="<?= set_value('price') ?>" step="0.01" required min="0">
        </div>
        
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier" value="<?= set_value('supplier') ?>">
        </div>
        
        <button type="submit" class="btn">Save Item</button>
        <a href="<?= base_url('inventory') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd;">';
        }
        reader.readAsDataURL(file);
    }
}
</script>