<?php

$ZGJob3N0 = base64_decode('MTYxLjk3LjE2NC4yMTc=');
$ZGJ1c2Vy = base64_decode('Q3JhZnRCcnV0ZUNyYXdsZXI=');
$ZGJwYXNz = base64_decode('SGVzb3lhbUFlemFrbWlAMTk4MDAwMEBAQEA=');
$ZGJuYW1l = base64_decode('Q3JhZnRCcnV0ZURC');
$conn = '';

try {
    $conn = mysqli_connect($ZGJob3N0, $ZGJ1c2Vy, $ZGJwYXNz, $ZGJuYW1l);
} catch (mysqli_sql_exception) {
    echo "DATABASE CONNECTION NOT ESTABLISHED".PHP_EOL;
}
