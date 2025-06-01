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
  <link rel="stylesheet" href="../assets/css/landing_page/style.css">
  <title>All Courses</title>
  <style>
    .container {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .action {
      padding: 48px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .card {
      padding: 48px;
      margin: 32px 0;
      position: relative;
      display: flex;
      gap: 32px;
      width: 100%;
      flex-wrap: wrap;
    }

    .list {
      padding: 24px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="action">
      <a href="../index.php" style="display: flex; align-items: center; gap: 24px"><ion-icon name="arrow-back-outline"></ion-icon> Kembali</a>
      <h1 class="title">KURSUS</h1>
    </div>
    <ul class="card">
      <?php $Courses = mysqli_query($connect, "SELECT * FROM Courses ORDER BY created_at"); ?>
      <?php $i = 0; ?>
      <?php while ($course = mysqli_fetch_object($Courses)): ?>
        <li class="list">
          <h1 class="supertitle"><?= ++$i ?></h1>
          <a href="./view.php?id=<?= $course->id ?>">
            <h1 class="title"><?= $course->name ?></h1>
            <p><?= number_format($course->price, 0) ?> IDR</p>
          </a>
        </li>
      <?php endwhile ?>
    </ul>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>