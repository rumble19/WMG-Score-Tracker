<?php
require 'auth.php';

if (!isLoggedIn() && hasUsers()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (register($username, $password)) {
        header('Location: login.php');
        exit();
    } else {
        echo 'Registration failed';
    }
}
