<?php

include_once('../database/connect.php');

if (isset($_POST['create'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $result = mysqli_query($connect, "INSERT INTO Users(name, email, phone) VALUES('$name', '$email', '$phone')");

  header("Location: index.php");
  exit;
}
