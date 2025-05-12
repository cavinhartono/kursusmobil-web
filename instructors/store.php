<?php

include_once('../database/connect.php');

if (isset($_POST['create'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $phone = $_POST['phone'];

  mysqli_query($connect, "INSERT INTO Users(roles, name, email, password, phone) VALUES('instructor', '$name', '$email', '$password', '$phone')");

  header("Location: index.php");
  exit;
}
