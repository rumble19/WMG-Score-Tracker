<?php
require 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minigolf Tracker Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="static/script.js" defer></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Minigolf Tracker Admin</h1>
        <form id="add-player-form" class="mb-4">
            <h2>Add Player</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="player-name" placeholder="Player Name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Player</button>
        </form>

        <form id="add-course-form" class="mb-4">
            <h2>Add Course</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="course-name" placeholder="Course Name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="course-short-id" placeholder="Short ID (3 characters)" maxlength="3" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" id="course-par" placeholder="Par" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>

        <form id="add-game-form" class="mb-4">
            <h2>Add Game</h2>
            <div class="form-group">
                <select id="course-select" class="form-control" required>
                    <option value="">Select Course</option>
                </select>
            </div>
            <div id="players-container" class="mb-3">
                <div class="player-score form-group d-flex align-items-center">
                    <select class="player-select form-control mr-2" required>
                        <option value="">Select Player</option>
                    </select>
                    <input type="number" class="form-control player-score-input mr-2 w-25" placeholder="Score" required>
                </div>
            </div>
            <button type="button" id="add-player-button" class="btn btn-secondary mb-3 float-right">Add Player</button>
            <button type="submit" class="btn btn-primary">Submit Scores</button>
        </form>

        <form id="get-player-stats-form" class="mb-4">
            <h2>Get Player Stats</h2>
            <div class="form-group">
                <select id="player-select" class="form-control" required>
                    <option value="">Select Player</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Get Stats</button>
        </form>

        <div id="player-stats"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>