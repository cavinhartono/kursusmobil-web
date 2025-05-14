<?php
session_start();

foreach (glob("../components/*.php") as $file) {
  require $file;
}

include_once("../database/connect.php");

$i = 0;

if ($_SESSION['roles'] === "student") {
  $Schedules = $connect->query("SELECT instructors.name AS instructor_name, students.name AS student_name,  cars.name AS car_name, cars.transmission AS car_transmission, j.date_in, j.time_in, c.name AS course_title, FROM schedules j
                                INNER JOIN enrollments e ON j.enrollment_id = e.id
                                INNER JOIN users instructors ON j.instructor_id = instructors.id AND instructors.roles = 'instructor'
                                INNER JOIN users students ON e.student_id = students.id
                                INNER JOIN courses c ON e.course_id = c.id
                                INNER JOIN cars ON j.car_id = cars.id
                                WHERE e.student_id = $_SESSION[auth] AND j.status = 'pending'
                                ORDER BY j.date_in, j.time_in");
} else {
  $Schedules = $connect->query(
    "SELECT j.id AS jadwal_id, students.id AS student_id_student, students.name AS student_name, cars.name AS car_name, cars.transmission AS car_transmission, j.date_in, j.time_in, c.id AS course_id_course, c.name AS course_title FROM schedules j
    INNER JOIN enrollments e ON j.enrollment_id = e.id
    INNER JOIN users students ON e.student_id = students.id AND students.roles = 'student'
    INNER JOIN courses c ON e.course_id = c.id
    INNER JOIN cars ON j.car_id = cars.id
    WHERE j.instructor_id = $_SESSION[auth] AND j.status = 'pending'
    ORDER BY j.date_in, j.time_in"
  );
}

$fields = [
  ['name' => 'time_in', 'label' => 'Waktu Dilaksanakan', 'type' => 'time'],
  ['name' => 'date_in', 'label' => 'Tanggal Dilaksanakan', 'type' => 'date'],
];

$editData = null;
if (isset($_GET['edit'])) {
  $id = (int) $_GET['edit'];
  $data = mysqli_query($connect, "SELECT * FROM Schedules WHERE id=$id")->fetch_assoc();

  if ($data) {
    modal("update", $fields, "Jadwal", $id, $data);
    echo "<script>window.onload = () => openModal('updateModal$id');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Data Jadwal"); ?>
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
                <?php if ($_SESSION['roles'] === 'instructor'): ?>
                  <th style="width: max-content">Pengemudi</th>
                <?php endif ?>
                <th>Kursus</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mobil</th>
                <th>Transmisi</th>
                <?php if ($_SESSION['roles'] === 'student'): ?>
                  <th style="width: max-content">Instruktur</th>
                <?php else: ?>
                  <th>Aksi</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php while ($schedule = mysqli_fetch_object($Schedules)): ?>
                <tr>
                  <td><?= ++$i ?></td>
                  <?php if ($_SESSION['roles'] === 'instructor'): ?>
                    <td><?= $schedule->student_name ?></td>
                  <?php endif ?>
                  <td><?= $schedule->course_title ?></td>
                  <td><?= $schedule->date_in ?></td>
                  <td><?= $schedule->time_in ?></td>
                  <td><?= $schedule->car_name ?></td>
                  <td style="text-transform: capitalize;"><?= $schedule->car_transmission ?></td>
                  <?php if ($_SESSION['roles'] === 'student'): ?>
                    <td><?= $schedule->instructor_name ?></td>
                  <?php else: ?>
                    <td>
                      <a href="?edit=<?= $schedule->jadwal_id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                      <a href="../courses/finalExam/index.php?id=<?= $schedule->course_id_course ?>&user_id=<?= $schedule->student_id_student ?>" class="btn primary"><ion-icon name="paper"></ion-icon></a>
                    </td>
                  <?php endif ?>
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