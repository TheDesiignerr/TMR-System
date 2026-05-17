<?php
ob_implicit_flush(true);
pcntl_async_signals(true);

include_once 'helpers/db/checkIp.php';
include_once 'helpers/db/burnIp.php';
include_once 'helpers/db/tagIp.php';
include_once 'helpers/ip/generateIpv4.php';
include_once 'helpers/mc/writeVarInt.php';
include_once 'helpers/mc/readVarInt.php';
include_once 'helpers/mc/parseMotd.php';
include_once 'helpers/mc/pingMc.php';

echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Initializing...".PHP_EOL;

$totalScans = 0;

while(true) {
    $ip = generateIpv4();

    if(checkIp($ip) === false) {
        continue;
    }

    $result = pingMc($ip);
    $totalScans++;

    if($result === false || $result === null) {
        echo "\033[1;42m\033[30m[CraftBrute]:\033[0;34m [Status] --> \033[1;96mCurrent IP: \033[33m$ip \033[39m| \033[35mScans: $totalScans".PHP_EOL;
        burnIp($ip);
    } else {
        echo "\033[1;42m\033[30m[CraftBrute]:\033[0;34m [Status] --> \033[1;96mCurrent IP: \033[33m$ip \033[39m| \033[35mScans: $totalScans".PHP_EOL;
        tagIp(
        $ip,
        $result['version']['name'],
        $result['players']['online'],
        $result['players']['max'],
        parseMotd($result['description'])
        );
    }
    $sleep = rand(1, 7);
    echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Sleeping $sleep seconds for stealth...".PHP_EOL;
    sleep($sleep);
}