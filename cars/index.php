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
  <title>All List Cars</title>
  <link rel="stylesheet" href="../assets/css/dashboard/style.css" />
</head>

<body>
  <?php
  session_start();

  $fields = [
    ['name' => 'name', 'label' => 'Nama', 'type' => 'text'],
    ['name' => 'transmission', 'label' => 'Transmisi (Matic/Manual)', 'type' => 'radio', 'options' => ['automatic', 'manual']],
  ];
  modal('create', $fields, 'Mobil');
  ?>

  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Mobil") ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" onclick="openModal('createModal')"><ion-icon name="add"></ion-icon></button>
          <input type="text" id="searchInput" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Transmisi</th>
                <th>Nama</th>
                <th style="text-align: center;">Terakhir Diakses</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("../database/connect.php");

            $Cars = mysqli_query($connect, "SELECT * FROM Cars ORDER BY created_at DESC");

            $editData = null;
            if (isset($_GET['edit'])) {
              $id = (int) $_GET['edit'];
              $data = mysqli_query($connect, "SELECT * FROM Cars WHERE id=$id")->fetch_assoc();

              if ($data) {
                modal("update", $fields, "Mobil", $id, $data);
                echo "<script>window.onload = () => openModal('updateModal$id');</script>";
              }
            }

            if (isset($_GET['delete'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Cars WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($car = mysqli_fetch_object($Cars)): ?>
                <tr>
                  <td><?= $car->id ?></td>
                  <td style="text-transform: capitalize"><?= $car->transmission ?></td>
                  <td><?= $car->name ?></td>
                  <td style="text-align: center;"><?= timeAgo($car->created_at) ?></td>
                  <td>
                    <a href="?edit=<?= $car->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?delete=<?= $car->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
                  </td>
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