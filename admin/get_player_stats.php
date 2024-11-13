<?php
require 'auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

if (isset($_GET['player_id'])) {
    $player_id = $_GET['player_id'];

    $db = get_db_connection();
    $stmt = $db->prepare('
        SELECT courses.name, games.date_played, scores.hole1_score, scores.hole2_score, scores.hole3_score, scores.hole4_score, scores.hole5_score, scores.hole6_score, scores.hole7_score, scores.hole8_score, scores.hole9_score, scores.hole10_score, scores.hole11_score, scores.hole12_score, scores.hole13_score, scores.hole14_score, scores.hole15_score, scores.hole16_score, scores.hole17_score, scores.hole18_score, scores.total_score
        FROM scores
        JOIN games ON scores.game_id = games.id
        JOIN courses ON games.course_id = courses.id
        WHERE scores.player_id = ?
    ');
    $stmt->execute([$player_id]);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($stats);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
