<?php

include_once("../database/connect.php");

foreach (glob("../components/landingPage/*.php") as $file) {
  require $file;
}

$id = $_GET['id'];

$statement = $connect->query("SELECT * FROM Courses WHERE id = $id");
$course = $statement->fetch_object();

if (isset($_POST['create'])) {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/landing_page/course/style.css">
  <title><?= $course->name ?> - Kursus Mobil IM</title>
</head>

<body>
  <main class="container">
    <?php headerLogo() ?>
    <div class="course">
      <div class="details">
        <h1 class="supertitle">
          <?= $course->name ?>
        </h1>
        <h2 class="subtitle">
          <?= number_format($course->price, 0, ",", ".") ?> IDR
        </h2>
        <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad neque quasi possimus aut recusandae optio odit blanditiis quo velit facere corporis omnis laboriosam corrupti aperiam ab tempore nemo, odio temporibus quia! Fugiat.</p>
        <a href="../enrollments/buy.php?id=<?= $course->id ?>" class="btn primary">Enroll</a>
      </div>
      <div class="img">
        <img src="https://picsum.photos/id/<?= $course->id ?>3/1280/830">
      </div>
    </div>
  </main>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="assets/js/landing_page/script.js"></script>
</body>

</html>