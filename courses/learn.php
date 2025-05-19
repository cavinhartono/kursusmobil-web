<!DOCTYPE html>
<html lang="en">

<?php
include_once('../database/connect.php');

$course_id = $_GET['id'];
$auth = $_SESSION['auth'];
$Quizzes = $connect->query("SELECT id, title FROM Quizzes WHERE course_id = $course_id");

$done_quizzes = [];
$qresults = $connect->query("SELECT quiz_id FROM quiz_results WHERE user_id = $auth AND course_id = $course_id");
while ($r = mysqli_fetch_assoc($qresults)) {
  $done_quizzes[] = $r['quiz_id'];
}

$current_quiz = $connect->query("SELECT COUNT(*) FROM quiz_results WHERE course_id = $course_id AND user_id = $auth")->fetch_object();
$all_quiz = $connect->query("SELECT COUNT(*) FROM quizzes WHERE course_id = $course_id")->fetch_object();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/css/client/style.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <aside class="aside">
      <h1>Daftar Materi</h1>
      <div id="materi-list" class="materials"></div>
      <h1>Kuis</h1>
      <?php while ($quiz = mysqli_fetch_object($Quizzes)): ?>
        <?php $is_done = in_array($quiz->id, $done_quizzes); ?>
        <a
          style="<?= $is_done ? 'color: green; font-weight: bold;' : "" ?>"
          href=" ./quiz/index.php?id=<?= $quiz->id ?>">
          <?= $quiz->title ?> <?= $is_done ? ' ✓ ' : '' ?>
        </a>
      <?php endwhile ?>
      <?php if ($current_quiz == $all_quiz): ?>
        <a href="../schedules/create.php?course_id=<?= $course_id ?>">Ajukan Praktek</a>
      <?php endif ?>
    </aside>
    <div id="konten-container">
      <h2 id="judul"></h2>
      <div id="konten" class="konten"></div>
    </div>
  </div>

  <script>
    const listDiv = document.getElementById('materi-list');
    const judulEl = document.getElementById('judul');
    const kontenEl = document.getElementById('konten');

    // Tampilkan daftar materi
    fetch(`./materials/api.php?course_id=${<?= $course_id ?>}`)
      .then(res => res.json())
      .then(data => {
        data.forEach(materi => {
          const btn = document.createElement('div');
          btn.className = 'list-item';
          btn.textContent = materi.title;
          btn.onclick = () => tampilkanMateri(materi.id);
          listDiv.appendChild(btn);
        });
      });

    // Saat klik, ambil dan tampilkan kontennya
    function tampilkanMateri(id) {
      fetch(`./materials/api.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
          judulEl.textContent = data.title;
          kontenEl.innerHTML = data.content;
        });
    }
  </script>
</body>

</html>