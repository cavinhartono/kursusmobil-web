<?php

include_once('../database/connect.php');

if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $result = mysqli_query($connect, "UPDATE Instructors SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id");

  header("Location: index.php");
  exit;
}
