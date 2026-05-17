<?php

function ipInRange($ip, $cidr) {
    [$subnet, $mask] = explode('/', $cidr);
    $ipLong     = ip2long($ip);
    $subnetLong = ip2long($subnet);
    $maskLong   = -1 << (32 - $mask);

    return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
}

function generateIpv4() {
    $reserved = [
        '0.0.0.0/8',
        '10.0.0.0/8',
        '100.64.0.0/10',
        '127.0.0.0/8',
        '169.254.0.0/16',
        '172.16.0.0/12',
        '192.0.0.0/24',
        '192.0.2.0/24',
        '192.88.99.0/24',
        '192.168.0.0/16',
        '198.18.0.0/15',
        '198.51.100.0/24',
        '203.0.113.0/24',
        '224.0.0.0/4',
        '240.0.0.0/4',
        '255.255.255.255/32',
    ];

    while (true) {
        $ip = rand(1, 223) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 254);

        foreach ($reserved as $cidr) {
            if (ipInRange($ip, $cidr)) {
                continue 2;
            }
        }

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }
}