<?php

function insertVersionTrend($version) {
    include 'dbh.php';

    $q = "SELECT version_name FROM version_trends WHERE version_name = '".mysqli_real_escape_string($conn, $version)."'";
    $table = mysqli_query($conn, $q);

    if(mysqli_num_rows($table) === 0) {
        $q = "SELECT COUNT(server_version) AS total_version_users FROM known_servers WHERE server_version = '".mysqli_real_escape_string($conn, $version)."'";
        $table = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($table);

        $total_version_users = $row['total_version_users'];

        $q = "INSERT INTO version_trends(version_name, version_amount) VALUES(
        '".mysqli_real_escape_string($conn, $version)."',
        '".mysqli_real_escape_string($conn, $total_version_users)."'
        )";
        mysqli_query($conn, $q);
        echo "\033[1;42m\033[30m[Trends Crawler]:\033[0;33m Added unknown version ($version)".PHP_EOL;
    } else {
        $currentDate = date('Y-m-d');
        $q = "SELECT time FROM version_trends WHERE time = '".mysqli_real_escape_string($conn, $currentDate)."'";
        $table = mysqli_query($conn, $q);

        if(mysqli_num_rows($table) === 0) {
            $q = "SELECT COUNT(server_version) AS total_version_users FROM known_servers WHERE server_version = '".mysqli_real_escape_string($conn, $version)."'";
            $table = mysqli_query($conn, $q);
            $row = mysqli_fetch_assoc($table);

            $total_version_users = $row['total_version_users'];

            $q = "UPDATE version_trends SET version_amount = '".mysqli_real_escape_string($conn, $total_version_users)."' WHERE version_name = '".mysqli_real_escape_string($conn, $version)."'";
            mysqli_query($conn, $q);
        }
        echo "\033[1;42m\033[30m[Trends Crawler]:\033[0;33m Updated version count. No records found on $currentDate about ($version)".PHP_EOL;
    }
}