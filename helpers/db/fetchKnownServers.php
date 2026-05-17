<?php

function fetchKnownServers() {
    include 'dbh.php';

    $q = "SELECT * FROM known_servers";
    $table = mysqli_query($conn, $q);

    return $table;
}