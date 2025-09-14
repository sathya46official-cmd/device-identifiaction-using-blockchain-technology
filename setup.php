<?php
// Setup script for Device DID Registry System
// Run this after setting up XAMPP to automatically configure the database

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'echo_did';

echo "<h1>Device DID Registry - Setup Script</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 40px; } .success { color: green; } .error { color: red; } .info { color: blue; }</style>";

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p class='success'>✓ Connected to MySQL server</p>";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "<p class='success'>✓ Database '$dbname' created/verified</p>";
    
    // Use the database
    $pdo->exec("USE $dbname");
    
    // Read and execute SQL schema
    $sqlFile = __DIR__ . '/database/device_registry.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        
        // Split SQL into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
        
        // Insert or update default admin user (password: admin123)
        $adminPasswordHash = password_hash('admin123', PASSWORD_DEFAULT);
        
        // Check if admin user exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
        $checkStmt->execute();
        $adminExists = $checkStmt->fetchColumn() > 0;
        
        if ($adminExists) {
            // Update existing admin user
            $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ?, email = ? WHERE username = 'admin'");
            $stmt->execute([$adminPasswordHash, 'admin@deviceregistry.com']);
            echo "<p class='success'>✓ Admin user password updated</p>";
        } else {
            // Insert new admin user
            $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, email) VALUES (?, ?, ?)");
            $stmt->execute(['admin', $adminPasswordHash, 'admin@deviceregistry.com']);
            echo "<p class='success'>✓ Admin user created</p>";
        }
        
        echo "<p class='success'>✓ Database schema created successfully</p>";
    } else {
        echo "<p class='error'>✗ SQL schema file not found at: $sqlFile</p>";
    }
    
    // Test database structure
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p class='success'>✓ Tables created: " . implode(', ', $tables) . "</p>";
    
    // Check if admin user exists
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    echo "<p class='info'>ℹ Admin users in database: $adminCount</p>";
    
    echo "<h2>Setup Complete!</h2>";
    echo "<p class='success'>Your Device DID Registry system is ready to use.</p>";
    echo "<h3>Next Steps:</h3>";
    echo "<ol>";
    echo "<li><strong>Deploy Smart Contract:</strong> Copy smart_contract.sol to Remix IDE and deploy</li>";
    echo "<li><strong>Update Contract Address:</strong> Replace 'YOUR_CONTRACT_ADDRESS_HERE' in app.js</li>";
    echo "<li><strong>Test System:</strong> Visit <a href='index.html'>index.html</a> to start using the system</li>";
    echo "<li><strong>Access Admin Panel:</strong> Visit <a href='admin.html'>admin.html</a> to monitor devices</li>";
    echo "</ol>";
    
    echo "<h3>Default Admin Credentials:</h3>";
    echo "<p><strong>Username:</strong> admin<br><strong>Password:</strong> admin123</p>";
    echo "<p class='info'>Please change the default admin password after first login.</p>";
    
} catch (PDOException $e) {
    echo "<p class='error'>✗ Setup failed: " . $e->getMessage() . "</p>";
    echo "<h3>Troubleshooting:</h3>";
    echo "<ul>";
    echo "<li>Make sure XAMPP MySQL service is running</li>";
    echo "<li>Check if MySQL is accessible on localhost:3306</li>";
    echo "<li>Verify database credentials in api/config.php</li>";
    echo "</ul>";
}
?>
