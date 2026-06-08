<?php
/**
 * Temporary migration runner script
 */
define('ROOT_PATH', dirname(__DIR__) . '/');

require_once ROOT_PATH . 'models/Database.php';

try {
    $db = Database::getInstance();
    
    // Check if points column already exists in users to avoid error
    $checkQuery = "SHOW COLUMNS FROM users LIKE 'points'";
    $stmt = $db->query($checkQuery);
    $columnExists = $stmt->fetch();
    
    if ($columnExists) {
        echo "Database already updated! Column 'points' exists in 'users'.\n";
    } else {
        $sql = file_get_contents(ROOT_PATH . 'database/shoptrasua_upgrade_points.sql');
        $db->exec($sql);
        echo "Migration executed successfully!\n";
    }
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
