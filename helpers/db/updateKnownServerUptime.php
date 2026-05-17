<?php

function updateKnownServerUptime($ip, $status) {
    include 'dbh.php';

    $q = "SELECT id FROM known_servers WHERE server_ip = '".mysqli_real_escape_string($conn, $ip)."' LIMIT 1";
    $table = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($table);
    $serverIdFromIp = $row['id'];

    if(empty($status) || $status === null) {
        $status = 'offline';
    }

    $q = "INSERT INTO server_uptime(server_id, server_status) VALUES(".$serverIdFromIp.",'".mysqli_real_escape_string($conn, $status)."')";
    mysqli_query($conn, $q);
}