<?php

include_once('../database/connect.php');

if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $duration = $_POST['duration'];
  $price = $_POST['price'];

  $result = mysqli_query($connect, "INSERT INTO Courses(name, duration, price) VALUES('$name', $duration, $price)");

  header("Location: index.php");
}
