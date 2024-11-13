<?php
require 'auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $course_id = $_POST['course_id'];
        $scores = json_decode($_POST['scores'], true);

        $db = get_db_connection();
        $stmt = $db->prepare('INSERT INTO games (course_id, date_played) VALUES (?, ?)');
        $stmt->execute([$course_id, date('Y-m-d')]);
        $game_id = $db->lastInsertId();

        foreach ($scores as $playerScore) {
            $player_id = $playerScore['player_id'];
            $holeScores = $playerScore['holeScores'];
            $total_score = array_sum($holeScores);
            $stmt = $db->prepare('INSERT INTO scores (game_id, player_id, hole1_score, hole2_score, hole3_score, hole4_score, hole5_score, hole6_score, hole7_score, hole8_score, hole9_score, hole10_score, hole11_score, hole12_score, hole13_score, hole14_score, hole15_score, hole16_score, hole17_score, hole18_score, total_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array_merge([$game_id, $player_id], $holeScores, [$total_score]));
        }

        echo json_encode(['success' => 'Scores submitted successfully']);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
