<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../database/connect.php");

foreach (glob("../components/*.php") as $file) {
  require $file;
}

$course_id = $_GET['course_id'];
$course = $connect->query("SELECT * FROM Courses WHERE id = $course_id");
$Instructors = $connect->query("SELECT * FROM Users WHERE roles = 'instructor'");
$Cars = $connect->query("SELECT * FROM Cars WHERE `status` = 'active'");

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Membuat Jadwal Ujian Praktek</title>
  <style>
    .fields {
      width: 100%;
      display: flex;
      gap: 16px;
    }

    .cars,
    .instructors {
      width: 100%;
      list-style-type: none;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .list {
      display: flex;
      gap: 16px;
    }

    .list input[type="radio"] {
      display: none;
    }

    .list input[type="radio"]:checked {
      display: block;
    }

    label {
      width: 100%;
      padding: 16px;
      border: 1px solid #222;
      background: #fff;
      box-shadow: 0px 8px 45px rgba(34, 34, 34, 0.1);
    }

    .list input[type="radio"]:checked+label {
      background: #007bff;
      color: #fff;
      border: none;
    }
  </style>
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Buat Jadwal Praktek") ?>
    <div class="content-body">
      <div class="container">
        <form method="POST" action="store.php">
          <div class="fields">
            <ul class="cars">
              <h1 class="title">Mobil yang Tersedia</h1>
              <?php while ($car = mysqli_fetch_object($Cars)): ?>
                <li class="list">
                  <input type="radio" name="car_id" id="carID-<?= $car->id ?>" value="<?= $car->id ?>">
                  <label for="carID-<?= $car->id ?>" style="text-transform: capitalize;"><?= $car->name ?> | <?= $car->transmission ?></label>
                </li>
              <?php endwhile ?>
            </ul>
            <ul class="instructors">
              <h1 class="title">Instruktur yang tersedia</h1>
              <?php while ($instructor = mysqli_fetch_object($Instructors)): ?>
                <li class="list">
                  <input type="radio" name="instructor_id" id="instructorID-<?= $instructor->id ?>" value="<?= $instructor->id ?>">
                  <label for="instructorID-<?= $instructor->id ?>" style="text-transform: capitalize;"><?= $instructor->name ?></label>
                </li>
              <?php endwhile ?>
            </ul>
          </div>
          <input type="hidden" name="course_id" value="<?= $course_id ?>">
          <button type="submit" name="add" class="btn primary"><ion-icon name="checkmark"></ion-icon></button>
        </form>
      </div>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>