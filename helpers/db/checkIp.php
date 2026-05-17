<?php

function checkIp($ip) {
    include 'helpers/db/dbh.php';

    $q = "SELECT ip FROM known_ips WHERE ip = ".mysqli_real_escape_string($conn, sprintf('%u', ip2long($ip)))." LIMIT 1";

    $table = mysqli_query($conn, $q);

    if(mysqli_num_rows($table) === 0) {
        echo "\033[1;2;5;90m[CraftBrute DATABASE]: DATABASE DETECTED UNKNOWN IP, CONTINUING PROCESS...\033[0m".PHP_EOL;
        return true;
    } else {
        echo "\033[1;2;5;90m[CraftBrute DATABASE]: DATABASE DETECTED KNOWN IP, SKIPPING...\033[0m".PHP_EOL;
        return false;
    }
}