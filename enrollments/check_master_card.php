<?php
include_once("../database/connect.php");

$serial_number = $_POST['code'];

$Card = mysqli_query(
  $connect,
  "SELECT * FROM Master_Cards
    WHERE serial_number = '$serial_number'"
)->fetch_object();

?>

<?php if (!empty($Card)): ?>
  <p class="text">Kartu ID: <?= $Card->serial_number ?> </p>
  <p class="text">Nama Pemilik Kartu ID: <span style="text-transform: uppercase;"><?= $Card->name ?></span> </p>
  <p class="text">Jumlah Saldo yang Dimiliki: <?= number_format($Card->balance, 0, ".", ".") ?> IDR </p>
<?php endif ?>