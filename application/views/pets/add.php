<div class="card">
    <h2>Add Pet</h2>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Pet Photo:</label>
            <input type="file" name="pet_image" accept="image/*" onchange="previewImage(event)">
            <small style="color: #666; display: block; margin-top: 5px;">
                Accepted formats: JPG, JPEG, PNG, GIF (Max 2MB)
            </small>
            <div id="imagePreview" style="margin-top: 15px;"></div>
        </div>
        
        <div class="form-group">
            <label>Owner:</label>
            <select name="customer_id" required>
                <option value="">Select Owner</option>
                <?php foreach ($customers as $customer): ?>
                <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Pet Name:</label>
            <input type="text" name="name" value="<?= set_value('name') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Species:</label>
            <select name="species" required>
                <option value="Dog">🐕 Dog</option>
                <option value="Cat">🐈 Cat</option>
                <option value="Bird">🐦 Bird</option>
                <option value="Rabbit">🐰 Rabbit</option>
                <option value="Hamster">🐹 Hamster</option>
                <option value="Guinea Pig">Guinea Pig</option>
                <option value="Fish">🐠 Fish</option>
                <option value="Reptile">🦎 Reptile</option>
                <option value="Other">Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Breed:</label>
            <input type="text" name="breed" value="<?= set_value('breed') ?>">
        </div>
        
        <div class="form-group">
            <label>Age (years):</label>
            <input type="number" name="age" value="<?= set_value('age') ?>" step="0.1">
        </div>
        
        <div class="form-group">
            <label>Weight (kg):</label>
            <input type="number" name="weight" value="<?= set_value('weight') ?>" step="0.1">
        </div>
        
        <div class="form-group">
            <label>Medical History:</label>
            <textarea name="medical_history" rows="4"><?= set_value('medical_history') ?></textarea>
        </div>
        
        <button type="submit" class="btn">Save Pet</button>
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
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd;">';
        }
        reader.readAsDataURL(file);
    }
}
</script>