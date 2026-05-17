<?php

function burnIp($ip) {
    include 'helpers/db/dbh.php';

    $q = "INSERT INTO known_ips(ip) VALUES(".mysqli_real_escape_string($conn, sprintf('%u', ip2long($ip))).")";
    mysqli_query($conn, $q);
}