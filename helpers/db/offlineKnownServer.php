<?php

function offlineKnownServer($ip) {
    include 'dbh.php';

    $q = "UPDATE known_servers SET server_status = 'offline' WHERE server_ip = $ip";
    mysqli_query($conn, $q);
}