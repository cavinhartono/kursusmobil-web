<!DOCTYPE html>
<html lang="en">

<?php
include_once("../../database/connect.php");

$id = $_GET['id'];

$quiz = $connect->query("SELECT * FROM Quizzes WHERE id = $id")->fetch_object();

$enrollment = $connect->query("SELECT 1 AS is_enroll FROM Enrollments WHERE student_id = $_SESSION[auth] AND course_id = $quiz->course_id")->fetch_object();

if (empty($enrollment->is_enroll)) {
  echo "alert('Anda belum beli')";
}

$questions = json_decode($quiz->quiz_json, true);
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kuis Dulu - Kursus IM</title>
</head>

<body>
  <h2><?= $quiz->title ?></h2>

  <div id="timer" style="font-weight: bold; color: darkblue;">05:00</div>
  <form method="POST" action="submit_result.php">
    <input type="hidden" name="quiz_id" value="<?= $id ?>">

    <?php foreach ($questions as $index => $question): ?>
      <div class="question">
        <p><strong><?= ($index + 1) ?>. <?= $question['question'] ?></strong></p>
        <?php foreach ($question['options'] as $optKey => $option): ?>
          <label>
            <input type="radio" name="answers[<?= $index ?>]" value="<?= $optKey ?>">
            <?= $option ?>
          </label><br>
        <?php endforeach ?>
      </div>
    <?php endforeach ?>

    <button type="submit">Submit Quiz</button>
  </form>

  <script>
    // Countdown 5 minutes
    let time = 5 * 60;
    const timer = document.getElementById("timer");

    const countdown = setInterval(() => {
      const minutes = Math.floor(time / 60);
      const seconds = time % 60;
      timer.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      time--;

      if (time < 0) {
        clearInterval(countdown);
        alert("Waktu habis! Quiz akan dikumpulkan otomatis.");
        document.querySelector("form").submit();
      }
    }, 1000);
  </script>
</body>

</html>