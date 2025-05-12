<!DOCTYPE html>
<html lang="en">

<?php

include_once("../../database/connect.php");

$course_id = $_GET['id'];

$course = $connect->query("SELECT name, quiz_json FROM Courses WHERE id = $course_id")->fetch_object();
$quizzes = json_decode($course->quiz_json, true);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="">
    <?php foreach ($quizzes as $quiz): ?>
      <h3><?= htmlspecialchars($quiz['category']) ?></h3>
      <?php foreach ($quiz['items'] as $item): ?>
        <label><input type="checkbox" name="nilai[]" <?= $_SESSION['roles'] === 'admin' ? 'disabled' : "" ?>> <?= htmlspecialchars($item) ?></label><br>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </form>
</body>

</html>