<?php

include_once("../database/connect.php");

if (isset($_POST['submit'])) {
  $user = $_POST['user_id'];
  $course = $_POST['course_id'];
  $car = $_POST['car_id'];

  $connect->query("INSERT INTO Enrollments() VALUES ()");
}
