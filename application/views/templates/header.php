<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Vet Clinic & Pet Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        nav { background: #2c3e50; padding: 15px 0; margin-bottom: 30px; }
        nav .container { display: flex; justify-content: space-between; align-items: center; }
        nav h1 { color: #fff; font-size: 24px; }
        nav .nav-left { display: flex; align-items: center; gap: 30px; }
        nav .nav-right { display: flex; align-items: center; gap: 15px; }
        nav ul { list-style: none; display: flex; gap: 20px; }
        nav a { color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 4px; }
        nav a:hover { background: #34495e; }
        .user-info { color: #fff; padding: 8px 15px; background: #34495e; border-radius: 4px; }
        .user-info .role { 
            display: inline-block;
            background: #e74c3c;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            margin-left: 8px;
        }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .btn { padding: 10px 20px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: #fff; }
        tr:hover { background: #f5f5f5; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px; border-radius: 8px; text-align: center; }
        .stat-card h3 { font-size: 36px; margin-bottom: 10px; }
        .stat-card p { opacity: 0.9; }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <div class="nav-left">
                <h1>🐾 Vet Clinic & Pet Shop</h1>
                <ul>
                    <li><a href="<?= base_url() ?>">Dashboard</a></li>
                    <li><a href="<?= base_url('customers') ?>">Customers</a></li>
                    <li><a href="<?= base_url('pets') ?>">Pets</a></li>
                    <li><a href="<?= base_url('appointments') ?>">Appointments</a></li>
                    <li><a href="<?= base_url('inventory') ?>">Inventory</a></li>
                    <li><a href="<?= base_url('sales') ?>">Sales</a></li>
                </ul>
            </div>
            <div class="nav-right">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <div class="user-info">
                        👤 <?= $this->session->userdata('full_name') ?>
                        <span class="role"><?= strtoupper($this->session->userdata('role')) ?></span>
                    </div>
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">