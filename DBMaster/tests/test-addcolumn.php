<?php
require_once './config/Database.php';
require_once './src/User.php';

try {
    // Initially create the table
    User::createTable();
    echo "Initial table 'users' created successfully.\n";

    // ajouter nauveau colum
    if (User::addColumn('address', 'integer')) {
        echo "Column 'address' added successfully.\n";
    } else {
        echo "Failed to add column 'address'.\n";
    }

    // verifier nauveau colum if exist
    $user = new User([
        'name' => 'fatima',
        'email' => 'fatima@gmail.com',
        'password' => 'fatima@1234',
        'address' => 123
    ]);

    if ($user->save()) {
        echo "User with new column 'address' created successfully.\n";
    } else {
        echo "Failed to create user with new column 'address'.\n";
    }

    //apres l'ajoute il affiche mise ajour de l'onject
    echo "Users:\n";
    $allUsers = User::findAll();
    print_r($allUsers);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
