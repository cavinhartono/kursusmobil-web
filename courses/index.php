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
  <?php
  session_start();
  $fields = [
    ['name' => 'name', 'label' => 'Nama', 'type' => 'text'],
    ['name' => 'duration', 'label' => 'Durasi', 'type' => 'number'],
    ['name' => 'price', 'label' => 'Harga', 'type' => 'number'],
  ];
  modal('create', $fields, 'Kursus');
  ?>

  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Kursus"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" onclick="openModal('createModal')"><ion-icon name="add"></ion-icon></button>
          <input type="text" id="searchInput" placeholder=" Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
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

            $editData = null;
            if (isset($_GET['edit'])) {
              $id = (int) $_GET['edit'];
              $data = mysqli_query($connect, "SELECT * FROM Courses WHERE id=$id")->fetch_assoc();

              if ($data) {
                modal("update", $fields, "Kursus", $id, $data);
                echo "<script>window.onload = () => openModal('updateModal$id');</script>";
              }
            }

            if (isset($_GET['delete'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Courses WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($course = mysqli_fetch_object($Courses)): ?>
                <tr>
                  <td><?= $course->id ?></td>
                  <td style="text-transform: capitalize; width:100%"><?= $course->name ?></td>
                  <td style="text-align: right;"><?= $course->duration ?> jam</td>
                  <td style="text-transform: uppercase; text-align: right;"><?= number_format($course->price, 0, ".", ".") ?> IDR</td>
                  <td style="text-align: center;"><?= timeAgo($course->created_at) ?></td>
                  <td>
                    <a href="?edit=<?= $course->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?delete=<?= $course->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
                    <a href="materials/index.php?id=<?= $course->id ?>">Materi</a>
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