<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-container { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 100%; max-width: 400px; }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #667eea; font-size: 28px; margin-bottom: 5px; }
        .logo p { color: #666; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { outline: none; border-color: #667eea; }
        .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: 500; }
        .btn:hover { opacity: 0.9; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 5px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .link-text { text-align: center; margin-top: 20px; color: #666; }
        .link-text a { color: #667eea; text-decoration: none; font-weight: 500; }
        .link-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>🐾 Vet Clinic Shop</h1>
            <p>Buyer Login</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>
        
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= set_value('username') ?>" required autofocus>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="link-text">
            Don't have an account? <a href="<?= base_url('buyer/register') ?>">Register here</a>
        </div>
        
        <div class="link-text">
            <a href="<?= base_url('marketplace') ?>">← Back to Shop</a>
        </div>
        
        <div class="link-text" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
            <a href="<?= base_url('auth/login') ?>">Staff Login</a>
        </div>
    </div>
</body>
</html>