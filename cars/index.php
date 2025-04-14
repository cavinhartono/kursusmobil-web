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
  <style>
    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      padding-top: 100px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: white;
      margin: auto;
      padding: 20px;
      width: 300px;
      border-radius: 5px;
      position: relative;
    }

    .modal-content input[type="radio"] {
      width: max-content;
    }

    .modal-content input {
      width: 100%;
      padding: 6px;
      margin-bottom: 10px;
    }

    .modal-close {
      position: absolute;
      top: 5px;
      right: 10px;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <?php
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
          <button class="btn-add" onclick="openModal('createModal')">+ Tambah Data</button>
          <input type="text" placeholder="Pencarian Nama">
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
                    <a href="?edit=<?= $car->id ?>">Edit</a>
                    <a href="?delete=<?= $car->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')">Delete</a>
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("searchInput").addEventListener("keyup", () => {
      const rows = document.querySelectorAll("#dataTable tbody tr");
      const keyword = this.value.toLowerCase();

      rows.forEach(row => {
        const cells = Array.from(row.getElementsByTagName("td"));
        const match = cells.some(td => td.textContent.toLowerCase().includes(keyword));
        row.style.display = match ? "" : "none";
      });
    });

    function openModal(id) {
      document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }

    window.onclick = function(event) {
      document.querySelectorAll('.modal').forEach(modal => {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      });
    }

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