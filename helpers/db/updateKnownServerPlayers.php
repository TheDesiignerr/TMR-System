<?php

function updateKnownServerPlayers($ip, $online) {
    include 'dbh.php';

    $q = "SELECT id FROM known_servers WHERE server_ip = ".mysqli_real_escape_string($conn, $ip)." LIMIT 1";
    $table = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($table);
    $serverIdFromIp = $row['id'];

    if(empty($online) || $online === null) {
        $online = 0;
    }

    $q = "INSERT INTO player_population(server_id, server_players) VALUES(".$serverIdFromIp.",'".mysqli_real_escape_string($conn, $online)."')";
    mysqli_query($conn, $q);

}