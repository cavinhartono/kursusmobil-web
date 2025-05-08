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
</head>

<body>
  <?php
  session_start();

  $i = 0;
  $fields = [
    ['name' => 'name', 'label' => 'Nama', 'type' => 'text'],
    ['name' => 'phone', 'label' => 'No. Telepon', 'type' => 'text'],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
    ['name' => 'password', 'label' => 'Password', 'type' => 'text'],
  ];
  modal('create', $fields, 'Instruktur');
  ?>

  <?php sidebar(); ?>
  <div class="content">
    <?php labelSidebar("Data Instruktur"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" onclick="openModal('createModal')"><ion-icon name="add"></ion-icon></button>
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
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("../database/connect.php");

            $Instructors = mysqli_query(
              $connect,
              "SELECT users.id, users.name, users.email, users.password, users.phone 
              FROM Instructors
              INNER JOIN Users ON Instructors.user_id = Users.id"
            );

            $editData = null;
            if (isset($_GET['edit'])) {
              $id = (int) $_GET['edit'];
              $data = mysqli_query($connect, "SELECT * FROM Users WHERE id=$id")->fetch_assoc();

              if ($data) {
                modal("update", $fields, "Instruktur", $id, $data);
                echo "<script>window.onload = () => openModal('updateModal$id');</script>";
              }
            }

            if (isset($_GET['delete'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Users WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($instructor = mysqli_fetch_object($Instructors)): ?>
                <tr>
                  <td><?= ++$i ?></td>
                  <td><?= $instructor->name ?></td>
                  <td><?= $instructor->email ?></td>
                  <td style="text-transform: lowercase;"><?= $instructor->phone ?></td>
                  <td>
                    <a href="?edit=<?= $instructor->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?delete=<?= $instructor->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
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