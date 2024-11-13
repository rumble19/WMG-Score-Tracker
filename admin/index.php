<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minigolf Tracker Admin</title>
    <script src="static/script.js" defer></script>
</head>

<body>
    <h1>Minigolf Tracker Admin</h1>
    <form id="add-player-form">
        <h2>Add Player</h2>
        <input type="text" id="player-name" placeholder="Player Name" required>
        <button type="submit">Add Player</button>
    </form>

    <form id="add-course-form">
        <h2>Add Course</h2>
        <input type="text" id="course-name" placeholder="Course Name" required>
        <input type="text" id="course-short-id" placeholder="Short ID (3 characters)" maxlength="3" required>
        <input type="number" id="course-par" placeholder="Par" required>
        <button type="submit">Add Course</button>
    </form>

    <form id="add-game-form">
        <h2>Add Game</h2>
        <select id="course-select" required>
            <option value="">Select Course</option>
        </select>
        <div id="players-container">
            <div class="player-score">
                <select class="player-select" required>
                    <option value="">Select Player</option>
                </select>
                <input type="number" class="player-score-input" placeholder="Score" required>
            </div>
        </div>
        <button type="button" id="add-player-button">Add Player</button>
        <button type="submit">Add Game</button>
    </form>

    <form id="get-player-stats-form">
        <h2>Get Player Stats</h2>
        <input type="number" id="player-id" placeholder="Player ID" required>
        <button type="submit">Get Stats</button>
    </form>

    <div id="player-stats"></div>
</body>

</html>