<div class="card">
    <h2><?= $title ?></h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    
    <a href="<?= base_url('pets/add') ?>" class="btn" style="margin-bottom: 20px;">Add Pet</a>
    
    <table>
        <tr>
            <th>Photo</th>
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
            
            // Get image URL
            $image_url = base_url('assets/images/pets/' . (isset($pet['image']) && !empty($pet['image']) ? $pet['image'] : 'default-pet.png'));
        ?>
        <tr>
            <td>
                <img src="<?= $image_url ?>" alt="<?= $pet['name'] ?>" 
                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                     onerror="this.src='<?= base_url('assets/images/pets/default-pet.png') ?>'">
            </td>
            <td><?= $pet['id'] ?></td>
            <td><strong><?= $pet['name'] ?></strong></td>
            <td><?= $owner ?></td>
            <td><?= $pet['species'] ?></td>
            <td><?= $pet['breed'] ?></td>
            <td><?= $pet['age'] ?> years</td>
            <td>
                <a href="<?= base_url('pets/view/' . $pet['id']) ?>" class="btn btn-success">View</a>
                <a href="<?= base_url('pets/edit/' . $pet['id']) ?>" class="btn">Edit</a>
                <a href="<?= base_url('pets/delete/' . $pet['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure? This will also delete the pet image.')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>