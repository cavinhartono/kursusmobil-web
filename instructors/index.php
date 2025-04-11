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
  <?php sidebar(); ?>
  <div class="content">
    <?php labelSidebar("Data Instruktur"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" onclick="document.querySelector('#modalForm').style.display = 'block'">&plus;</button>
          <input type="text" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telpon</th>
                <th>Terakhir Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("../database/connect.php");

            $Instructors = mysqli_query($connect, "SELECT * FROM Instructors ORDER BY created_at DESC");
            ?>
            <tbody>
              <?php while ($instructor = mysqli_fetch_object($Instructors)): ?>
                <tr>
                  <td><?= $instructor->id ?></td>
                  <td><?= $instructor->name ?></td>
                  <td><?= $instructor->email ?></td>
                  <td style="text-transform: lowercase;"><?= $instructor->phone ?></td>
                  <td><?= timeAgo($instructor->created_at) ?></td>
                  <td>
                    <a href="?action=edit&id=<?= $instructor->id ?>">Edit</a>
                    <a href="?action=delete&id=<?= $instructor->id ?>">Delete</a>
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
    ["type" => "text", "label" => "name", "title" => "Nama Lengkap"],
    ["type" => "email", "label" => "email", "title" => "Email"],
    ["type" => "text", "label" => "phone", "title" => "No. Telepon"],
  ];
  ?>

  <?php form("Tambah Data Instruktur", $fields) ?>

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