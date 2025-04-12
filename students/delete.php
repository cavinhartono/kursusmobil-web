<?php
include_once("../database/connect.php");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$stmt = mysqli_query($connect, "DELETE FROM Students WHERE id=$id");

if ($stmt) {
  header('Location: index.php');
} else {
  die("gagal menghapus...");
}
