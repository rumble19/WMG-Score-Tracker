<?php
require 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['courses-csv'])) {
    $file = $_FILES['courses-csv']['tmp_name'];
    $handle = fopen($file, 'r');
    if ($handle !== FALSE) {
        $db = get_db_connection();
        $isFirstRow = true; // Flag to skip the header row
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Skip the header row
            }
            $name = $data[0];
            $short_id = $data[1];
            $hole_pars = array_slice($data, 2, 18);
            $total_par = array_sum($hole_pars);
            $stmt = $db->prepare('INSERT INTO courses (name, short_id, hole1_par, hole2_par, hole3_par, hole4_par, hole5_par, hole6_par, hole7_par, hole8_par, hole9_par, hole10_par, hole11_par, hole12_par, hole13_par, hole14_par, hole15_par, hole16_par, hole17_par, hole18_par, total_par) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array_merge([$name, $short_id], $hole_pars, [$total_par]));
        }
        fclose($handle);
        header('Location: index.php?import_success=1'); // Redirect to admin dashboard with success flag
        exit();
    } else {
        echo 'Failed to open the CSV file';
    }
} else {
    echo 'Invalid request';
}
