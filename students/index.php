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
  <title>All List Students</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Pengemudi") ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <input type="text" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table>
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="text-align: right;">No. Telepon</th>
                <th style="text-align: center;">Terakhir Diakses</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("../database/connect.php");

            $Students = mysqli_query($connect, "SELECT * FROM Students ORDER BY created_at DESC");
            ?>
            <tbody>
              <?php while ($student = mysqli_fetch_object($Students)): ?>
                <tr>
                  <td><?= $student->id ?></td>
                  <td><?= $student->name ?></td>
                  <td style="text-transform: lowercase;"><?= $student->email ?></td>
                  <td style="text-align: right;"><?= $student->phone ?></td>
                  <td style="text-align: center;"><?= $student->created_at ?></td>
                  <td>
                    <a href="?action=delete" class="btn danger">Delete</a>
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