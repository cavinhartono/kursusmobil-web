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
                <th style="text-align: right; width:max-content">Durasi</th>
                <th style="text-align: right;">Harga</th>
                <th style="text-align: center;">Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("../database/connect.php");

            $Courses = mysqli_query($connect, "SELECT * FROM Courses ORDER BY created_at DESC");
            ?>
            <tbody>
              <?php while ($course = mysqli_fetch_object($Courses)): ?>
                <tr>
                  <td><?= $course->id ?></td>
                  <td style="text-transform: capitalize; width:100%"><?= $course->name ?></td>
                  <td style="text-align: right;"><?= $course->duration ?> jam</td>
                  <td style="text-transform: uppercase; text-align: right;"><?= number_format($course->price, 0, ".", ".") ?> IDR</td>
                  <td style="text-align: center;"><?= $course->created_at ?></td>
                  <td>
                    <a href="?action=edit">Edit</a>
                    <a href="?action=delete">Delete</a>
                  </td>
                </tr>
              <?php endwhile ?>
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