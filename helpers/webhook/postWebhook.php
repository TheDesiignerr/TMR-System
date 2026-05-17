<?php

function postWebhook($url, $nick, $title, $desc, $color, $footer){
    $data = [
        "username" => $nick,
        "avatar_url" => "https://cdn.mar.engineer/tmr-logo.png",
        "embeds" => [[
            "title" => $title,
            "description" => $desc,
            "color" => hexdec($color),
            "footer" => [
                "text" => $footer,
                "icon_url" => "https://cdn.mar.engineer/tmr-logo.png"
            ]
        ]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
}