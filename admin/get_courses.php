<?php
require 'db.php';

$db = get_db_connection();
$stmt = $db->query('SELECT id, name, short_id FROM courses');
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($courses);
?>