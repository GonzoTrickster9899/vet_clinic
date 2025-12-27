<div class="card">
    <h2>Edit Inventory Item</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Current Photo:</label>
            <?php 
            $image_url = isset($item['image']) && !empty($item['image']) 
                ? base_url('assets/images/inventory/' . $item['image']) 
                : base_url('assets/images/inventory/default-item.png');
            ?>
            <div style="margin: 10px 0;">
                <img src="<?= $image_url ?>" alt="<?= $item['name'] ?>" 
                     id="currentImage"
                     style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd;"
                     onerror="this.src='<?= base_url('assets/images/inventory/default-item.png') ?>'">
            </div>
            
            <?php if (isset($item['image']) && !empty($item['image'])): ?>
                <a href="<?= base_url('inventory/delete_image/' . $item['id']) ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Delete this photo?')"
                   style="margin: 10px 0; display: inline-block;">
                    Delete Current Photo
                </a>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>Upload New Photo:</label>
            <input type="file" name="item_image" accept="image/*" onchange="previewImage(event)">
            <small style="color: #666; display: block; margin-top: 5px;">
                Leave empty to keep current photo
            </small>
            <div id="imagePreview" style="margin-top: 15px;"></div>
        </div>
        
        <div class="form-group">
            <label>Item Name:</label>
            <input type="text" name="name" value="<?= $item['name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label>Category:</label>
            <select name="category" required>
                <option value="Food" <?= $item['category'] == 'Food' ? 'selected' : '' ?>>🍖 Food</option>
                <option value="Medicine" <?= $item['category'] == 'Medicine' ? 'selected' : '' ?>>💊 Medicine</option>
                <option value="Accessories" <?= $item['category'] == 'Accessories' ? 'selected' : '' ?>>🎀 Accessories</option>
                <option value="Toys" <?= $item['category'] == 'Toys' ? 'selected' : '' ?>>🎾 Toys</option>
                <option value="Grooming" <?= $item['category'] == 'Grooming' ? 'selected' : '' ?>>✂️ Grooming</option>
                <option value="Supplies" <?= $item['category'] == 'Supplies' ? 'selected' : '' ?>>📦 Supplies</option>
                <option value="Equipment" <?= $item['category'] == 'Equipment' ? 'selected' : '' ?>>🔧 Equipment</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="3"><?= $item['description'] ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" required min="0">
        </div>
        
        <div class="form-group">
            <label>Price (₱):</label>
            <input type="number" name="price" value="<?= $item['price'] ?>" step="0.01" required min="0">
        </div>
        
        <div class="form-group">
            <label>Supplier:</label>
            <input type="text" name="supplier" value="<?= $item['supplier'] ?>">
        </div>
        
        <button type="submit" class="btn">Update Item</button>
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
            preview.innerHTML = '<strong>New Photo Preview:</strong><br><img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd; margin-top: 10px;">';
        }
        reader.readAsDataURL(file);
    }
}
</script>