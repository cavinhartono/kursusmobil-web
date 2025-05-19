<?php
include_once("../../database/connect.php");

$Enrollments_Years = $connect->query("SELECT YEAR(created_at) AS year, COUNT(*) AS total FROM enrollments
                                                  GROUP BY YEAR(created_at) ORDER BY year");

$labels = [];
$series = [];

while ($enrollment = $Enrollments_Years->fetch_assoc()) {
  $labels[] = $enrollment['year'];
  $series[] = (int) $enrollment['total'];
}

echo json_encode([
  'labels' => $labels,
  'series' => $series
]);
