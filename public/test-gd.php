<?php
echo "PHP Version: " . phpversion() . "<br>";
echo "GD Support: " . (extension_loaded('gd') ? "✓ ENABLED" : "✗ DISABLED") . "<br>";
if (extension_loaded('gd')) {
    $gd_info = gd_info();
    echo "GD Version: " . $gd_info['GD Version'] . "<br>";
    echo "JPEG Support: " . ($gd_info['JPEG Support'] ? "✓ Yes" : "✗ No") . "<br>";
    echo "PNG Support: " . ($gd_info['PNG Support'] ? "✓ Yes" : "✗ No") . "<br>";
}
?>
