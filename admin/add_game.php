<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $scores = $_POST['scores']; // JSON string

    $db = get_db_connection();
    $db->beginTransaction();
    $stmt = $db->prepare('INSERT INTO games (course_id, date_played) VALUES (?, ?)');
    $stmt->execute([$course_id, date('Y-m-d')]);
    $game_id = $db->lastInsertId();

    $scores = json_decode($scores, true);
    foreach ($scores as $player_id => $score) {
        $stmt = $db->prepare('INSERT INTO scores (game_id, player_id, score) VALUES (?, ?, ?)');
        $stmt->execute([$game_id, $player_id, $score]);
    }

    $db->commit();
    echo 'Game added successfully';
}
?>