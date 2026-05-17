<?php
ob_implicit_flush(true);

include_once 'helpers/db/fetchKnownServers.php';
include_once 'helpers/db/insertVersionTrend.php';
include_once 'helpers/db/insertPlayerTrend.php';
include_once 'helpers/db/insertServerTrend.php';
include_once 'helpers/webhook/postWebhook.php';
include_once 'helpers/mc/writeVarInt.php';
include_once 'helpers/mc/readVarInt.php';
include_once 'helpers/mc/parseMotd.php';
include_once 'helpers/mc/pingMc.php';
include_once 'helpers/webhook/postWebhook.php';

echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Initializing Trends Crawler...".PHP_EOL;

$totalScans = 0;


while(true) {
    $table = fetchKnownServers();

    while($row = mysqli_fetch_assoc($table)) {
        $result = pingMc(long2ip($row['server_ip']));
        $totalScans++;

        if(!is_array($result) || !isset($result['version']['name'])) {
            echo "\033[1;42m\033[30m[Trends Crawler]:\033[0;34m Couldn't connect, Skipping...".PHP_EOL;
            continue;
        } else {
            echo "\033[1;42m\033[30m[Trends Crawler]:\033[0;34m \033[1;96mCurrent IP: \033[33m".$row['server_ip']." \033[39m| \033[35mCrawls: $totalScans".PHP_EOL;
            insertVersionTrend($result['version']['name']);
        }
    }

    insertPlayerTrend();
    insertServerTrend();

    postWebhook(
        "https://discord.com/api/webhooks/1456832621207355606/zIsGXNFt9Uql02vvtxlXqrPlETjYqWRqZo4kzHGQeDe39fr1cEesqo3XV6WIkBuh2jlv",
        "TMR Bot",
        "📸 Global Snapshot Taken!",
        "<@&1457933315658223658>\n\nGlobal snapshot of **" . date('Y-m-d') . "** has been taken!",
        "9b59b6",
        "Powered by TMR – https://tmr.mar.engineer/"
    );

    mysqli_free_result($table);
    echo "\033[1;42m\033[30m[Trends Crawler]:\033[0;33m Sleeping 24 Hours...".PHP_EOL;
    sleep(86400);
}