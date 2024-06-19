<?php
require_once './src/User.php';

$user = User::find(1);

if ($user) {
    print_r($user);
} else {
    echo "User not found.";
}
?>
