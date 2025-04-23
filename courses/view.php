<?php

include_once("../database/connect.php");

foreach (glob("../components/landingPage/*.php") as $file) {
  require $file;
}

$id = $_GET['id'];

$statement = $connect->query("SELECT * FROM Courses WHERE id = $id");
$course = $statement->fetch_object();

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
  </main>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="assets/js/landing_page/script.js"></script>
</body>
</html>