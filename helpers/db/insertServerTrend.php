<?php

function insertServerTrend() {
    include 'dbh.php';

    $currentDate = date('Y-m-d');
    echo $currentDate;
    $q = "SELECT time FROM server_trends WHERE time = '".mysqli_real_escape_string($conn, $currentDate)."'";
    $table = mysqli_query($conn, $q);

    if(mysqli_num_rows($table) === 0) {
        $q = "SELECT COUNT(*) AS total_online_servers FROM known_servers";
        $table = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($table);

        $q = "INSERT INTO server_trends(server_amount) VALUES(".mysqli_real_escape_string($conn, $row['total_online_servers']).")";
        mysqli_query($conn, $q);
    } else {
        exit;
    }
}