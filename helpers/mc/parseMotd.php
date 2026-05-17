<?php

function parseMotd($motd, $maxLen = 512) {
    $out = '';

    $walk = function ($node) use (&$walk, &$out) {
        if (is_string($node)) {
            $out .= $node;
            return;
        }

        if (!is_array($node)) {
            return;
        }

        if (isset($node['text']) && is_string($node['text'])) {
            $out .= $node['text'];
        }

        if (isset($node['extra']) && is_array($node['extra'])) {
            foreach ($node['extra'] as $child) {
                $walk($child);
            }
        }
    };

    $walk($motd);

    $out = preg_replace('/\p{Z}+/u', ' ', $out);
    $out = preg_replace('/\s+/u', ' ', $out);

    $out = preg_replace('/[\x00-\x1F\x7F]/u', '', $out);

    $out = trim($out);
    if (mb_strlen($out, 'UTF-8') > $maxLen) {
        $out = mb_substr($out, 0, $maxLen, 'UTF-8');
    }

    return $out;
}
