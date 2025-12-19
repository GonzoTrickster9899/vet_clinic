<div class="card">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('appointments/add') ?>" class="btn" style="margin-bottom: 20px;">New Appointment</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Pet</th>
            <th>Owner</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($appointments as $apt): 
            $pet = null;
            $owner = null;
            foreach ($pets as $p) {
                if ($p['id'] == $apt['pet_id']) {
                    $pet = $p;
                    foreach ($customers as $c) {
                        if ($c['id'] == $p['customer_id']) {
                            $owner = $c['name'];
                            break;
                        }
                    }
                    break;
                }
            }
        ?>
        <tr>
            <td><?= $apt['id'] ?></td>
            <td><?= $pet ? $pet['name'] : 'N/A' ?></td>
            <td><?= $owner ?></td>
            <td><?= $apt['date'] ?></td>
            <td><?= $apt['time'] ?></td>
            <td><?= $apt['reason'] ?></td>
            <td><?= ucfirst($apt['status']) ?></td>
            <td>
                <a href="<?= base_url('appointments/edit/' . $apt['id']) ?>" class="btn">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>