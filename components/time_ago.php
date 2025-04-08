<?php
function timeAgo(string $datetime): string {
    date_default_timezone_set('Asia/Jakarta');
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    $units = [
        31536000 => 'tahun',
        2592000  => 'bulan',
        604800   => 'minggu',
        86400    => 'hari',
        3600     => 'jam',
        60       => 'menit',
        1        => 'detik'
    ];

    foreach ($units as $seconds => $label) {
        $value = floor($diff / $seconds);
        if ($value >= 1) {
            return "$value $label lalu";
        }
    }

    return 'baru saja';
}
