<div class="card">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('sales/add') ?>" class="btn" style="margin-bottom: 20px;">New Sale</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total</th>
            <th>Payment Method</th>
        </tr>
        <?php foreach ($sales as $sale): 
            $customer_name = 'N/A';
            foreach ($customers as $c) {
                if ($c['id'] == $sale['customer_id']) {
                    $customer_name = $c['name'];
                    break;
                }
            }
        ?>
        <tr>
            <td><?= $sale['id'] ?></td>
            <td><?= date('Y-m-d H:i', strtotime($sale['date'])) ?></td>
            <td><?= $customer_name ?></td>
            <td><?= count($sale['items']) ?> items</td>
            <td>₱<?= number_format($sale['total'], 2) ?></td>
            <td><?= ucfirst($sale['payment_method']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>