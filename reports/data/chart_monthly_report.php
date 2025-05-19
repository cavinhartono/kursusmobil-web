<?php
include_once("../../database/connect.php");

$Enrollments_Months = $connect->query("SELECT DATE_FORMAT(created_at, '%M') AS month, COUNT(*) AS total FROM enrollments
                                      WHERE YEAR(created_at) = YEAR(CURDATE())
                                      GROUP BY MONTH(created_at) ORDER BY MONTH(created_at)");

$labels = [];
$series = [];

while ($enrollment = $Enrollments_Months->fetch_assoc()) {
  $labels[] = $enrollment['month'];
  $series[] = (int) $enrollment['total'];
}

echo json_encode([
  'labels' => $labels,
  'series' => $series
]);
