<?php
include_once('../../database/connect.php');

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $course_id = $_POST['course_id'];
  $title = $_POST['title'];
  $order_index = $_POST['order_index'];
  $content = $_POST['content'];

  $connect->query("UPDATE Materials SET course_id = $course_id, title = '$title', order_index = '$order_index', content = '$content' WHERE id = $id");

  header("Location: ./index.php?id=$course_id");
  exit;
}
