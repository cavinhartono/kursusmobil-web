<!DOCTYPE html>
<html lang="en">

<?php
foreach (glob("../components/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All List Courses</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Kursus"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <a href="./create.php" class="btn primary">Tambah</a>
          <input type="text" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table>
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Nama Kursus</th>
                <th>Instruktur</th>
                <th style="text-align: right;">Durasi</th>
                <th style="text-align: right;">Harga</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>362379001</td>
                <td style="text-transform: capitalize;">Cavin Hartono</td>
                <td style="text-transform: capitalize;">cavin@gmail.com</td>
                <td style="text-align: right;">6 jam</td>
                <td style="text-transform: uppercase; text-align: right;">4 jam yang lalu</td>
                <td>4 jam yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="../assets/js/script.js"></script>
</body>

</html>