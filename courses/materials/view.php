<?php

include_once("../../database/connect.php");

$material = $connect->query("SELECT * FROM Materials WHERE id = $_GET[page]")->fetch_object();
$course = $connect->query("SELECT name FROM Courses WHERE id = $_GET[id]")->fetch_object();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $material->title ?> - <?= $course->name ?></title>
</head>

<body>
  <h1><?= $material->title ?></h1>
  <?= $material->content ?>
</body>

</html>