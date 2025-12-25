<div class="card">
    <h2>📱 Scan QR Code</h2>
    <p style="color: #666; margin-bottom: 30px;">Scan an inventory item QR code to view details instantly.</p>
    
    <div style="max-width: 600px; margin: 0 auto;">
        <div id="reader" style="width: 100%;"></div>
        
        <div style="margin-top: 30px; text-align: center;">
            <h3>Or Enter SKU Manually</h3>
            <input type="text" id="manual_sku" placeholder="Enter SKU (e.g., VET-2024-XXXXX)" 
                   style="width: 100%; padding: 15px; font-size: 16px; border: 2px solid #ddd; border-radius: 8px;">
            <button onclick="lookupSKU()" class="btn" style="margin-top: 15px; width: 100%;">
                Search Item
            </button>
        </div>
        
        <div id="result" style="margin-top: 30px;"></div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner;

// Initialize QR Scanner
function onScanSuccess(decodedText, decodedResult) {
    try {
        const data = JSON.parse(decodedText);
        displayResult(data);
        html5QrcodeScanner.clear();
    } catch (e) {
        // If not JSON, treat as SKU
        lookupBySKU(decodedText);
    }
}

function onScanFailure(error) {
    // Handle scan failure silently
}

// Initialize scanner on page load
html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    false
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);

function lookupSKU() {
    const sku = document.getElementById('manual_sku').value.trim();
    if (sku) {
        lookupBySKU(sku);
    } else {
        alert('Please enter a SKU');
    }
}

function lookupBySKU(sku) {
    fetch('<?= base_url("inventory/lookup") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'sku=' + encodeURIComponent(sku)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayResult(data.item);
        } else {
            document.getElementById('result').innerHTML = 
                '<div class="alert alert-danger">Item not found!</div>';
        }
    });
}

function displayResult(item) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `
        <div class="card" style="background: #f8f9fa; border: 2px solid #27ae60;">
            <h3 style="color: #27ae60;">✅ Item Found!</h3>
            <table style="width: 100%; margin-top: 20px;">
                <tr>
                    <td style="font-weight: bold; padding: 10px;">SKU:</td>
                    <td><code>${item.sku || 'VET-' + item.id}</code></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px;">Name:</td>
                    <td><strong>${item.name}</strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px;">Category:</td>
                    <td>${item.category}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px;">Price:</td>
                    <td style="color: #27ae60; font-size: 20px; font-weight: bold;">₱${parseFloat(item.price).toFixed(2)}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px;">Stock:</td>
                    <td>${item.quantity} units</td>
                </tr>
            </table>
            <a href="<?= base_url('inventory/view/') ?>${item.id}" class="btn" style="margin-top: 20px; width: 100%;">
                View Full Details
            </a>
        </div>
    `;
}
</script>