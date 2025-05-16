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

if (isset($_POST['get_result'])) {
  $course_id = $_POST['course_id'];
  $user_id = $_POST['user_id'];
  $nilai = $_POST['nilai'] ?? [];

  $results = 0;
  $count = 0;

  foreach ($nilai as $kategori => $items) {
    foreach ($items as $item => $val) {
      $results += 1;
    }
  }

  $quiz = $connect->query("SELECT quiz_json FROM Courses WHERE id = $course_id");
  $soal = json_decode($quiz->fetch_assoc()['quiz_json'], true);

  foreach ($soal as $kat) {
    foreach ($kat['items'] as $item) {
      $count += 1;
      if (!isset($results[$kat['category']][$item])) {
        $results -= 0;
      }
    }
  }

  $score_from_user = $connect->query("SELECT (SUM(score) / SUM(total) * 100) AS result FROM quiz_results 
                                  WHERE user_id = $user_id AND course_id = $course_id")->fetch_object();
  $test_from_instructor = round(($results / $count) * 100);

  $get_id_from_enrollment = $connect->query("SELECT id FROM Enrollments WHERE user_id = $user_id AND course_id = $course_id");
  $connect->query("UPDATE Schedules SET `status` = 'done' WHERE id = $get_id_from_enrollment");

  $total_score = ($score_from_user * 0.20) + ($test_from_instructor * 0.80);

  if (isSuccess($total_score)) {
    $connect->query("INSERT INTO Certifications(enrollment_id, instructor_id, total_score, `status`) VALUES ($get_id_from_enrollment, $_SESSION[auth], $total_score, 'success')");
  } else {
    $connect->query("INSERT INTO Certifications(enrollment_id, instructor_id, total_score, `status`) VALUES ($get_id_from_enrollment, $_SESSION[auth], $total_score, 'failed')");
  }

  header("Location: ../../schedules/index.php");
}

function isSuccess($final_score)
{
  return $final_score >= 80 ? true : false;
}
