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
      margin: 32px 0;
      position: relative;
      display: flex;
      justify-content: center;
      gap: 32px;
      width: 100%;
      flex-wrap: wrap;
    }

    .flip-card {
      background-color: transparent;
      width: 300px;
      height: 254px;
      perspective: 1000px;
      font-family: sans-serif;
    }

    .title {
      font-size: 1.5em;
      font-weight: 900;
      text-align: center;
      margin: 0;
    }

    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      text-align: center;
      transition: transform 0.8s;
      transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
      box-shadow: 0 8px 14px 0 rgba(0, 0, 0, 0.2);
      position: absolute;
      display: flex;
      flex-direction: column;
      justify-content: center;
      width: 100%;
      height: 100%;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      border: 1px solid #222;
      border-radius: 1rem;
    }

    .flip-card-front {
      overflow: hidden;
    }

    .flip-card-front img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .flip-card-back {
      background: #fff;
      color: #222;
      transform: rotateY(180deg);
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="action">
      <a href="../index.php">Kembali</a>
      <h1 class="title">KURSUS</h1>
    </div>
    <ul class="card">
      <?php $Courses = mysqli_query($connect, "SELECT * FROM Courses ORDER BY created_at"); ?>
      <?php while ($course = mysqli_fetch_object($Courses)): ?>
        <a href="./view.php?id=<?= $course->id ?>">
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <img src="https://picsum.photos/id/<?= $course->id ?>3/1280/830" alt="">
              </div>
              <div class="flip-card-back">
                <p class="title"><?= $course->name ?></p>
                <p><?= number_format($course->price, 0) ?> IDR</p>
              </div>
            </div>
          </div>
        </a>
      <?php endwhile ?>
    </ul>
  </div>
</body>

</html>