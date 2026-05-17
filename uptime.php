<?php
ob_implicit_flush(true);

include_once 'helpers/db/fetchKnownServers.php';
include_once 'helpers/db/fetchCountKnownServers.php';
include_once 'helpers/db/updateKnownServerUptime.php';
include_once 'helpers/mc/writeVarInt.php';
include_once 'helpers/mc/readVarInt.php';
include_once 'helpers/mc/parseMotd.php';
include_once 'helpers/mc/pingMc.php';
include_once 'helpers/webhook/postWebhook.php';

echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Initializing Uptime Crawler...".PHP_EOL;

$totalScans = 0;


while(true) {
    $table = fetchKnownServers();

    while($row = mysqli_fetch_assoc($table)) {
        $result = pingMc(long2ip($row['server_ip']));
        $totalScans++;

        if(!is_array($result)) {
            echo "\033[1;42m\033[30m[Uptime Cralwer]:\033[0;34m Couldn't connect, Updating to offline...".PHP_EOL;
            updateKnownServerUptime(
            $row['server_ip'],
            'offline'
            );
            continue;
        } else {
            echo "\033[1;42m\033[30m[Uptime Crawler]:\033[0;34m \033[1;96mCurrent IP: \033[33m".$row['server_ip']." \033[39m| \033[35mCrawls: $totalScans".PHP_EOL;
            updateKnownServerUptime(
            $row['server_ip'],
            'online'
            );
        }
    }

    $totalServerCount = fetchCountKnownServers();

    postWebhook(
        "https://discord.com/api/webhooks/1461129649835741245/P5U2EusFf2IymCpK1iEcrzQqBdxrrhZmqfENA7vSBztTdMWCfbGMJ812ijY4v6UWWS0N",
        "⏱️ TMR Uptime",
        "✅ Uptime Crawl Completed",
        "**Uptime Report**
        📊 Finished crawling total uptime of ".number_format($totalServerCount)." servers",
        "00c853",
        "⚙️ TMR Infrastructure • Uptime System"
    );

    mysqli_free_result($table);
    echo "\033[1;42m\033[30m[Uptime Crawler]:\033[0;33m Sleeping 12 Hours...".PHP_EOL;
    sleep(43200);
}