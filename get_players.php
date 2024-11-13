<?php
require 'db.php';

$db = get_db_connection();
$stmt = $db->query('SELECT id, name FROM players');
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($players);
