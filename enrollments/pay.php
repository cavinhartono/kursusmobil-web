<?php

include_once("../database/connect.php");

echo date('Y-m-d H:i:s') . PHP_EOL;

if ($_POST['metode'] == 'debit') {
  $today = date('Y-m-d H:i:s');
  $get_price_of_course = $connect->query("SELECT price FROM Courses WHERE id = $_POST[course_id]")->fetch_object()->price;
  $get_id_order = $connect->query("SELECT id FROM Orders 
                                  WHERE user_id = $_POST[user_id] AND course_id = $_POST[course_id]
                                  ORDER BY created_at ASC LIMIT 1")->fetch_object()->id;

  $connect->query(
    "INSERT INTO Payments(order_id, `status`, total, paid_at, `method`) 
    VALUES ($get_id_order, 'success', $get_price_of_course, '$today', 'debit')"
  );
  $connect->query("UPDATE Orders SET status = 'paid' WHERE id = $get_id_order");
  $connect->query("INSERT INTO Enrollments(student_id, course_id) VALUES($_POST[user_id], $_POST[course_id])");

  header("Location: ../dashboard.php");
}

if ($_GET['metode'] == 'qris') {
  $stmt = $connect->query("SELECT MAX(id) FROM Orders WHERE user_id = $_GET[user_id] AND course_id = $_GET[course_id]")[0];
  $today = date('Y-m-d H:i:s');

  $connect->query(
    "INSERT INTO Payments(order_id, `status`, total, paid_at, method) 
    VALUES ($order_id, 'success', $_GET[price], '$today', 'qris')"
  );
  $connect->query("UPDATE Orders SET status = 'paid' WHERE id = $order_id");
  $connect->query("INSERT INTO Enrollments(student_id, course_id) VALUES($_GET[user_id], $_GET[course_id])");

  header("Location: ../dashboard.php");
} else {
  echo "Tidak dapat diakses";
}
