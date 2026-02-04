<?php
/**
 * AgriPulse Permission Fixer
 * 
 * This script fixes file permissions for Laravel on shared hosting.
 * 
 * IMPORTANT: Delete this file after running for security!
 * 
 * Usage: Visit https://yourdomain.com/fix-permissions.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>AgriPulse - Fix Permissions</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; padding: 5px 10px; background: #d4edda; margin: 5px 0; }
        .error { color: red; padding: 5px 10px; background: #f8d7da; margin: 5px 0; }
        .warning { color: orange; padding: 5px 10px; background: #fff3cd; margin: 5px 0; }
        h1 { color: #2d3748; }
    </style>
</head>
<body>
    <h1>🔧 AgriPulse Permission Fixer</h1>
    <h2>Fixing directory permissions...</h2>
";

$directories = [
    __DIR__.'/../storage',
    __DIR__.'/../storage/app',
    __DIR__.'/../storage/app/public',
    __DIR__.'/../storage/framework',
    __DIR__.'/../storage/framework/cache',
    __DIR__.'/../storage/framework/cache/data',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/logs',
    __DIR__.'/../bootstrap/cache',
];

$success = 0;
$failed = 0;

foreach ($directories as $dir) {
    $relativePath = str_replace(__DIR__.'/../', '', $dir);
    
    // Create directory if it doesn't exist
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "<div class='success'>✓ Created: $relativePath</div>";
            $success++;
        } else {
            echo "<div class='error'>✗ Failed to create: $relativePath</div>";
            $failed++;
        }
    } else {
        // Try to set permissions
        if (chmod($dir, 0755)) {
            echo "<div class='success'>✓ Fixed permissions: $relativePath</div>";
            $success++;
        } else {
            echo "<div class='warning'>⚠ Could not change permissions: $relativePath (may already be correct)</div>";
        }
    }
}

// Create .gitignore files in storage directories
$gitignoreContent = "*\n!.gitignore\n";
$gitignoreDirs = [
    __DIR__.'/../storage/app',
    __DIR__.'/../storage/framework/cache',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/logs',
    __DIR__.'/../bootstrap/cache',
];

echo "<h2>Creating .gitignore files...</h2>";

foreach ($gitignoreDirs as $dir) {
    $gitignorePath = $dir.'/.gitignore';
    $relativePath = str_replace(__DIR__.'/../', '', $gitignorePath);
    
    if (!file_exists($gitignorePath)) {
        if (file_put_contents($gitignorePath, $gitignoreContent)) {
            echo "<div class='success'>✓ Created: $relativePath</div>";
        }
    }
}

// Create empty log file
$logFile = __DIR__.'/../storage/logs/laravel.log';
if (!file_exists($logFile)) {
    if (touch($logFile)) {
        chmod($logFile, 0664);
        echo "<div class='success'>✓ Created: storage/logs/laravel.log</div>";
    }
}

echo "
    <h2>Summary</h2>
    <p><strong>Directories processed:</strong> " . count($directories) . "</p>
    <p><strong>Successful:</strong> $success</p>
    <p><strong>Failed:</strong> $failed</p>
    
    <div class='warning'>
        <strong>⚠️ SECURITY WARNING:</strong><br>
        Please delete this file (fix-permissions.php) after running!
    </div>
    
    <p><a href='/'>← Go to AgriPulse</a></p>
</body>
</html>
";
?>
