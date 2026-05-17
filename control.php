<?php

include_once 'helpers/webhook/postWebhook.php';

$flag = @strtolower($argv[1]);

if(empty($flag)) {
    echo "\033[1;42m\033[30mCraftBrute Controler\033[0;30m
    \033[0;33m [Usage]: 
        - spawn <type|crawler|updater> <amount>
        - loop <delay>
        - cruise <amount>
        - despawn".PHP_EOL;
    exit;
} else {
    if($flag === 'spawn') {
        $type = strtolower($argv[2]);
        $amount = (int)$argv[3];
        
        if($type === 'crawler') {
            echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Started Spawner...".PHP_EOL;
            $spawnedCrawlers = 0;

            while(true) {
                $spawnedCrawlers++;
                if($spawnedCrawlers === (int)$amount+1) {
                    exit;
                    break;
                }else{
                    echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Crawler $spawnedCrawlers Spawned!".PHP_EOL;
                    shell_exec('php crawler.php > /dev/null 2>&1 &').PHP_EOL;
                }
                usleep(350000);
            }
        }

        if(strtolower($type) === 'updater') {
            echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Started Spawner...".PHP_EOL;
            $spawnedCrawlers = 0;

            while(true) {
                $spawnedCrawlers++;
                if($spawnedCrawlers === (int)$amount+1) {
                    exit;
                    break;
                }else{
                    echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Updater Crawler $spawnedCrawlers Spawned!".PHP_EOL;
                    shell_exec('php updater.php > /dev/null 2>&1 &').PHP_EOL;
                }
                usleep(350000);
            }
        }
    } elseif ($flag === 'despawn') {
        echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Killed all crawlers".PHP_EOL;
        shell_exec('pkill -f "php crawler.php"');
    } elseif ($flag === 'loop') {
        echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Started Looper...".PHP_EOL;
        $delay = (int)$argv[2];

        while(true) {
            echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Crawler Spawned!".PHP_EOL;
            shell_exec('php crawler.php > /dev/null 2>&1 &').PHP_EOL;
            echo "\033[1;42m\033[30m[CraftBrute]:\033[0;33m Sleeping $delay seconds...".PHP_EOL;
            sleep($delay);
        }
    } elseif ($flag === 'cruise') {
        $cap = (int)$argv[2];
        
        while (true) {
            $crawlerCount = (int) trim(shell_exec('pgrep -fc "php crawler.php"'));
        
            echo "\033[1;44m\033[37m CraftBrute Controller \033[1;30m\033[49m "
               . "\033[1;33mCRUISE MODE\033[39m "
               . "\033[96mMaintaining {$cap} Crawlers. Running: {$crawlerCount}\033[39m\n";

            postWebhook(
                "https://discord.com/api/webhooks/1461129649835741245/P5U2EusFf2IymCpK1iEcrzQqBdxrrhZmqfENA7vSBztTdMWCfbGMJ812ijY4v6UWWS0N",
                "🚢 TMR Cruiser",
                "✅ Tick Adjustment Completed",
                "**Cruiser Summary**
                🕷️ **Active Crawlers:** `{$crawlerCount}`
                📍 **Final Offset:** `".($cap - $crawlerCount)."`
                🧢 **Crawler Cap:** `{$cap}`",
                "0048ff",
                "⚙️ TMR Infrastructure • Cruiser System"
            );

            if ($crawlerCount < $cap) {
                $toSpawn = $cap - $crawlerCount;
            
                for ($i = 0; $i < $toSpawn; $i++) {
                    shell_exec('php crawler.php > /dev/null 2>&1 &');
                    echo "\033[1;44m\033[37m CraftBrute Controller \033[1;30m\033[49m "
                    . "\033[1;33mCRUISE MODE\033[39m "
                    . "\033[96mAdjusting Tick... \033[35mOffset: \033[95m".$toSpawn - $i." \033[32mCrawlers: \033[92m".($crawlerCount + $i + 1)."\033[39m\n";
                    $i + 1;
                    sleep(1);
                }
            }
        
            echo "\033[1;44m\033[37m CraftBrute Controller \033[1;30m\033[49m "
               . "\033[1;33mCRUISE MODE\033[39m "
               . "\033[96mSleeping 60 Seconds...\033[39m\n";
            sleep(60);
        }
    } else {
        echo "\033[1;42m\033[30mCraftBrute Controler\033[0;30m
        \033[0;33m [Usage]: 
            - spawn <type|crawler|updater> <amount>
            - loop <delay>
            - cruise <amount>
            - despawn".PHP_EOL;
        exit;
    }
}
