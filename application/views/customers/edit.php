<div class="card">
    <h2>Edit Customer</h2>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= set_value('name', $customer['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= set_value('email', $customer['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?= set_value('phone', $customer['phone']) ?>" required>
        </div>
        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" rows="3"><?= set_value('address', $customer['address']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Customer</button>
        <a href="<?= base_url('customers') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>