<?php
require_once './src/User.php';

$user = new User([
    'id' => 1,
    'name' => 'Updated John Doe',
    'email' => 'updated_john@example.com',
    'password' => 'newsecret'
]);

if ($user->update()) {
    echo "User updated successfully.";
} else {
    echo "Failed to update user.";
}
?>
