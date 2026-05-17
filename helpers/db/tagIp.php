<?php

function tagIp($ip, $version, $online, $max, $motd) {
    include 'helpers/db/dbh.php';
    include_once 'helpers/webhook/postWebhook.php';

    $q = "SELECT server_ip FROM known_servers WHERE server_ip = ".mysqli_real_escape_string($conn, sprintf('%u', ip2long($ip)))." LIMIT 1";
    $table = mysqli_query($conn, $q);

    if(mysqli_num_rows($table) === 0) {
        $q = "INSERT INTO known_servers(server_ip, server_version, server_online, server_max, server_motd, server_status)
        VALUES (
            ".mysqli_real_escape_string($conn, sprintf('%u', ip2long($ip))).",
            '".mysqli_real_escape_string($conn, $version)."',
            '".mysqli_real_escape_string($conn, $online)."',
            '".mysqli_real_escape_string($conn, $max)."',
            '".mysqli_real_escape_string($conn, $motd)."',
            'online'
        )";
        mysqli_query($conn, $q);
        postWebhook(
            "https://discord.com/api/webhooks/1456832621207355606/zIsGXNFt9Uql02vvtxlXqrPlETjYqWRqZo4kzHGQeDe39fr1cEesqo3XV6WIkBuh2jlv",
            "TMR Bot",
            "🆕 New Minecraft Server Discovered!",
            "**Decimal:** `".sprintf('%u', ip2long($ip))."`\n**IP:** `$ip`\n**Version:** `$version`\n**Online Players:** `$online`\n**MOTD:** `$motd`",
            "57F287",
            "Powered by TMR – https://tmr.mar.engineer/"
        );
        echo "\033[1;2;5;32m[CraftBrute DATABASE]: DATABASE TAGGED MINECRAFT IP.\033[0m".PHP_EOL;
    } else {
        echo "\033[1;52;;32m[CraftBrute DATABASE]: DATABASE SKIPPED TAGGING, ALREADY EXISITS...\033[0m".PHP_EOL;
        postWebhook(
            "https://discord.com/api/webhooks/1456832621207355606/zIsGXNFt9Uql02vvtxlXqrPlETjYqWRqZo4kzHGQeDe39fr1cEesqo3XV6WIkBuh2jlv",
            "TMR Bot",
            "⚠️ Server Already Indexed",
            "**Decimal:** `".sprintf('%u', ip2long($ip))."`\n**IP:** `$ip`\n**Version:** `$version`\n**Online Players:** `$online`",
            "FAA61A",
            "TMR keeps track of this server – https://tmr.mar.engineer/"
        );
    }
}