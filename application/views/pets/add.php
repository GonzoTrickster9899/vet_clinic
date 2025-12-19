<div class="card">
    <h2>Add Pet</h2>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post">
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
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Species:</label>
            <select name="species" required>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <option value="Bird">Bird</option>
                <option value="Rabbit">Rabbit</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Breed:</label>
            <input type="text" name="breed">
        </div>
        <div class="form-group">
            <label>Age (years):</label>
            <input type="number" name="age" step="0.1">
        </div>
        <div class="form-group">
            <label>Weight (kg):</label>
            <input type="number" name="weight" step="0.1">
        </div>
        <div class="form-group">
            <label>Medical History:</label>
            <textarea name="medical_history" rows="4"></textarea>
        </div>
        <button type="submit" class="btn">Save Pet</button>
        <a href="<?= base_url('pets') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>