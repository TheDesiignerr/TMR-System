<?php

function readVarInt($socket) {
    $numRead = 0;
    $result = 0;

    do {
        $byte = fread($socket, 1);
        if ($byte === false || $byte === '') {
            return null;
        }

        $value = ord($byte);
        $result |= ($value & 0x7F) << (7 * $numRead);

        $numRead++;
        if ($numRead > 5) {
            throw new Exception("VarInt too big");
        }
    } while (($value & 0x80) !== 0);

    return $result;
}
