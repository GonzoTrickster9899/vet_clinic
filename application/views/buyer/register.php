<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .register-container { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 100%; max-width: 500px; }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #667eea; font-size: 28px; margin-bottom: 5px; }
        .logo p { color: #666; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus, textarea:focus { outline: none; border-color: #667eea; }
        .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: 500; }
        .btn:hover { opacity: 0.9; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 5px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .link-text { text-align: center; margin-top: 20px; color: #666; }
        .link-text a { color: #667eea; text-decoration: none; font-weight: 500; }
        .link-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>🐾 Vet Clinic Shop</h1>
            <p>Create Buyer Account</p>
        </div>
        
        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
        
        <form method="post">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= set_value('full_name') ?>" required>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= set_value('username') ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= set_value('email') ?>" required>
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?= set_value('phone') ?>" required>
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2" required><?= set_value('address') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirm" required>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
        
        <div class="link-text">
            Already have an account? <a href="<?= base_url('buyer/login') ?>">Login here</a>
        </div>
        
        <div class="link-text">
            <a href="<?= base_url('marketplace') ?>">← Back to Shop</a>
        </div>
    </div>
</body>
</html>