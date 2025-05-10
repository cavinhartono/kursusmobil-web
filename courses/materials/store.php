<?php
include_once("../../database/connect.php");

if (isset($_POST['add'])) {
  $course_id = $_POST['course_id'];
  $title = $_POST['title'];
  $order_index = $_POST['order_index'];
  $content = $_POST['content'];

  $connect->query("INSERT INTO Materials(course_id, title, order_index, content) VALUES($course_id, '$title', '$order_index', '$content')");
  header("Location: ./index.php?id=$course_id");
}
