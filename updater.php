<?php
ob_implicit_flush(true);

include_once 'helpers/db/tagIp.php';
include_once 'helpers/db/updateStats.php';
include_once 'helpers/db/updateKnownServer.php';
include_once 'helpers/db/offlineKnownServer.php';
include_once 'helpers/db/fetchKnownServers.php';
include_once 'helpers/db/fetchCountKnownServers.php';
include_once 'helpers/mc/writeVarInt.php';
include_once 'helpers/mc/readVarInt.php';
include_once 'helpers/mc/parseMotd.php';
include_once 'helpers/mc/pingMc.php';
include_once 'helpers/webhook/postWebhook.php';

echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Initializing Updater...".PHP_EOL;

updateStats();

$totalScans = 0;


while(true) {
    $table = fetchKnownServers();

    while($row = mysqli_fetch_assoc($table)) {
        $result = pingMc(long2ip($row['server_ip']));
        $totalScans++;

        if(!is_array($result) || !isset($result['players']['online']) || !isset($result['players']['max']) || !isset($result['description'])) {
            echo "\033[1;42m\033[30m[Update Crawler]:\033[0;34m Couldn't connect, Skipping...".PHP_EOL;
            offlineKnownServer($row['server_ip']);
            continue;
        } else {
            echo "\033[1;42m\033[30m[Update Crawler]:\033[0;34m \033[1;96mCurrent IP: \033[33m".$row['server_ip']." \033[39m| \033[35mScans: $totalScans".PHP_EOL;
            updateKnownServer(
            $row['server_ip'],
            $result['players']['online'],
            $result['players']['max'],
            parseMotd($result['description']),
            'online'
            );
        }
    }

    $totalServerCount = fetchCountKnownServers();

    postWebhook(
        "https://discord.com/api/webhooks/1461129649835741245/P5U2EusFf2IymCpK1iEcrzQqBdxrrhZmqfENA7vSBztTdMWCfbGMJ812ijY4v6UWWS0N",
        "🔄 TMR Updater",
        "✅ Update Cycle Completed",
        "**Server Data Update**
        📊 Finished recrawling ".number_format($totalServerCount)." known servers and updating their data",
        "2979ff",
        "⚙️ TMR Infrastructure • Updater System"
    );


    mysqli_free_result($table);
    echo "\033[1;42m\033[30m[Update Crawler]:\033[0;33m Sleeping 8 Hours...".PHP_EOL;
    sleep(28800);
}