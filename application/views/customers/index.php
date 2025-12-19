<div class="card">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('customers/add') ?>" class="btn" style="margin-bottom: 20px;">Add Customer</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= $customer['id'] ?></td>
            <td><?= $customer['name'] ?></td>
            <td><?= $customer['email'] ?></td>
            <td><?= $customer['phone'] ?></td>
            <td><?= $customer['address'] ?></td>
            <td>
                <a href="<?= base_url('customers/edit/' . $customer['id']) ?>" class="btn">Edit</a>
                <a href="<?= base_url('customers/delete/' . $customer['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>