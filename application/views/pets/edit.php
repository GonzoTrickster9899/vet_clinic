<div class="card">
    <h2>Edit Pet</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Current Photo:</label>
            <?php 
            $image_url = isset($pet['image']) && !empty($pet['image']) 
                ? base_url('assets/images/pets/' . $pet['image']) 
                : base_url('assets/images/pets/default-pet.png');
            ?>
            <div style="margin: 10px 0;">
                <img src="<?= $image_url ?>" alt="<?= $pet['name'] ?>" 
                     id="currentImage"
                     style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd;"
                     onerror="this.src='<?= base_url('assets/images/pets/default-pet.png') ?>'">
            </div>
            
            <?php if (isset($pet['image']) && !empty($pet['image'])): ?>
                <a href="<?= base_url('pets/delete_image/' . $pet['id']) ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Delete this photo?')"
                   style="margin: 10px 0; display: inline-block;">
                    Delete Current Photo
                </a>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>Upload New Photo:</label>
            <input type="file" name="pet_image" accept="image/*" onchange="previewImage(event)">
            <small style="color: #666; display: block; margin-top: 5px;">
                Leave empty to keep current photo. Accepted: JPG, JPEG, PNG, GIF (Max 2MB)
            </small>
            <div id="imagePreview" style="margin-top: 15px;"></div>
        </div>
        
        <div class="form-group">
            <label>Owner:</label>
            <select name="customer_id" required>
                <?php foreach ($customers as $customer): ?>
                <option value="<?= $customer['id'] ?>" <?= $pet['customer_id'] == $customer['id'] ? 'selected' : '' ?>>
                    <?= $customer['name'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Pet Name:</label>
            <input type="text" name="name" value="<?= $pet['name'] ?>" required>
        </div>
        
        <div class="form-group">
            <label>Species:</label>
            <select name="species" required>
                <option value="Dog" <?= $pet['species'] == 'Dog' ? 'selected' : '' ?>>🐕 Dog</option>
                <option value="Cat" <?= $pet['species'] == 'Cat' ? 'selected' : '' ?>>🐈 Cat</option>
                <option value="Bird" <?= $pet['species'] == 'Bird' ? 'selected' : '' ?>>🐦 Bird</option>
                <option value="Rabbit" <?= $pet['species'] == 'Rabbit' ? 'selected' : '' ?>>🐰 Rabbit</option>
                <option value="Hamster" <?= $pet['species'] == 'Hamster' ? 'selected' : '' ?>>🐹 Hamster</option>
                <option value="Guinea Pig" <?= $pet['species'] == 'Guinea Pig' ? 'selected' : '' ?>>Guinea Pig</option>
                <option value="Fish" <?= $pet['species'] == 'Fish' ? 'selected' : '' ?>>🐠 Fish</option>
                <option value="Reptile" <?= $pet['species'] == 'Reptile' ? 'selected' : '' ?>>🦎 Reptile</option>
                <option value="Other" <?= $pet['species'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Breed:</label>
            <input type="text" name="breed" value="<?= $pet['breed'] ?>">
        </div>
        
        <div class="form-group">
            <label>Age (years):</label>
            <input type="number" name="age" value="<?= $pet['age'] ?>" step="0.1">
        </div>
        
        <div class="form-group">
            <label>Weight (kg):</label>
            <input type="number" name="weight" value="<?= $pet['weight'] ?>" step="0.1">
        </div>
        
        <div class="form-group">
            <label>Medical History:</label>
            <textarea name="medical_history" rows="4"><?= $pet['medical_history'] ?></textarea>
        </div>
        
        <button type="submit" class="btn">Update Pet</button>
        <a href="<?= base_url('pets') ?>" class="btn btn-danger">Cancel</a>
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