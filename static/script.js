document.addEventListener("DOMContentLoaded", async () => {
  await populateCourses();
  await populatePlayers();
});

async function populateCourses() {
  const response = await fetch("get_courses.php");
  const courses = await response.json();
  const courseSelect = document.getElementById("course-select");
  courses.forEach((course) => {
    const option = document.createElement("option");
    option.value = course.id;
    option.textContent = `${course.name} - (${course.short_id})`;
    courseSelect.appendChild(option);
  });
}

async function populatePlayers() {
  const response = await fetch("get_players.php");
  const players = await response.json();
  const playerSelects = document.querySelectorAll(".player-select");
  playerSelects.forEach((select) => {
    players.forEach((player) => {
      const option = document.createElement("option");
      option.value = player.id;
      option.textContent = player.name;
      select.appendChild(option);
    });
  });
}

document.getElementById("add-player-button").addEventListener("click", () => {
  const playersContainer = document.getElementById("players-container");
  const playerScoreDiv = document.createElement("div");
  playerScoreDiv.className = "player-score";
  playerScoreDiv.innerHTML = `
        <select class="player-select" required>
            <option value="">Select Player</option>
        </select>
        <input type="number" class="player-score-input" placeholder="Score" required>
    `;
  playersContainer.appendChild(playerScoreDiv);
  populatePlayers();
});

document.getElementById("add-player-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = document.getElementById("player-name").value;
  const response = await fetch("add_player.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `name=${name}`,
  });
  alert(await response.text());
  document.getElementById("add-player-form").reset();
  await populatePlayers();
});

document.getElementById("add-course-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = document.getElementById("course-name").value;
  const short_id = document.getElementById("course-short-id").value;
  const par = document.getElementById("course-par").value;
  const response = await fetch("add_course.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `name=${name}&short_id=${short_id}&par=${par}`,
  });
  alert(await response.text());
  document.getElementById("add-course-form").reset();
  await populateCourses();
});

document.getElementById("add-game-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const course_id = document.getElementById("course-select").value;
  const playerScores = {};
  document.querySelectorAll(".player-score").forEach((div) => {
    const player_id = div.querySelector(".player-select").value;
    const score = div.querySelector(".player-score-input").value;
    playerScores[player_id] = score;
  });
  const response = await fetch("add_game.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `course_id=${course_id}&scores=${encodeURIComponent(
      JSON.stringify(playerScores)
    )}`,
  });
  alert(await response.text());
  document.getElementById("add-game-form").reset();
  document.getElementById("players-container").innerHTML = `
        <div class="player-score">
            <select class="player-select" required>
                <option value="">Select Player</option>
            </select>
            <input type="number" class="player-score-input" placeholder="Score" required>
        </div>
    `;
  await populatePlayers();
});

document.getElementById("get-player-stats-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const player_id = document.getElementById("player-id").value;
  const response = await fetch(`get_player_stats.php?player_id=${player_id}`);
  const stats = await response.json();
  const statsDiv = document.getElementById("player-stats");
  statsDiv.innerHTML = "<h2>Player Stats</h2>";
  stats.forEach((stat) => {
    statsDiv.innerHTML += `<p>Course: ${stat.name}, Date: ${stat.date_played}, Score: ${stat.score}</p>`;
  });
});
