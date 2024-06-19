<?php
require_once './config/Database.php';
require_once './src/User.php';

try {
    // suprime column
    if (User::dropColumn('address')) {
        echo "Column 'address' dropped successfully.\n";
    } else {
        echo "Failed to drop column 'address'.\n";
    }
    echo "Users after dropping 'address' column:\n";
    $allUsers = User::findAll();
    print_r($allUsers);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
