<!DOCTYPE html>
<html>
<head>
    <title>All Inventory QR Codes</title>
    <style>
        @media print {
            .no-print { display: none; }
            .qr-item { page-break-inside: avoid; }
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .qr-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 20px;
        }
        .qr-item {
            border: 2px solid #333;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            background: #fff;
        }
        .qr-item img {
            width: 150px;
            height: 150px;
        }
        .qr-item h3 {
            margin: 10px 0;
            font-size: 16px;
            color: #2c3e50;
        }
        .qr-item .sku {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            background: #f4f4f4;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }
        .qr-item .price {
            color: #27ae60;
            font-weight: bold;
            font-size: 18px;
        }
        .print-btn {
            margin: 20px 0;
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
    <div class="no-print">
        <h1>📦 All Inventory QR Codes</h1>
        <button onclick="window.print()" class="print-btn">🖨️ Print All QR Codes</button>
        <a href="<?= base_url('inventory') ?>">← Back to Inventory</a>
    </div>
    
    <div class="qr-grid">
        <?php foreach ($items as $item): ?>
        <div class="qr-item">
            <img src="<?= $item['qr_code_url'] ?>" alt="QR Code">
            <h3><?= $item['name'] ?></h3>
            <div class="sku"><?= isset($item['sku']) ? $item['sku'] : 'VET-' . $item['id'] ?></div>
            <div class="price">₱<?= number_format($item['price'], 2) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">
                <?= $item['category'] ?> | Stock: <?= $item['quantity'] ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>