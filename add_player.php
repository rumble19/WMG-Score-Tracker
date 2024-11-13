<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $db = get_db_connection();
    $stmt = $db->prepare('INSERT INTO players (name) VALUES (?)');
    $stmt->execute([$name]);
    echo 'Player added successfully';
}
?>