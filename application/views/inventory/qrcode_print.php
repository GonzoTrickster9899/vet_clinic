<!DOCTYPE html>
<html>
<head>
    <title>QR Code - <?= $item['name'] ?></title>
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        .qr-container {
            display: inline-block;
            border: 3px solid #333;
            padding: 30px;
            border-radius: 10px;
            background: #fff;
        }
        .qr-code {
            margin: 20px 0;
        }
        h2 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        .sku {
            font-size: 24px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            background: #f4f4f4;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .details {
            margin-top: 20px;
            text-align: left;
        }
        .detail-row {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .print-btn {
            margin: 20px;
            padding: 15px 30px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn no-print">🖨️ Print QR Code</button>
    
    <div class="qr-container">
        <h2>🐾 Vet Clinic Inventory</h2>
        
        <div class="qr-code">
            <img src="<?= $qr_code_url ?>" alt="QR Code" style="width: 300px; height: 300px;">
        </div>
        
        <div class="sku"><?= isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'] ?></div>
        
        <div class="details">
            <div class="detail-row">
                <span class="label">Item:</span> <?= $item['name'] ?>
            </div>
            <div class="detail-row">
                <span class="label">Category:</span> <?= $item['category'] ?>
            </div>
            <div class="detail-row">
                <span class="label">Price:</span> ₱<?= number_format($item['price'], 2) ?>
            </div>
            <div class="detail-row">
                <span class="label">ID:</span> <?= $item['id'] ?>
            </div>
        </div>
    </div>
    
    <p class="no-print" style="margin-top: 30px; color: #666;">
        <a href="<?= base_url('inventory') ?>">← Back to Inventory</a>
    </p>
</body>
</html>