<!DOCTYPE html>
<html lang="en">

<?php

include_once("../../database/connect.php");

$course_id = $_GET['id'];
$user_id = $_GET['user_id'] ?? null;

$course = $connect->query("SELECT name, quiz_json FROM Courses WHERE id = $course_id")->fetch_object();
$user = $connect->query("SELECT name FROM Users WHERE id = $user_id")->fetch_object();
$quizzes = json_decode($course->quiz_json, true);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="store.php" method="POST">
    <input type="hidden" name="course_id" value="<?= $course_id ?>">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <?php foreach ($quizzes as $quiz): ?>
      <h3><?= htmlspecialchars($quiz['category']) ?></h3>
      <?php foreach ($quiz['items'] as $item): ?>
        <label><input type="checkbox" name="nilai[<?= htmlspecialchars($quiz['category']) ?>][<?= htmlspecialchars($item) ?>]" <?= $_SESSION['roles'] === 'admin' ? 'disabled' : "" ?> value="1"> <?= htmlspecialchars($item) ?></label><br>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <button type="submit" name="get_result">Lanjut</button>
  </form>
</body>

</html>