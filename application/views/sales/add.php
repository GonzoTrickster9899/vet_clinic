<div class="card">
    <h2>New Sale</h2>
    
    <form method="post" id="saleForm">
        <div class="form-group">
            <label>Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer): ?>
                <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <h3>Items</h3>
        <div id="items-container">
            <div class="item-row" style="display: grid; grid-template-columns: 2fr 1fr 1fr 100px; gap: 10px; margin-bottom: 10px;">
                <select class="item-select" required>
                    <option value="">Select Item</option>
                    <?php foreach ($inventory as $item): ?>
                    <option value="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>" data-stock="<?= $item['quantity'] ?>">
                        <?= $item['name'] ?> (Stock: <?= $item['quantity'] ?>) - ₱<?= number_format($item['price'], 2) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" class="item-qty" placeholder="Quantity" min="1" required>
                <input type="text" class="item-total" placeholder="Total" readonly>
                <button type="button" class="btn btn-danger" onclick="removeItem(this)">Remove</button>
            </div>
        </div>
        
        <button type="button" class="btn btn-success" onclick="addItem()" style="margin: 10px 0;">Add Item</button>
        
        <div class="form-group">
            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="gcash">GCash</option>
            </select>
        </div>
        
        <div class="form-group">
            <h3>Total: ₱<span id="grandTotal">0.00</span></h3>
        </div>
        
        <input type="hidden" name="items" id="items">
        <input type="hidden" name="total" id="total">
        
        <button type="submit" class="btn">Complete Sale</button>
        <a href="<?= base_url('sales') ?>" class="btn btn-danger">Cancel</a>
    </form>
</div>

<script>
function addItem() {
    const container = document.getElementById('items-container');
    const firstRow = container.querySelector('.item-row');
    const newRow = firstRow.cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(newRow);
    attachItemListeners(newRow);
}

function removeItem(btn) {
    const container = document.getElementById('items-container');
    if (container.children.length > 1) {
        btn.parentElement.remove();
        calculateTotal();
    }
}

function attachItemListeners(row) {
    const select = row.querySelector('.item-select');
    const qty = row.querySelector('.item-qty');
    const total = row.querySelector('.item-total');
    
    function calculate() {
        const selected = select.options[select.selectedIndex];
        if (selected.value && qty.value) {
            const price = parseFloat(selected.dataset.price);
            const stock = parseInt(selected.dataset.stock);
            const quantity = parseInt(qty.value);
            
            if (quantity > stock) {
                alert('Not enough stock! Available: ' + stock);
                qty.value = stock;
                return;
            }
            
            total.value = '₱' + (price * quantity).toFixed(2);
            calculateTotal();
        }
    }
    
    select.addEventListener('change', calculate);
    qty.addEventListener('input', calculate);
}

function calculateTotal() {
    let grand = 0;
    document.querySelectorAll('.item-total').forEach(input => {
        if (input.value) {
            grand += parseFloat(input.value.replace('₱', ''));
        }
    });
    document.getElementById('grandTotal').textContent = grand.toFixed(2);
    document.getElementById('total').value = grand.toFixed(2);
}

// Initialize
document.querySelectorAll('.item-row').forEach(row => attachItemListeners(row));

document.getElementById('saleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const items = [];
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.item-select');
        const qty = row.querySelector('.item-qty');
        
        if (select.value && qty.value) {
            items.push({
                id: select.value,
                name: select.options[select.selectedIndex].text.split(' (')[0],
                quantity: parseInt(qty.value),
                price: parseFloat(select.options[select.selectedIndex].dataset.price)
            });
        }
    });
    
    if (items.length === 0) {
        alert('Please add at least one item');
        return;
    }
    
    document.getElementById('items').value = JSON.stringify(items);
    this.submit();
});
</script>