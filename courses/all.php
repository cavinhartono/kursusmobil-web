<!DOCTYPE html>
<html lang="en">

<?php
include_once("../database/connect.php");

foreach (glob("../components/landingPage/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/landing_page/style.css">
  <title>All Courses</title>
</head>

<body>
  <ul class="card">
    <?php $Courses = mysqli_query($connect, "SELECT * FROM Courses ORDER BY created_at"); ?>
    <?php while ($course = mysqli_fetch_object($Courses)): ?>
      <li class="list">
        <div class="details">
          <h1 class="title"><?= $course->name ?></h1>
          <h2 class="subtitle"><?= number_format($course->price, 0) ?> IDR</h2>
          <a href="./view.php?id=<?= $course->id ?>" class="btn primary">Belajar Sekarang</a>
        </div>
      </li>
    <?php endwhile ?>
  </ul>
</body>

</html>