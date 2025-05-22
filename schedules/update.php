<?php

include_once('../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $time_in = mysqli_real_escape_string($connect, $_POST['time_in']);
  $date_in =  mysqli_real_escape_string($connect, $_POST['date_in']);

  $result = mysqli_query($connect, "UPDATE Schedules SET time_in = '$time_in', date_in = '$date_in' WHERE id = $id");

  header("Location: index.php");
  exit;
}
