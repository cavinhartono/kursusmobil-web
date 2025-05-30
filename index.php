<!DOCTYPE html>
<html lang="en">

<?php
include_once("./database/connect.php");

foreach (glob("./components/landingPage/*.php") as $file) {
  require $file;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/landing_page/style.css">
  <title>Selamat Datang, <?= !empty($_SESSION['name']) ? $_SESSION['name'] : "User" ?>!</title>
</head>

<body>
  <main class="container">
    <?php headerLogo() ?>
    <section class="homepage">
      <div class="detail">
        <h1 class="supertitle">
          Drive Safe, Driver Smart
        </h1>
        <p class="title">
          We make it easier for you to get your driver's license.
        </p>
        <ul class="action">
          <li class="list"><a href="#" class="btn primary">Ambil Lisensi</a></li>
          <li class="list"><a href="#" class="btn">Tentang Kami</a></li>
        </ul>
      </div>
      <ul class="img">
        <li class="list"><img src="https://picsum.photos/id/43/1280/830" alt=""></li>
        <li class="list"><img src="https://picsum.photos/id/53/1280/830" alt=""></li>
        <li class="list"><img src="https://picsum.photos/id/63/1280/830" alt=""></li>
        <li class="list"><img src="https://picsum.photos/id/73/1280/830" alt=""></li>
      </ul>
      <div class="powerBy">
        <h1 class="title">Dibuatkan oleh <span class="icon"><ion-icon name="arrow-forward-outline"></ion-icon></span></h1>
        <ul class="names">
          <li class="list">Muhammad Cavin Hartono Putra</li>
          <li class="list">Fauzi Riza Wahyudi</li>
        </ul>
      </div>
    </section>
    <section class="courses">
      <h1 class="title">Kursus Yang Tersedia</h1>
      <?php
      include_once("./database/connect.php");

      $Courses = mysqli_query($connect, "SELECT * FROM Courses ORDER BY created_at LIMIT 3");
      ?>
      <ul class="card">
        <?php while ($course = mysqli_fetch_object($Courses)): ?>
          <li class="list">
            <div class="img">
              <img src="https://picsum.photos/id/<?= $course->id ?>3/1280/830" alt="">
            </div>
            <div class="details">
              <h1 class="title"><?= $course->name ?></h1>
              <h2 class="subtitle"><?= number_format($course->price, 0) ?> IDR</h2>
              <a href="courses/view.php?id=<?= $course->id ?>" class="btn primary">Belajar Sekarang</a>
            </div>
          </li>
        <?php endwhile ?>
      </ul>
    </section>
  </main>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="assets/js/landing_page/script.js"></script>
</body>

</html>