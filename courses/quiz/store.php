<?php
include_once("../../database/connect.php");

if (isset($_POST['add'])) {
  $title = $_POST['title'];
  $course_id = $_POST['course_id'];
  $order_index = $_POST['order_index'];
  $quiz_json = $_POST['quiz_json'];

  if (!json_decode($quiz_json)) {
    die("Format JSON tidak valid");
  }

  $connect->query("INSERT INTO quizzes (course_id, title, `order_index`, quiz_json) VALUES ($course_id, '$title', '$order_index', '$quiz_json')");

  header("Location: ../materials/index.php?id=$course_id");
}
