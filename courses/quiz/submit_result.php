<?php

include_once("../../database/connect.php");

$id = $_POST['quiz_id'];
$user_id = $_SESSION['auth'];

function calculatedScore($questions, $answers = [])
{
  $score = 0;

  foreach ($questions as $index => $q) {
    if (isset($answers[$index]) && $answers[$index] === $q['answer']) {
      $score++;
    }
  }

  return ['score' => $score, 'total' => count($questions)];
}

$quiz = $connect->query("SELECT * FROM Quizzes WHERE id = $id")->fetch_object();

// $enrollment = $connect->query("SELECT 1 AS is_enroll FROM Enrollments WHERE student_id = $_SESSION[auth] AND course_id = $quiz->course_id")->fetch_object();

// if (empty($enrollment->is_enroll)) {
//   echo "alert('Anda belum beli')";
// }

$result = calculatedScore(json_decode($quiz->quiz_json, true), $_POST['answers'] ?? []);

$check = mysqli_query($connect, "SELECT 1 FROM quiz_results WHERE user_id = $user_id AND quiz_id = $quiz->id");
if (mysqli_num_rows($check) > 0) {
  $connect->query("UPDATE quiz_results SET score = $result[score], total = $result[total] WHERE user_id = $user_id AND quiz_id = $quiz->id");
} else {
  $connect->query("INSERT INTO quiz_results (user_id, course_id, quiz_id, score, total)
                  VALUES ($user_id, $quiz->course_id, $quiz->id, $result[score], $result[total])");
}

header("Location: ../learn.php?id=$quiz->course_id");

// echo round(($result['score'] / $result['total']) * 100);
