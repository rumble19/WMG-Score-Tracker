<?php
require 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (register($username, $password)) {
        echo 'User registered successfully';
    } else {
        echo 'Registration failed';
    }
}
