<?php

// Test GD Extension
echo "=== PHP Configuration Test ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "GD Support: " . (extension_loaded('gd') ? "✓ ENABLED" : "✗ DISABLED") . "\n";

if (extension_loaded('gd')) {
    $gd_info = gd_info();
    echo "GD Version: " . $gd_info['GD Version'] . "\n";
    echo "JPEG Support: " . ($gd_info['JPEG Support'] ? "✓ Yes" : "✗ No") . "\n";
    echo "PNG Support: " . ($gd_info['PNG Support'] ? "✓ Yes" : "✗ No") . "\n";
} else {
    echo "⚠ GD extension is not loaded\n";
}

// Test if we can generate a simple image
if (extension_loaded('gd')) {
    echo "\n=== Testing Image Generation ===\n";
    $img = imagecreatetruecolor(100, 50);
    $color = imagecolorallocate($img, 255, 0, 0);
    imagefilledrectangle($img, 0, 0, 100, 50, $color);
    
    // Try to save as PNG
    $testFile = __DIR__ . '/test-gd-output.png';
    if (imagepng($img, $testFile)) {
        echo "✓ PNG generation test: SUCCESS\n";
        echo "Test file created: " . $testFile . "\n";
        unlink($testFile);
    } else {
        echo "✗ PNG generation test: FAILED\n";
    }
    imagedestroy($img);
}

echo "\n=== All Tests Completed ===\n";
?>
