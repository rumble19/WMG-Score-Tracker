document.addEventListener("DOMContentLoaded", async () => {
  await populateCourses();
  await populatePlayers();
  await populatePlayerStatsDropdown();
});

async function populateCourses() {
  const response = await fetch("get_courses.php");
  const courses = await response.json();
  const courseSelect = document.getElementById("course-select");
  courseSelect.innerHTML = '<option value="">Select Course</option>'; // Clear existing options
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
    select.innerHTML = '<option value="">Select Player</option>'; // Clear existing options
    players.forEach((player) => {
      const option = document.createElement("option");
      option.value = player.id;
      option.textContent = player.name;
      select.appendChild(option);
    });
  });
}

async function populatePlayerStatsDropdown() {
  const response = await fetch("get_players.php");
  const players = await response.json();
  const playerSelect = document.getElementById("player-select");
  playerSelect.innerHTML = '<option value="">Select Player</option>'; // Clear existing options
  players.forEach((player) => {
    const option = document.createElement("option");
    option.value = player.id;
    option.textContent = player.name;
    playerSelect.appendChild(option);
  });
}

document.getElementById("add-player-button").addEventListener("click", () => {
  const playersContainer = document.getElementById("players-container");
  const playerScoreDiv = document.createElement("div");
  playerScoreDiv.className = "player-score form-group";
  playerScoreDiv.innerHTML = `
        <div class="d-flex align-items-center mb-2">
            <select class="player-select form-control mr-2" required>
                <option value="">Select Player</option>
            </select>
            <input type="text" class="form-control total-score" placeholder="Total Score" readonly>
        </div>
        <div class="d-flex">
            ${Array.from(
              { length: 18 },
              (_, i) => `
                <input type="text" inputmode="numeric" class="form-control hole-score-input mr-2 mb-2" placeholder="H${
                  i + 1
                }" required>
            `
            ).join("")}
        </div>
    `;
  playersContainer.appendChild(playerScoreDiv);
  populatePlayers();
  addScoreInputListeners(playerScoreDiv);
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
  await populatePlayerStatsDropdown();
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
  const playerScores = [];
  document.querySelectorAll(".player-score").forEach((div) => {
    const player_id = div.querySelector(".player-select").value;
    const holeScores = Array.from(div.querySelectorAll(".hole-score-input")).map(
      (input) => parseInt(input.value)
    );
    playerScores.push({ player_id, holeScores });
  });
  const response = await fetch("add_game.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `course_id=${course_id}&scores=${encodeURIComponent(
      JSON.stringify(playerScores)
    )}`,
  });
  const result = await response.json();
  if (result.success) {
    alert(result.success);
  } else {
    alert(result.error);
  }
  document.getElementById("add-game-form").reset();
  document.getElementById("players-container").innerHTML = `
        <div class="player-score form-group">
            <div class="d-flex align-items-center mb-2">
                <select class="player-select form-control mr-2" required>
                    <option value="">Select Player</option>
                </select>
                <input type="text" class="form-control total-score" placeholder="Total Score" readonly>
            </div>
            <div class="d-flex">
                ${Array.from(
                  { length: 18 },
                  (_, i) => `
                    <input type="text" inputmode="numeric" class="form-control hole-score-input mr-2 mb-2" placeholder="H${
                      i + 1
                    }" required>
                `
                ).join("")}
            </div>
        </div>
    `;
  await populatePlayers();
});

document.getElementById("get-player-stats-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const player_id = document.getElementById("player-select").value;
  const response = await fetch(`get_player_stats.php?player_id=${player_id}`);
  const stats = await response.json();
  const statsDiv = document.getElementById("player-stats");
  statsDiv.innerHTML = "<h2>Player Stats</h2>";
  if (stats.error) {
    statsDiv.innerHTML += `<p>${stats.error}</p>`;
  } else {
    stats.forEach((stat) => {
      statsDiv.innerHTML += `
                <p>Course: ${stat.name}, Date: ${stat.date_played}</p>
                <p>Scores: ${stat.hole1_score}, ${stat.hole2_score}, ${stat.hole3_score}, ${stat.hole4_score}, ${stat.hole5_score}, ${stat.hole6_score}, ${stat.hole7_score}, ${stat.hole8_score}, ${stat.hole9_score}, ${stat.hole10_score}, ${stat.hole11_score}, ${stat.hole12_score}, ${stat.hole13_score}, ${stat.hole14_score}, ${stat.hole15_score}, ${stat.hole16_score}, ${stat.hole17_score}, ${stat.hole18_score}</p>
                <p>Total Score: ${stat.total_score}</p>
            `;
    });
  }
});

function addScoreInputListeners(playerScoreDiv) {
  const holeInputs = playerScoreDiv.querySelectorAll(".hole-score-input");
  const totalScoreInput = playerScoreDiv.querySelector(".total-score");

  holeInputs.forEach((input) => {
    input.addEventListener("input", () => {
      const totalScore = Array.from(holeInputs).reduce(
        (sum, input) => sum + (parseInt(input.value) || 0),
        0
      );
      totalScoreInput.value = totalScore;
    });
  });
}

document.querySelectorAll(".player-score").forEach((playerScoreDiv) => {
  addScoreInputListeners(playerScoreDiv);
});
