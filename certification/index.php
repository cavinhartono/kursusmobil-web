<?php
ob_start();

include_once("../database/connect.php");
include_once('tcpdf/tcpdf.php');

$certification = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);
$certification->setTitle('Certificate of Courses Indonesia Mandiri');
$certification->AddPage();
$certification->setFont('dejavusans', '', 24);

// if (isset($_POST['submit'])) {
$user_id = $_GET['user'];
$instuctor_id = $_GET['instructor'];
$course_id = $_GET['course'];

$course = $connect->query("SELECT name FROM Courses WHERE id = $course_id")->fetch_object();
$user = $connect->query("SELECT name, email FROM Users WHERE id = $user_id")->fetch_object();
$instuctor = $connect->query("SELECT name, email FROM Users WHERE id = $instuctor_id AND roles = 'instructor'")->fetch_object() ?? null;
// Final Result = (Quiz X 20%) + (Ujian Praktek X 80%)
$quiz = $connect->query("SELECT (SUM(score) / SUM(total) * 100) AS result FROM quiz_results 
                                  WHERE user_id = $user_id AND course_id = $course_id")->fetch_object();

$is_create_certification = $user && $instuctor && $course;

if ($is_create_certification) {
  $certification->writeHTML("
    <style>
      * {
        text-align: center;
      }

      h2 {
        text-transform: uppercase;
      }
    </style>
    <h1> Certificate of Courses Indonesia Mandiri </h1>
    <p> This certifies that </p>
    <h2> $user->name </h2>
    <p> has successfully completed the </p>
    <h2> $course->name </h2>
    <p> Dibimbing oleh </p>
    <h2> $instuctor->name </h2>
    <p> on Hari ini </p>
  ");
}
// }
ob_end_clean();

// $certification->Output("$course->name.pdf", 'D');
?>

<body>
  <?php if ($is_create_certification): ?>
    <h1 style='text-align: center'> Certificate of Courses Indonesia Mandiri </h1>
    <p style='text-align: center'> This certifies that </p>
    <h2 style='text-align: center; text-transform: uppercase;'> <?= $user->name ?> </h2>
    <p style='text-align: center'> has successfully completed the </p>
    <h2 style='text-align: center'> <?= $course->name ?> </h2>
    <p style='text-align: center'> Dibimbing oleh </p>
    <h2 style='text-align: center; text-transform: uppercase;'> <?= $instuctor->name ?> </h2>
    <p style='text-align: center'> on $date </p>
  <?php else: ?>
    <h2>Tidak dapat dibuat sertifikat tersebut</h2>
  <?php endif ?>
</body>