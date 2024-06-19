<?php
// require_once './src/Product.php';

// $product = new Product([
//     'name' => 'Product 1',
//     'price' => 100
// ]);

// if ($product->save()) {
//     echo "Product created successfully.";
// } else {
//     echo "Failed to create product.";
// }
// ?>



<?php
require_once './src/User.php';

try {
    // Créer la table des user
    User::createTable();

    // Créer un nouvel user
    $user = new User([
        'name' => 'Hanane',
        'email' => 'hanane@gmail.com',
        'password' => 'secret'
    ]);

    if ($user->save()) {
        echo "User created successfully.";
    } else {
        echo "Failed to create user.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
