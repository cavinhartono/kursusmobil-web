<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../database/connect.php");

foreach (glob("../components/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/dashboard/style.css">
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Penilaian Pengemudi"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <input type="text" id="searchInput" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Kursus</th>
                <th>Instruktur</th>
                <th>Hasil</th>
                <th>Tanggal Diterbitkan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $my_certificate = $connect->query("SELECT cer.id AS id_certificate, Instructors.id AS instructor_id, Instructors.name AS instructor_name, c.id AS course_id, c.name AS course_name, cer.final_result, cer.created_at FROM Certifications cer
                                                INNER JOIN Enrollments e ON cer.enrollment_id = e.id
                                                INNER JOIN Users Students ON e.student_id = students.id
                                                INNER JOIN Users Instructors ON Instructors.id = cer.instructor_id AND Instructors.roles = 'instructor'
                                                INNER JOIN courses c ON e.course_id = c.id
                                                WHERE e.student_id = $_SESSION[auth] AND `status` = 'success'
                                                ORDER BY created_at DESC");
              $i = 0;
              ?>
              <?php while ($certificate = mysqli_fetch_object($my_certificate)): ?>
                <tr>
                  <td><?= ++$i ?></td>
                  <td><?= $certificate->course_name ?></td>
                  <td><?= $certificate->instructor_name ?></td>
                  <td><?= $certificate->final_result ?></td>
                  <td><?= date("F Y", strtotime($certificate->created_at)) ?></td>
                  <td><a href="./index.php?download=active&user=<?= $_SESSION['auth'] ?>&instructor=<?= $certificate->instructor_id ?>&course=<?= $certificate->course_id ?>&certificated=<?= $certificate->id_certificate ?>" class="btn primary"><ion-icon name="download-outline"></ion-icon></a></td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>