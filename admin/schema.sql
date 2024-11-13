-- schema.sql
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    short_id CHAR(3) NOT NULL UNIQUE,
    par INT NOT NULL
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
    score INT,
    FOREIGN KEY (game_id) REFERENCES games(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


-- Insert default admin user
-- Password is 'admin'
INSERT INTO users (username, password) VALUES ('admin', '$2y$10$EiM9poquBThgbBfgYJ9CIOLn4vqqv.lfXCnnqiAe3X/UuEVX1lQqG');