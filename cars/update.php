<?php

include_once('../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $transmission = $_POST['transmission'];

  $result = mysqli_query($connect, "UPDATE Cars SET name = '$name', transmission = '$transmission' WHERE id = $id");

  header("Location: index.php");
  exit;
}
