<!DOCTYPE html>
<html lang="en">

<?php
session_start();
foreach (glob("../components/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/dashboard/style.css">
  <title>Laporan</title>
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Laporan"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <div class="fillter" style="display: flex; gap: 8px">
            <input type="date" id="calender">
            <button type="button" onclick="getReport()" class="btn primary">Cari</button>
          </div>
          <input type="text" id="searchInput" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Kursus</th>
                <th>Pengemudi</th>
                <th style="text-align: center">Tanggal</th>
              </tr>
            </thead>
            <tbody id="display"></tbody>
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
  <script>
    function getReport() {
      fetch("filter_data.php", {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "calender=" + encodeURIComponent(document.querySelector("#calender").value)
        })
        .then(response => response.text())
        .then(result => {
          document.querySelector("#display").style.display = "table-header-group";
          document.querySelector("#display").innerHTML = result;
        })
        .catch(error => console.error(error));
    }
  </script>
</body>

</html>