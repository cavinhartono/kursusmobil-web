<?php

include_once('../database/connect.php');

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $transmission = $_POST['transmission'];

  $result = mysqli_query($connect, "INSERT INTO Cars(name, transmission) VALUES('$name', '$transmission')");

  header("Location: index.php");
  exit;
}
