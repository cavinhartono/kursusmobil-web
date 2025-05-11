<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../../database/connect.php");

foreach (glob("../../components/*.php") as $file) {
  require $file;
}

$course_id = $_GET['id'];

$course = $connect->query("SELECT name FROM Courses WHERE id = $course_id")->fetch_object();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Materi - <?= $course->name ?></title>
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="stylesheet" href="../../assets/js/quilljs/quill.snow.css">
  <style>
    .field,
    input {
      width: 100%;
      margin: 8px 0;
    }
  </style>
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Tambah Materi"); ?>
    <div class="content-body">
      <div class="container">
        <form action="./store.php" method="POST" onsubmit="return submitForm()">
          <input type="hidden" name="course_id" value="<?= $course_id ?>">
          <div class="field">
            <label>Kode Materi</label>
            <input type="text" name="order_index" placeholder="Contoh: KND0002">
          </div>
          <div class="field">
            <label>Judul</label>
            <input type="text" name="title">
          </div>
          <div class="field">
            <label>Isi Materi</label>
            <div id="editor"></div>
            <input type="hidden" name="content" id="content">
          </div>
          <button type="submit" name="add" class="btn primary"><ion-icon name="checkmark"></ion-icon></button>
        </form>
      </div>
    </div>
  </div>
  </div>
  <?php if ($_SESSION['roles'] !== 'admin'): ?>
    <script>
      alert('Anda bukan Admin');
      window.location.href = '../../dashboard.php';
    </script>
  <?php endif ?>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../../assets/js/quilljs/quill.min.js"></script>
  <script>
    var quill = new Quill('#editor', {
      theme: 'snow'
    });

    function submitForm() {
      document.getElementById('content').value = quill.root.innerHTML;
      return true;
    }
  </script>
  <script src="../../assets/js/script.js"></script>
</body>

</html>