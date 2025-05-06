<!DOCTYPE html>
<html lang="en">

<?php
session_start();

foreach (glob("components/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/dashboard/style.css">
  <title>Dashboard</title>
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Dashboard") ?>
    <div class="content-body">
      <div class="container">
        <div class="inputBx">
          <input type="text" placeholder="Pencarian Nama" id="searchInput">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            include_once("database/connect.php");

            $Courses = $connect->query(
              "SELECT Courses.id, Courses.name, Enrollments.is_completed 
              FROM Enrollments
              INNER JOIN Users ON Enrollments.student_id = Users.id
              INNER JOIN Courses ON Enrollments.course_id = Courses.id
              WHERE student_id = $_SESSION[auth]"
            );
            $i = 0;
            ?>
            <tbody>
              <?php if (!empty($Courses)): ?>
                <?php while ($course = $Courses->fetch_object()): ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $course->name ?></td>
                    <td><?= $course->is_completed == 1 ? "Selesai" : "Belum Tuntas" ?></td>
                    <td>
                      <a href="courses/learn.php?id=<?= $course->id ?>" class="btn primary">Pelajari</a>
                    </td>
                  </tr>
                <?php endwhile ?>
              <?php else: ?>
                <p>Tidak ada kursus.</p>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/script.js"></script>
</body>

</html>