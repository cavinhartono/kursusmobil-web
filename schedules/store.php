<?php

include_once("../database/connect.php");

if (isset($_POST['add'])) {
  $car_id = $_POST['car_id'];
  $user_id = $_SESSION['auth'];
  $course_id = $_POST['course_id'];
  $instructor_id = $_POST['instructor_id'];

  $enrollment_id = $connect->query(
    "SELECT id FROM Enrollments 
    WHERE student_id = $user_id AND course_id = $course_id"
  )->fetch_object()->id;

  $connect->query("INSERT INTO Schedules(car_id, enrollment_id, instructor_id) VALUES($car_id, $enrollment_id, $instructor_id)");

  header("Location: index.php");
}
