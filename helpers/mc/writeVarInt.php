<?php

function writeVarInt($value) {
    $out = '';
    while (true) {
        if (($value & ~0x7F) === 0) {
            $out .= chr($value);
            break;
        }
        $out .= chr(($value & 0x7F) | 0x80);
        $value >>= 7;
    }
    return $out;
}
