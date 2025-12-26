<!DOCTYPE html>
<html>
<head>
    <title>Setup Inventory Images</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 50px; background: #f4f4f4; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Setup Inventory Image Folder</h1>
        
        <?php
        $base_path = dirname(__FILE__);
        $folders = [
            $base_path . '/assets/images/inventory'
        ];
        
        echo "<h3>Creating Directories...</h3>";
        
        $all_created = true;
        foreach ($folders as $folder) {
            if (!is_dir($folder)) {
                if (@mkdir($folder, 0777, true)) {
                    echo "<div class='success'>✅ Created: <code>$folder</code></div>";
                    @chmod($folder, 0777);
                } else {
                    echo "<div class='error'>❌ Failed to create: <code>$folder</code></div>";
                    $all_created = false;
                }
            } else {
                echo "<div class='success'>✓ Already exists: <code>$folder</code></div>";
                @chmod($folder, 0777);
            }
        }
        
        // Create default image
        $default_img = $base_path . '/assets/images/inventory/default-item.png';
        if (!file_exists($default_img)) {
            if (function_exists('imagecreate')) {
                $img = imagecreate(300, 300);
                $bg = imagecolorallocate($img, 240, 240, 240);
                $border = imagecolorallocate($img, 180, 180, 180);
                $text = imagecolorallocate($img, 120, 120, 120);
                
                imagerectangle($img, 0, 0, 299, 299, $border);
                imagestring($img, 5, 95, 140, 'NO IMAGE', $text);
                imagestring($img, 3, 105, 160, 'AVAILABLE', $text);
                
                if (@imagepng($img, $default_img)) {
                    echo "<div class='success'>✅ Created default placeholder image</div>";
                } else {
                    echo "<div class='error'>⚠️ Could not create placeholder</div>";
                }
                imagedestroy($img);
            }
        } else {
            echo "<div class='success'>✓ Default image exists</div>";
        }
        
        // Test permissions
        echo "<h3>Testing Permissions...</h3>";
        $test_file = $base_path . '/assets/images/inventory/test_write.txt';
        
        if (@file_put_contents($test_file, 'test')) {
            echo "<div class='success'>✅ Write permission OK</div>";
            @unlink($test_file);
        } else {
            echo "<div class='error'>❌ Cannot write - PERMISSION ISSUE!</div>";
            $all_created = false;
        }
        
        if ($all_created) {
            echo "<div class='success'>";
            echo "<h3>✅ Setup Complete!</h3>";
            echo "<strong>Next Steps:</strong><br>";
            echo "1. Delete this file<br>";
            echo "2. Update your Inventory controller and views<br>";
            echo "3. Restart IIS: <code>iisreset</code><br>";
            echo "4. Go to Inventory → Add Item<br>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>