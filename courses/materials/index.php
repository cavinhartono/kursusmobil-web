<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../../database/connect.php");

foreach (glob("../../components/*.php") as $file) {
  require $file;
}

$course_id = $_GET['id'];

$course = $connect->query("SELECT name, quiz_json FROM Courses WHERE id = $course_id")->fetch_object();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $course->name ?></title>
  <link rel="stylesheet" href="../../assets/css/dashboard/style.css" />
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Materi untuk $course->name"); ?>
    <div class="content-body">
      <div class="container">
        <div class="inputBx">
          <div style="display: flex; gap:8px">
            <a style="display: flex; align-items: center; gap: 8px" href="./create.php?id=<?= $course_id ?>" class="btn primary"><ion-icon name="add"></ion-icon> Materi</a>
            <a style="display: flex; align-items: center; gap: 8px" href="./../quiz/create.php?id=<?= $course_id ?>" class="btn primary"><ion-icon name="add"></ion-icon> Kuis</a>
            <?php if (empty($course->quiz_json)): ?>
              <a style="display: flex; align-items: center; gap: 8px" href="./../finalExam/create.php?id=<?= $course_id ?>" class="btn primary"><ion-icon name="add"></ion-icon> Ujian Praktek</a>
            <?php else: ?>
              <a style="display: flex; align-items: center; gap: 8px" href="./../finalExam/edit.php?id=<?= $course_id ?>" class="btn warning"><ion-icon name="pencil"></ion-icon> Ujian Praktek</a>
            <?php endif ?>
          </div>
          <input type="text" id="searchInput" placeholder=" Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th style="text-align: center;">Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            $Materials = $connect->query("SELECT * FROM Materials WHERE course_id = $course_id ORDER BY order_index ASC");

            if (isset($_GET['delete_material'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Materials WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($material = mysqli_fetch_object($Materials)): ?>
                <tr>
                  <td><?= $material->order_index ?></td>
                  <td><?= $material->title ?></td>
                  <td style="text-align: center;"><?= timeAgo($material->uploaded_at) ?></td>
                  <td>
                    <a href="edit.php?id=<?= $material->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?delete_material=<?= $material->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
                    <a href="view.php?id=<?= $course_id ?>&page=<?= $material->id ?>" class="btn primary"><ion-icon name="eye-outline"></ion-icon></a>
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="content-body" style="margin-top: 16px;">
      <div class="container">
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th style="text-align: center;">Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            $Quizzes = $connect->query("SELECT * FROM Quizzes WHERE course_id = $course_id ORDER BY order_index ASC");

            if (isset($_GET['delete_quiz'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Quizzes WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($quiz = mysqli_fetch_object($Quizzes)): ?>
                <tr>
                  <td><?= $quiz->order_index ?></td>
                  <td><?= $quiz->title ?></td>
                  <td style="text-align: center;"><?= timeAgo($quiz->created_at) ?></td>
                  <td>
                    <a href="../quiz/edit.php?id=<?= $quiz->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?delete_quiz=<?= $quiz->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
                    <a href="../quiz/index.php?id=<?= $quiz->id ?>" class="btn primary"><ion-icon name="eye-outline"></ion-icon></a>
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
      window.location.href = '../../dashboard.php';
    </script>
  <?php endif ?>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../../assets/js/script.js"></script>
</body>

</html>