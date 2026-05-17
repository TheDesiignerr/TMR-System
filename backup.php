<?php
ob_implicit_flush(true);
pcntl_async_signals(true);

echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;33m Initializing...".PHP_EOL;

$tableMap = [
    // 'known_ips',
    'known_servers',
    'player_population',
    'server_uptime',
    'version_trends',
    'player_trends',
    'server_trends'
];

echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;32m Table Map Loaded!".PHP_EOL;
echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;33m Backup started...".PHP_EOL;
mkdir('BACKUP');

foreach($tableMap as $table) {
    shell_exec('mysqldump -h 127.0.0.1 -u mar -proot CraftBruteDB '.$table.' > BACKUP/'.$table.'_'.date('Y-m-d').'.sql');
    echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;32m $table Backed up!".PHP_EOL;
     shell_exec('chown mar:mar '.$table.'_'.date('Y-m-d').'.sql');
     echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;32m $table Permissioned!".PHP_EOL;
}

echo "\033[1;42m\033[30m[BACKUP MANAGER]:\033[0;32m Done.".PHP_EOL;
