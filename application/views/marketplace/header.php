<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/resources/favicon.png') ?>" type="image/x-icon">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        /* Navigation */
        nav { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px 0; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        nav .container { display: flex; justify-content: space-between; align-items: center; }
        nav h1 { color: #fff; font-size: 24px; }
        nav h1 a { color: #fff; text-decoration: none; }
        nav .nav-left { display: flex; align-items: center; gap: 30px; }
        nav .nav-right { display: flex; align-items: center; gap: 15px; }
        nav ul { list-style: none; display: flex; gap: 20px; }
        nav a { color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 4px; transition: all 0.3s; }
        nav a:hover { background: rgba(255,255,255,0.2); }
        
        /* Cart Badge */
        .cart-badge { position: relative; }
        .cart-badge .badge { position: absolute; top: -8px; right: -8px; background: #e74c3c; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; }
        
        /* Buttons */
        .btn { padding: 10px 20px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s; }
        .btn:hover { background: #2980b9; transform: translateY(-2px); }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; }
        
        /* Cards */
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        
        /* Product Grid */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-top: 30px; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .product-card img { width: 100%; height: 250px; object-fit: cover; }
        .product-card .content { padding: 20px; }
        .product-card h3 { margin-bottom: 10px; color: #2c3e50; }
        .product-card .price { font-size: 24px; color: #27ae60; font-weight: bold; margin: 10px 0; }
        .product-card .stock { color: #7f8c8d; font-size: 14px; margin-bottom: 15px; }
        
        /* Alert Messages */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        /* Forms */
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; }
        
        /* Tables */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: #fff; }
        tr:hover { background: #f5f5f5; }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <div class="nav-left">
                <h1><a href="<?= base_url('marketplace') ?>">🐾 Vet Clinic Shop</a></h1>
                <ul>
                    <li><a href="<?= base_url('marketplace') ?>">Shop</a></li>
                    <?php if (isset($is_buyer) && $is_buyer): ?>
                        <li><a href="<?= base_url('buyer/orders') ?>">My Orders</a></li>
                        <li><a href="<?= base_url('buyer/account') ?>">My Account</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="nav-right">
                <a href="<?= base_url('marketplace/cart') ?>" class="cart-badge">
                    🛒 Cart
                    <?php $cart_count = $this->cart->total_items(); ?>
                    <?php if ($cart_count > 0): ?>
                        <span class="badge"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if (isset($is_buyer) && $is_buyer): ?>
                    <span style="color: #fff;">👤 <?= $this->session->userdata('full_name') ?></span>
                    <a href="<?= base_url('buyer/logout') ?>" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('buyer/login') ?>" class="btn">Login</a>
                    <a href="<?= base_url('buyer/register') ?>" class="btn btn-success">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">