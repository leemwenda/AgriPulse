<?php
/**
 * AgriPulse Installation Script
 * 
 * This script helps set up the database on your hosting server.
 * 
 * IMPORTANT: Delete this file after installation for security!
 * 
 * Usage: Visit https://yourdomain.com/install.php
 */

// Prevent running if already installed
if (file_exists(__DIR__.'/../.installed')) {
    die('Installation already completed. Delete .installed file to reinstall.');
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>AgriPulse Installation</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; margin: 10px 0; }
        .info { color: blue; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; margin: 10px 0; }
        h1 { color: #2d3748; }
        .step { margin: 20px 0; padding: 15px; background: #f7fafc; border-left: 4px solid #4299e1; }
    </style>
</head>
<body>
    <h1>🌾 AgriPulse Installation</h1>
";

try {
    // Load Laravel
    require __DIR__.'/../vendor/autoload.php';
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "<div class='step'><h2>Step 1: Testing Database Connection</h2>";
    
    // Test database connection
    try {
        DB::connection()->getPdo();
        echo "<div class='success'>✓ Database connection successful!</div>";
    } catch (Exception $e) {
        echo "<div class='error'>✗ Database connection failed: " . $e->getMessage() . "</div>";
        echo "<p>Please check your .env file database credentials.</p>";
        die("</div></body></html>");
    }
    
    echo "</div>";
    
    // Run migrations
    echo "<div class='step'><h2>Step 2: Creating Database Tables</h2>";
    
    try {
        $kernel->call('migrate', ['--force' => true]);
        echo "<div class='success'>✓ Database tables created successfully!</div>";
    } catch (Exception $e) {
        echo "<div class='error'>✗ Migration failed: " . $e->getMessage() . "</div>";
        die("</div></body></html>");
    }
    
    echo "</div>";
    
    // Seed database
    echo "<div class='step'><h2>Step 3: Creating Default Users</h2>";
    
    try {
        $kernel->call('db:seed', ['--force' => true]);
        echo "<div class='success'>✓ Default users created successfully!</div>";
        echo "<div class='info'>
            <strong>Default Login Credentials:</strong><br>
            <strong>Admin:</strong> admin@agripulse.com / password<br>
            <strong>Worker:</strong> worker@agripulse.com / password<br>
            <br>
            <strong>⚠️ IMPORTANT: Change these passwords immediately after login!</strong>
        </div>";
    } catch (Exception $e) {
        echo "<div class='error'>✗ Seeding failed: " . $e->getMessage() . "</div>";
        echo "<div class='info'>You can skip this and create users manually.</div>";
    }
    
    echo "</div>";
    
    // Create installed flag
    file_put_contents(__DIR__.'/../.installed', date('Y-m-d H:i:s'));
    
    echo "<div class='step'><h2>✅ Installation Complete!</h2>";
    echo "<div class='success'>
        <p><strong>AgriPulse has been installed successfully!</strong></p>
        <p>Next steps:</p>
        <ol>
            <li><strong>DELETE THIS FILE (install.php)</strong> for security</li>
            <li>Visit your website: <a href='/'>Go to AgriPulse</a></li>
            <li>Login with the credentials above</li>
            <li>Change default passwords immediately</li>
            <li>Start managing your dairy farm!</li>
        </ol>
    </div>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'><strong>Installation Error:</strong><br>" . $e->getMessage() . "</div>";
    echo "<p>Please check your server configuration and try again.</p>";
}

echo "</body></html>";
?>
