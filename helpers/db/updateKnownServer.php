<?php

function updateKnownServer($ip, $online, $max, $motd, $status) {
    include 'dbh.php';

    $q = "UPDATE known_servers SET server_online = $online, server_max = $max, server_motd = '".mysqli_real_escape_string($conn, $motd)."', server_status = '$status', last_seen = CURRENT_TIMESTAMP WHERE server_ip = $ip";
    mysqli_query($conn, $q);
}