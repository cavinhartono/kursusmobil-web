<?php
ob_start();

include_once("../database/connect.php");
include_once("../certification/tcpdf/tcpdf.php");

$calender = $_GET['calender'];
$Reports = $connect->query("SELECT Users.name AS user_name, Courses.name AS course_name, Enrollments.created_at FROM Enrollments
                            INNER JOIN Users ON Enrollments.student_id = Users.id AND Users.roles = 'student'
                            INNER JOIN Courses ON Enrollments.course_id = Courses.id
                            WHERE DATE_FORMAT(Enrollments.created_at, '%Y-%m') = '$calender'");
$i = 0;

$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);
$pdf->AddPage();
$pdf->setFont('dejavusans', '', 8);

$html = "";
while ($report = $Reports->fetch_object()) {
  ++$i;
  $html .= "<tr>
      <td> $i </td>
      <td> $report->course_name </td>
      <td> $report->user_name </td>
      <td align='center'> $report->created_at </td>
    </tr>";
}

$pdf->writeHTML("
    <style>
      table {
        width: 100%;
      }
    </style>
    <table>
      <thead>
      <tr>
        <th>#</th>
        <th>Kursus</th>
        <th>Pengemudi</th>
        <th>Tanggal</th>
      </tr>
      </thead>
      <tbody>
        $html
      </tbody>
    </table>
  ");

ob_end_clean();

$pdf->Output("$_GET[calender].pdf", 'D');

header("Location: ./index.php");
