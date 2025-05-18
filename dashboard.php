<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("database/connect.php");

foreach (glob("components/*.php") as $file) {
  require $file;
}

$is_admin = $_SESSION['roles'] === 'admin' ? TRUE : FALSE;
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
      <?php if ($is_admin): ?>
        <?php
        $students = $connect->query("SELECT COUNT(name) AS total FROM Users WHERE roles = 'student'")->fetch_object()->total;
        $instructors = $connect->query("SELECT COUNT(name) AS total FROM Users WHERE roles = 'instructor'")->fetch_object()->total;
        $courses = $connect->query("SELECT COUNT(name) AS total FROM Courses")->fetch_object()->total;
        $cars = $connect->query("SELECT COUNT(name) AS total FROM Cars")->fetch_object()->total;
        ?>
        <ul class="summary-boxes">
          <li class="list" style="--current-color: #7b43ff;">
            <h3>Pengemudi</h3>
            <p class="text"><?= $students ?></p>
          </li>
          <li class="list" style="--current-color: #9a79ff;">
            <h3>Instruktur</h3>
            <p class="text"><?= $instructors ?></p>
          </li>
          <li class="list" style="--current-color: #baa9ff;">
            <h3>Kursus</h3>
            <p class="text"><?= $courses ?></p>
          </li>
          <li class="list" style="--current-color: #d8cfff;">
            <h3>Mobil</h3>
            <p class="text"><?= $cars ?></p>
          </li>
        </ul>
      <?php elseif ($_SESSION['roles'] === 'instructor'): ?>
        <ul class="summary-boxes">
          <?php
          $student_count = $connect->query("SELECT COUNT(`status`) AS total FROM Schedules j WHERE j.instructor_id = $_SESSION[auth]")->fetch_object()->total;
          $my_students = $connect->query("SELECT Students.name AS student_name, c.name AS course_name, j.status FROM Schedules j
                                          INNER JOIN Enrollments e ON e.id = j.enrollment_id
                                          INNER JOIN Users Students ON Students.id = e.student_id AND roles = 'student'
                                          INNER JOIN Courses c ON c.id = e.course_id
                                          WHERE j.instructor_id = $_SESSION[auth]");
          ?>
          <li class="list">
            <h3>Pengemudi</h3>
            <p class="text"><?= $student_count ?></p>
          </li>
        </ul>
      <?php endif ?>
      <div class="container">
        <div class="inputBx">
          <?php if ($_SESSION['roles'] === 'student'): ?>
            <a href="./courses/all.php" class="btn primary">+ Beli Kursus</a>
          <?php endif ?>
          <input type="text" placeholder="Pencarian Nama" id="searchInput">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <?php if ($_SESSION['roles'] === 'instructor'): ?>
                  <th>Pengemudi</th>
                  <th>Kursus</th>
                  <th>Status</th>
                <?php elseif ($is_admin): ?>
                  <th>Nama</th>
                  <th>Status</th>
                <?php else: ?>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Aksi</th>
                <?php endif ?>
              </tr>
            </thead>
            <?php
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
              <?php if ($_SESSION['roles'] === 'student'): ?>
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
                  <td colspan="3" align="center" style="opacity: 0.75;">Tidak ada kursus.</td>
                <?php endif ?>
              <?php elseif ($_SESSION['roles'] === 'instructor'): ?>
                <?php if (!empty($my_students)): ?>
                  <?php while ($student = mysqli_fetch_object($my_students)): ?>
                    <tr>
                      <td><?= ++$i ?></td>
                      <td><?= $student->student_name ?></td>
                      <td><?= $student->course_name ?></td>
                      <td>
                        <span class="status <?= $student->status === 'done' ? 'success' : 'warning' ?>">
                          <?= $student->status === 'done' ? "Selesai" : "Gagal" ?>
                        </span>
                      </td>
                    </tr>
                  <?php endwhile ?>
                <?php else: ?>
                  <td colspan="4" align="center" style="opacity: 0.75;">Tidak ada pengemudi.</td>
                <?php endif ?>
              <?php else: ?>
                <td colspan="3" align="center" style="opacity: 0.75;">Tidak ada pengemudi.</td>
              <?php endif ?>
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