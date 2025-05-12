<?php

include_once("../../database/connect.php");

if (isset($_POST['exam'])) {
  $course_id = $_POST['course_id'];
  $quiz_json = $_POST['quiz_json'];

  if (!json_decode($quiz_json)) {
    die("Format JSON tidak valid");
  }

  $connect->query("UPDATE Courses SET quiz_json = '$quiz_json' WHERE id = $course_id");

  header("Location: ./index.php?id=$course_id");
}
