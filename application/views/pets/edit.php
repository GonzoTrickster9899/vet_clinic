<div class="card">
    <h2>Edit Pet</h2>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post">
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
                <option value="Dog" <?= $pet['species'] == 'Dog' ? 'selected' : '' ?>>Dog</option>
                <option value="Cat" <?= $pet['species'] == 'Cat' ? 'selected' : '' ?>>Cat</option>
                <option value="Bird" <?= $pet['species'] == 'Bird' ? 'selected' : '' ?>>Bird</option>
                <option value="Rabbit" <?= $pet['species'] == 'Rabbit' ? 'selected' : '' ?>>Rabbit</option>
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