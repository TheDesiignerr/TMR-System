<?php

function pingMc($ip, $port = 25565, $timeout = 3) {
    $sock = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if (!$sock) return false;

    stream_set_timeout($sock, $timeout);

    // Handshake
    $handshake =
        writeVarInt(0x00) .          // packet id
        writeVarInt(762) .           // protocol (1.21.x safe)
        writeVarInt(strlen($ip)) . $ip .
        pack('n', $port) .
        writeVarInt(1);              // status

    fwrite($sock, writeVarInt(strlen($handshake)) . $handshake);

    // Status request
    fwrite($sock, writeVarInt(1) . writeVarInt(0));

    // Read response (PROPERLY)
    $packetLength = readVarInt($sock);
    if ($packetLength === null) return false;

    $packetId = readVarInt($sock);
    if ($packetId !== 0x00) return false;

    $jsonLength = readVarInt($sock);
    if ($jsonLength <= 0) return false;

    $json = '';
    while (strlen($json) < $jsonLength) {
        $json .= fread($sock, $jsonLength - strlen($json));
    }

    fclose($sock);

    return json_decode($json, true);
}