<?php
require 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password)) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Login failed';
    }
}
