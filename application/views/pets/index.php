<div class="card">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('pets/add') ?>" class="btn" style="margin-bottom: 20px;">Add Pet</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Owner</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($pets as $pet): 
            $owner = null;
            foreach ($customers as $c) {
                if ($c['id'] == $pet['customer_id']) {
                    $owner = $c['name'];
                    break;
                }
            }
        ?>
        <tr>
            <td><?= $pet['id'] ?></td>
            <td><?= $pet['name'] ?></td>
            <td><?= $owner ?></td>
            <td><?= $pet['species'] ?></td>
            <td><?= $pet['breed'] ?></td>
            <td><?= $pet['age'] ?> years</td>
            <td>
                <a href="<?= base_url('pets/edit/' . $pet['id']) ?>" class="btn">Edit</a>
                <a href="<?= base_url('pets/delete/' . $pet['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>