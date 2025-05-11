<!DOCTYPE html>
<html lang="en">

<?php
include_once('../database/connect.php');

$course_id = $_GET['id'];
$Quizzes = $connect->query("SELECT id, title FROM Quizzes WHERE course_id = $course_id");
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .list-item {
      display: block;
      padding: 8px;
      margin: 4px 0;
      border: 1px solid #ccc;
      background-color: #f7f7f7;
      cursor: pointer;
    }

    .list-item:hover {
      background-color: #e0e0e0;
    }

    #konten-container {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      border: 1px solid #aaa;
    }

    .materials {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .container {
      position: relative;
      width: 100%;
      display: flex;
      gap: 32px;
    }
  </style>
</head>

<body>
  <div class="container">
    <aside class="aside">
      <h1>Daftar Materi</h1>
      <div id="materi-list" class="materials"></div>
      <h1>Kuis</h1>
      <?php while ($quiz = mysqli_fetch_object($Quizzes)): ?>
        <a href="./quiz/index.php?id=<?= $quiz->id ?>"><?= $quiz->title ?></a>
      <?php endwhile ?>
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