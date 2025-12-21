<!DOCTYPE html>
<html>
<head>
    <title>Create Sessions Directory</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 50px; background: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; margin: 20px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; border: 1px solid #bee5eb; margin: 20px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Session Directory Setup</h1>
        
        <?php
        // Define the sessions directory path
        $app_path = dirname(__FILE__) . '/application';
        $sessions_path = $app_path . '/sessions';
        $data_path = $app_path . '/data';
        
        echo "<div class='info'><strong>Checking directories...</strong></div>";
        
        $success = true;
        $messages = [];
        
        // Create sessions directory
        if (!is_dir($sessions_path)) {
            if (mkdir($sessions_path, 0777, true)) {
                $messages[] = "✅ Created sessions directory: <code>$sessions_path</code>";
                chmod($sessions_path, 0777);
            } else {
                $messages[] = "❌ Failed to create sessions directory";
                $success = false;
            }
        } else {
            $messages[] = "✅ Sessions directory already exists";
            chmod($sessions_path, 0777);
        }
        
        // Create .htaccess for sessions directory
        $htaccess_content = "Deny from all";
        $htaccess_path = $sessions_path . '/.htaccess';
        if (!file_exists($htaccess_path)) {
            if (file_put_contents($htaccess_path, $htaccess_content)) {
                $messages[] = "✅ Created .htaccess protection for sessions";
            }
        }
        
        // Create index.html for sessions directory
        $index_content = "<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
        $index_path = $sessions_path . '/index.html';
        if (!file_exists($index_path)) {
            if (file_put_contents($index_path, $index_content)) {
                $messages[] = "✅ Created index.html protection";
            }
        }
        
        // Check data directory
        if (!is_dir($data_path)) {
            if (mkdir($data_path, 0777, true)) {
                $messages[] = "✅ Created data directory: <code>$data_path</code>";
                chmod($data_path, 0777);
            }
        } else {
            $messages[] = "✅ Data directory exists";
            chmod($data_path, 0777);
        }
        
        // Display results
        if ($success) {
            echo "<div class='success'>";
            echo "<strong>✅ Setup Completed Successfully!</strong><br><br>";
            foreach ($messages as $msg) {
                echo $msg . "<br>";
            }
            echo "</div>";
            
            echo "<div class='info'>";
            echo "<strong>Next Steps:</strong><br>";
            echo "1. Delete this file (create_sessions_dir.php)<br>";
            echo "2. Make sure application/config/config.php has:<br>";
            echo "&nbsp;&nbsp;&nbsp;<code>\$config['sess_save_path'] = APPPATH . 'sessions';</code><br>";
            echo "3. Visit: <a href='http://localhost/vet_clinic/'>http://localhost/vet_clinic/</a><br>";
            echo "4. You should be redirected to the login page<br>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<strong>❌ Setup Failed</strong><br><br>";
            foreach ($messages as $msg) {
                echo $msg . "<br>";
            }
            echo "<br><strong>Manual Fix:</strong><br>";
            echo "1. Manually create folder: <code>C:\\inetpub\\wwwroot\\vet_clinic\\application\\sessions</code><br>";
            echo "2. Right-click → Properties → Security<br>";
            echo "3. Give 'IIS_IUSRS' and 'IUSR' full control<br>";
            echo "</div>";
        }
        
        // Display current permissions
        echo "<div class='info'>";
        echo "<strong>Directory Permissions:</strong><br>";
        echo "Sessions: " . (is_writable($sessions_path) ? "✅ Writable" : "❌ Not Writable") . "<br>";
        echo "Data: " . (is_writable($data_path) ? "✅ Writable" : "❌ Not Writable") . "<br>";
        echo "</div>";
        ?>
    </div>
</body>
</html>