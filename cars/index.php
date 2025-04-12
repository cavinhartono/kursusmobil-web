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
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Mobil") ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" id="addBtn" onclick="document.querySelector('#modalForm').style.display = 'block'">&plus;</button>
          <input type="text" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table>
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
              $id = $_GET['edit'];
              $res = mysqli_query($connect, "SELECT * FROM Cars WHERE id=$id");
              $editData = mysqli_fetch_assoc($res);
            }

            if (isset($_GET['delete'])) {
              $id = $_GET['edit'];
              $res = mysqli_query($connect, "DELETE Cars WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($car = mysqli_fetch_object($Cars)): ?>
                <tr>
                  <td><?= $car->id ?></td>
                  <td style="text-transform: capitalize"><?= $car->transmission ?></td>
                  <td><?= $car->name ?></td>
                  <td style="text-align: center;"><?= $car->created_at ?></td>
                  <td>
                    <a href="?edit=<?= $car->id ?>" onclick="document.querySelector('#modalForm').style.display = 'block'">Edit</a>
                    <a href="?delete=<?= $car->id ?>" class="btn danger">Delete</a>
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
  $fields = [
    ["type" => "text", "label" => "name", "title" => "Nama Mobil"],
    ["type" => "radio", "label" => "email", "title" => "Email"],
    ["type" => "text", "label" => "phone", "title" => "No. Telepon"],
  ];

  if (isset($_GET['edit'])) {
    $isEdit = isset($_GET['edit']);
    $action = $isEdit ? './update.php' : './store.php';
    $title  = $isEdit ? 'Edit Data Mobil' : 'Tambah Data Mobil';

    form($title, $fields, $editData, $action);
  }
  ?>

  <script>
    function toggleDropdown() {
      var dropdownContent = document.getElementById("dropdown-content");
      dropdownContent.style.display =
        dropdownContent.style.display === "block" ? "none" : "block";
    }

    function toggleSidebar() {
      var sidebar = document.querySelector(".sidebar");
      var content = document.querySelector(".content");
      sidebar.classList.toggle("collapsed");
      content.classList.toggle("collapsed");
    }
  </script>
</body>

</html>