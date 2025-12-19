<div class="card">
    <h2>New Appointment</h2>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
    
    <form method="post">
        <div class="form-group">
            <label>Pet:</label>
            <select name="pet_id" required>
                <option value="">Select Pet</option>
                <?php foreach ($pets as $pet): 
                    $owner = null;
                    foreach ($customers as $c) {
                        if ($c['id'] == $pet['customer_id']) {
                            $owner = $c['name'];
                            break;
                        }
                    }
                ?>
                <option value="<?= $pet['id'] ?>"><?= $pet['name'] ?> (<?= $owner ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date:</label>
            <input type="date" name="date" required>
        </div>
        <div class="form-group">
            <label>Time:</label>
            <input type="time" name="time" required>
        </div>
        <div class="form-group">
            <label>Reason:</label>
            <textarea name="reason" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn">Schedule Appointment</button>
        <a href="<?= base_url('appointments') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>