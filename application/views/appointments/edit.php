<div class="card">
    <h2>Edit Appointment</h2>
    
    <form method="post">
        <div class="form-group">
            <label>Pet:</label>
            <select name="pet_id" required>
                <?php foreach ($pets as $pet): 
                    $owner = null;
                    foreach ($customers as $c) {
                        if ($c['id'] == $pet['customer_id']) {
                            $owner = $c['name'];
                            break;
                        }
                    }
                ?>
                <option value="<?= $pet['id'] ?>" <?= $appointment['pet_id'] == $pet['id'] ? 'selected' : '' ?>>
                    <?= $pet['name'] ?> (<?= $owner ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date:</label>
            <input type="date" name="date" value="<?= $appointment['date'] ?>" required>
        </div>
        <div class="form-group">
            <label>Time:</label>
            <input type="time" name="time" value="<?= $appointment['time'] ?>" required>
        </div>
        <div class="form-group">
            <label>Reason:</label>
            <textarea name="reason" rows="3" required><?= $appointment['reason'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="scheduled" <?= $appointment['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <div class="form-group">
            <label>Notes:</label>
            <textarea name="notes" rows="4"><?= isset($appointment['notes']) ? $appointment['notes'] : '' ?></textarea>
        </div>
        <button type="submit" class="btn">Update Appointment</button>
        <a href="<?= base_url('appointments') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>