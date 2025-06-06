<?php

include_once("../database/connect.php");

$course_id = isset($_GET['id']);
$user_id = empty($_SESSION['auth']) ? header("Location: ../auth/login.php") : $_SESSION['auth'];

$User = mysqli_query(
  $connect,
  "SELECT name, email, phone 
    FROM Users 
    WHERE id = $_SESSION[auth]"
)->fetch_object();

$Course = mysqli_query(
  $connect,
  "SELECT name, price 
    FROM Courses
    WHERE id = $course_id"
)->fetch_object();

$connect->query(
  "INSERT INTO Orders(user_id, course_id) VALUES ($user_id, $course_id)"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/landing_page/enrollment/style.css">
  <title>Metode Pembelian</title>
</head>

<body style="display: grid; place-content: center; min-height: 100vh">
  <div class="container pay" style="box-shadow: 0px 8px 45px rgba(34, 34, 34, 0.1);">
    <h1>Metode Pembayaran</h1>
    <p>Nama: <?= $Course->name ?></p>
    <p>Harga: <?= number_format($Course->price, 0, "", ".") ?></p>
    <h1>
      Pengemudi
    </h1>
    <p>Nama: <?= $User->name ?></p>
    <p>Email: <?= $User->email ?></p>
    <p>Nomor Telepon: <?= $User->phone ?></p>
    <div id="display" style="display: none;"></div>
    <form method="POST" action="pay.php">
      <input type="hidden" name="user_id" value="<?= $user_id ?>">
      <input type="hidden" name="course_id" value="<?= $course_id ?>">
      <select name="metode" id="metode" onchange="toggleMetode()" required>
        <option value="">-- Pilih --</option>
        <option value="debit">Kartu Debit</option>
        <option value="qris">QRIS</option>
      </select>

      <div id="debit" style="display:none;">
        <label>Masukan Kartu ID<sup>*</sup>:</label>
        <div class="action">
          <input type="text" id="code" name="code" required>
          <button type="button" onclick="getPayment()">Cari</button>
        </div>
        <button type="submit" name="create">Beli</button>
      </div>

      <div id="qris" style="display: none;">
        <?php $url = "192.168.43.45:8001/enrollments/pay.php?user_id=$_SESSION[auth]&price=$Course->price&course_id=$course_id&method=qris" ?>
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($url) ?>&size=250x250">
      </div>
    </form>
  </div>

  <script>
    function getPayment() {
      fetch("check_master_card.php", {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "code=" + encodeURIComponent(document.querySelector("#code").value)
        })
        .then(response => response.text())
        .then(result => {
          document.querySelector("#display").style.display = "block";
          document.querySelector("#display").innerHTML = result;
        })
        .catch(error => console.error(error));
    }

    function toggleMetode() {
      var metode = document.getElementById('metode').value;
      document.getElementById('qris').style.display = metode === 'qris' ? 'flex' : 'none';
      document.getElementById('debit').style.display = metode === 'debit' ? 'block' : 'none';
    }
  </script>
</body>

</html>