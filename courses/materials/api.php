<?php
header("Content-Type: application/json");
include_once("../../database/connect.php");

$course_id = $_GET['course_id'] ?? null;
$id = $_GET['id'] ?? null;

if ($id) {
  $Material = $connect->query("SELECT * FROM materials WHERE id = $id")->fetch_assoc();

  if ($Material) {
    echo json_encode($Material);
  } else {
    http_response_code(404);
    echo json_encode(["error" => "Materi tidak ditemukan"]);
  }
} else {
  // Jika tidak ada ID, kirim semua materi
  $result = $connect->query("SELECT * FROM materials WHERE course_id = $course_id");

  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
}
