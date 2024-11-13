<?php
session_start();
require 'db.php';

function register($username, $password)
{
    $db = get_db_connection();
    $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $stmt->execute([$username, $hashedPassword]);
}

function login($username, $password)
{
    $db = get_db_connection();
    $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function logout()
{
    session_destroy();
}

function hasUsers()
{
    $db = get_db_connection();
    $stmt = $db->query('SELECT COUNT(*) FROM users');
    return $stmt->fetchColumn() > 0;
}
