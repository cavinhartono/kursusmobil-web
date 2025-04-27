<?php

include_once('../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $phone = $_POST['phone'];

  $result = mysqli_query(
    $connect,
    "UPDATE Users 
    SET roles = 'instructor', name = '$name', email = '$email', password = '$password', phone = '$phone' 
    WHERE id = $id"
  );

  header("Location: index.php");
  exit;
}
