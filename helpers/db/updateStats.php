<?php


function updateStats() {
    include 'dbh.php';

    $dateYear = date('Y');
    $dateMonth = date('m');
    $dateDay = date('d');

    // ==========================================================================================================================================
    // Calculate Daily Crawls
    // ==========================================================================================================================================
    $q = "SELECT COUNT(*) AS crawlsToday FROM known_ips WHERE time LIKE '%$dateYear"."-"."$dateMonth"."-"."$dateDay%'";
    $table = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($table);

    $todayCrawls = $row['crawlsToday'];


    $q = "UPDATE stats SET total_today = ".$todayCrawls;
    mysqli_query($conn, $q);
    echo "\033[1;42m\033[30m[Stats Update]:\033[0;33m Updated Crawls Today to ".number_format($todayCrawls).PHP_EOL;

    // ==========================================================================================================================================
    // Calculate Total Crawls
    // ==========================================================================================================================================
    $q = "SELECT COUNT(*) AS total_crawls FROM known_ips";
    $table = mysqli_query($conn, $q);
    $row = mysqli_fetch_assoc($table);

    $totalCrawls = $row['total_crawls'];

    $q = "UPDATE stats SET total_ips = $totalCrawls";
    mysqli_query($conn, $q);
    echo "\033[1;42m\033[30m[Stats Update]:\033[0;33m Updated Crawls Total to ".number_format($totalCrawls).PHP_EOL;
}