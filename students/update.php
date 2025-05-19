<?php

include_once('../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $result = mysqli_query($connect, "UPDATE Users SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id");

  header("Location: index.php");
  exit;
}
