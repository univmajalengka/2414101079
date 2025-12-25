<?php
function hitungDiskon($totalBelanja)
{
    if ($totalBelanja >= 100000) {
        return $totalBelanja * 0.10;
    } elseif ($totalBelanja >= 50000 && $totalBelanja < 100000) {
        return $totalBelanja * 0.05;
    } else {
        return 0;
    }
}

$totalBelanja = 0;
$diskon = 0;
$totalBayar = 0;

if (isset($_POST['totalBelanja'])) {
    $totalBelanja = (int) $_POST['totalBelanja'];
    $diskon = hitungDiskon($totalBelanja);
    $totalBayar = $totalBelanja - $diskon;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perhitungan Diskon</title>
</head>
<body>

<h3>Input Total Belanja</h3>

<form method="post">
    <label>Total Belanja (Rp): </label><br>
    <input type="number" name="totalBelanja" required>
    <br><br>
    <button type="submit">Hitung</button>
</form>

<?php if ($totalBelanja > 0): ?>
    <hr>
    Total Belanja : Rp <?= number_format($totalBelanja, 0, ',', '.') ?><br>
    Diskon : Rp <?= number_format($diskon, 0, ',', '.') ?><br>
    Total Bayar : Rp <?= number_format($totalBayar, 0, ',', '.') ?>
<?php endif; ?>

</body>
</html>
