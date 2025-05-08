<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<?php
include_once("../database/connect.php");

$Materials = $connect->query("SELECT * FROM Materials WHERE course_id = $_GET[id]");
?>

<body>
  <ul>
    <?php while ($material = $Materials->fetch_object()): ?>
      <li><a href="materials/<?= $material->file_path ?>"><?= $material->file_name ?></a></li>
    <?php endwhile ?>
  </ul>
</body>

</html>