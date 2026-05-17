<?php

function insertPlayerTrend() {
    include 'dbh.php';

    $currentDate = date('Y-m-d');
    echo $currentDate;
    $q = "SELECT time FROM player_trends WHERE time = '".mysqli_real_escape_string($conn, $currentDate)."'";
    $table = mysqli_query($conn, $q);

    if(mysqli_num_rows($table) === 0) {
        $q = "SELECT SUM(server_online) AS total_online_players FROM known_servers";
        $table = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($table);

        $q = "INSERT INTO player_trends(player_amount) VALUES(".mysqli_real_escape_string($conn, $row['total_online_players']).")";
        mysqli_query($conn, $q);
    } else {
        exit;
    }
}