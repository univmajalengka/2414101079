<?php

function hitungDiskon($totalBelanja)
{
    if ($totalBelanja >= 100000) {
        $diskon = $totalBelanja * 0.10;
    } elseif ($totalBelanja >= 50000 && $totalBelanja < 100000) {
        $diskon = $totalBelanja * 0.05;
    } else {
        $diskon = 0;
    }

    return $diskon;
}

$totalBelanja = 20000;

$diskon = hitungDiskon($totalBelanja);

$totalBayar = $totalBelanja - $diskon;

echo "Total Belanja : Rp " . number_format($totalBelanja, 0, ',', '.') . "<br>";
echo "Diskon        : Rp " . number_format($diskon, 0, ',', '.') . "<br>";
echo "Total Bayar   : Rp " . number_format($totalBayar, 0, ',', '.');