<?php

foreach (glob("./components/*.php") as $file) {
  require $file;
}

include_once("./database/connect.php");

$i = 0;
$Transactions = $connect->query("SELECT Courses.Name AS 'course', Users.name AS 'username', payments.method AS 'method_type', Payments.Total AS 'total_price', Orders.Status AS 'status', paid_at FROM payments
                                JOIN orders ON payments.order_id
                                JOIN Users ON Orders.user_id = Users.id
                                JOIN Courses ON Orders.course_id = courses.id
                                ORDER BY status DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mantau Transaksi</title>
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <input type="text" id="searchInput" placeholder="Pencarian Nama">
        </div>
        <?php labelSidebar("Mantau Transaksi"); ?>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <th>#</th>
              <th>Kursus</th>
              <th>Pengemudi</th>
              <th>Metode Pembayaran</th>
              <th>Total</th>
              <th>Status</th>
              <th>Dibayar</th>
            </thead>
            <tbody>
              <?php while ($transaction = mysqli_fetch_object($Transactions)): ?>
                <tr>
                  <td><?= ++$i ?></td>
                  <td><?= $transaction->course ?></td>
                  <td><?= $transaction->username ?></td>
                  <td><?= $transaction->method_type ?></td>
                  <td><?= number_format($transaction->total_price, 0, '.', '.') ?> IDR</td>
                  <td>
                    <span class="status <?= $transaction->status === 'paid' ? 'success' : 'warning' ?>">
                      <?= $transaction->status === 'paid' ? "Success" : $transaction->status ?>
                    </span>
                  </td>
                  <td><?= timeAgo($transaction->paid_at) ?></td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php if ($_SESSION['roles'] !== 'admin'): ?>
    <script>
      alert('Anda bukan Admin');
      window.location.href = '../dashboard.php';
    </script>
  <?php endif ?>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>