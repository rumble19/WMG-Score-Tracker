-- schema.sql
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    short_id CHAR(3) NOT NULL UNIQUE,
    hole1_par INT NOT NULL,
    hole2_par INT NOT NULL,
    hole3_par INT NOT NULL,
    hole4_par INT NOT NULL,
    hole5_par INT NOT NULL,
    hole6_par INT NOT NULL,
    hole7_par INT NOT NULL,
    hole8_par INT NOT NULL,
    hole9_par INT NOT NULL,
    hole10_par INT NOT NULL,
    hole11_par INT NOT NULL,
    hole12_par INT NOT NULL,
    hole13_par INT NOT NULL,
    hole14_par INT NOT NULL,
    hole15_par INT NOT NULL,
    hole16_par INT NOT NULL,
    hole17_par INT NOT NULL,
    hole18_par INT NOT NULL,
    total_par INT NOT NULL
);

CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    date_played DATE,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT,
    player_id INT,
    hole1_score INT NOT NULL,
    hole2_score INT NOT NULL,
    hole3_score INT NOT NULL,
    hole4_score INT NOT NULL,
    hole5_score INT NOT NULL,
    hole6_score INT NOT NULL,
    hole7_score INT NOT NULL,
    hole8_score INT NOT NULL,
    hole9_score INT NOT NULL,
    hole10_score INT NOT NULL,
    hole11_score INT NOT NULL,
    hole12_score INT NOT NULL,
    hole13_score INT NOT NULL,
    hole14_score INT NOT NULL,
    hole15_score INT NOT NULL,
    hole16_score INT NOT NULL,
    hole17_score INT NOT NULL,
    hole18_score INT NOT NULL,
    total_score INT NOT NULL,
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);