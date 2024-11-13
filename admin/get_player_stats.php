<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $player_id = $_GET['player_id'];
    $db = get_db_connection();
    $stmt = $db->prepare('
        SELECT c.name, g.date_played, s.score
        FROM scores s
        JOIN games g ON s.game_id = g.id
        JOIN courses c ON g.course_id = c.id
        WHERE s.player_id = ?
    ');
    $stmt->execute([$player_id]);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($stats);
}
?>