<!DOCTYPE html>
<html>
<head>
    <title>Setup Image Folders</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 50px; background: #f4f4f4; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .step { background: #e7f3ff; padding: 15px; margin: 15px 0; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Image Folder Setup</h1>
        
        <?php
        $base_path = dirname(__FILE__);
        $folders = [
            $base_path . '/assets',
            $base_path . '/assets/images',
            $base_path . '/assets/images/pets'
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
        $default_img = $base_path . '/assets/images/pets/default-pet.png';
        if (!file_exists($default_img)) {
            if (function_exists('imagecreate')) {
                $img = imagecreate(300, 300);
                $bg = imagecolorallocate($img, 230, 230, 230);
                $border = imagecolorallocate($img, 150, 150, 150);
                $text = imagecolorallocate($img, 100, 100, 100);
                
                imagerectangle($img, 0, 0, 299, 299, $border);
                imagestring($img, 5, 100, 140, 'NO PHOTO', $text);
                imagestring($img, 3, 110, 160, 'AVAILABLE', $text);
                
                if (@imagepng($img, $default_img)) {
                    echo "<div class='success'>✅ Created default placeholder image</div>";
                } else {
                    echo "<div class='warning'>⚠️ Could not create placeholder image</div>";
                }
                imagedestroy($img);
            } else {
                echo "<div class='warning'>⚠️ GD library not available - skip placeholder creation</div>";
            }
        } else {
            echo "<div class='success'>✓ Default image exists</div>";
        }
        
        // Test permissions
        echo "<h3>Testing Permissions...</h3>";
        $test_file = $base_path . '/assets/images/pets/test_write.txt';
        
        if (@file_put_contents($test_file, 'test')) {
            echo "<div class='success'>✅ Write permission OK</div>";
            @unlink($test_file);
        } else {
            echo "<div class='error'>❌ Cannot write to folder - PERMISSION ISSUE!</div>";
            $all_created = false;
        }
        
        if ($all_created) {
            echo "<div class='success'>";
            echo "<h3>✅ Setup Complete!</h3>";
            echo "<strong>Next Steps:</strong><br>";
            echo "1. Delete this file (setup_folders.php)<br>";
            echo "2. Update your Pets.php controller (see below)<br>";
            echo "3. Test by adding a pet with an image<br>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h3>❌ Manual Setup Required</h3>";
            echo "<p>The script couldn't create folders automatically. Please follow the manual steps below.</p>";
            echo "</div>";
            
            echo "<div class='step'>";
            echo "<h4>Manual Setup Steps:</h4>";
            echo "<ol>";
            echo "<li>Close all browser windows</li>";
            echo "<li>Open File Explorer as Administrator (right-click → Run as Administrator)</li>";
            echo "<li>Navigate to: <code>C:\\inetpub\\wwwroot\\vet_clinic\\</code></li>";
            echo "<li>Create these folders:<br>";
            echo "&nbsp;&nbsp;- <code>assets</code><br>";
            echo "&nbsp;&nbsp;- <code>assets\\images</code><br>";
            echo "&nbsp;&nbsp;- <code>assets\\images\\pets</code></li>";
            echo "<li>Right-click <code>assets</code> folder → Properties → Security</li>";
            echo "<li>Click 'Edit' → 'Add' → Type: <code>Everyone</code> → Check Names → OK</li>";
            echo "<li>Check 'Full Control' for Everyone → Apply → OK</li>";
            echo "<li>Open Command Prompt as Administrator</li>";
            echo "<li>Run: <code>iisreset</code></li>";
            echo "<li>Refresh this page</li>";
            echo "</ol>";
            echo "</div>";
        }
        
        // Show current folder structure
        echo "<h3>Current Folder Status:</h3>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th style='padding: 8px; text-align: left;'>Folder</th><th>Exists?</th><th>Writable?</th></tr>";
        foreach ($folders as $folder) {
            $exists = is_dir($folder) ? '✅ Yes' : '❌ No';
            $writable = is_writable($folder) ? '✅ Yes' : '❌ No';
            echo "<tr><td style='padding: 8px;'><code>$folder</code></td><td style='padding: 8px;'>$exists</td><td style='padding: 8px;'>$writable</td></tr>";
        }
        echo "</table>";
        ?>
        
        <div class="info" style="margin-top: 30px;">
            <strong>⚠️ Important:</strong><br>
            After folders are created and permissions are set correctly,<br>
            update your <code>Pets.php</code> controller with the version below.
        </div>
    </div>
</body>
</html>