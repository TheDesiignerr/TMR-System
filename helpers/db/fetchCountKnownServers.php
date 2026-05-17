<?php

function fetchCountKnownServers() {
    include 'dbh.php';

    $q = "SELECT COUNT(*) AS total_known_servers FROM known_servers";
    $table = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($table);

    return $row['total_known_servers'];
}