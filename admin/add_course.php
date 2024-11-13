<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $short_id = $_POST['short_id'];
    $par = $_POST['par'];
    $db = get_db_connection();
    $stmt = $db->prepare('INSERT INTO courses (name, short_id, par) VALUES (?, ?, ?)');
    $stmt->execute([$name, $short_id, $par]);
    echo 'Course added successfully';
}
