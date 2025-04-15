<?php

include_once('../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $duration = $_POST['duration'];
  $price = $_POST['price'];

  $result = mysqli_query($connect, "UPDATE Courses SET name = '$name', duration = $duration, price = $price WHERE id = $id");

  header("Location: index.php");
  exit;
}
