<?php
$conn = new mysqli("localhost", "root", "", "driving_school");

$id = $_GET['id'] ?? null;
if (!$id) {
  die("Quiz ID tidak ditemukan.");
}

$stmt = $conn->query("SELECT * FROM quizzes WHERE id = $id");
$quiz = $stmt->fetch_assoc();

if (!$quiz) {
  die("Quiz tidak ditemukan.");
}

$quiz_data = json_decode($quiz['quiz_json'], true);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Quiz</title>
  <style>
    .highlight {
      border-color: green;
      background-color: #eaffea;
    }

    .option-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }

    .option-wrapper input[type="text"] {
      margin-right: 10px;
      border: 2px solid #ccc;
      padding: 5px;
    }
  </style>
</head>

<body>

  <h2>Edit Quiz</h2>
  <form method="POST" action="update_quiz.php" onsubmit="return generateJSON()">
    <input type="hidden" name="id" value="<?= $quiz['id'] ?>">
    <label>Judul Quiz: <input type="text" name="title" value="<?= htmlspecialchars($quiz['title']) ?>" required></label><br><br>
    <label>Order Index: <input type="text" name="order_index" value="<?= $quiz['index'] ?>" required></label><br><br>

    <div id="questions-container">
      <?php foreach ($quiz_data as $index => $q): ?>
        <div class="question-block" data-index="<?= $index ?>">
          <label>Pertanyaan:
            <input type="text" name="questions[]" value="<?= htmlspecialchars($q['question']) ?>" required>
          </label><br>

          <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
            <div class="option-wrapper">
              <input type="text" name="option_<?= strtolower($opt) ?>[]" value="<?= htmlspecialchars($q['options'][$opt]) ?>" required
                class="<?= $q['answer'] === $opt ? 'highlight' : '' ?>">
              <input type="radio" name="correct_<?= $index ?>" value="<?= $opt ?>" <?= $q['answer'] === $opt ? 'checked' : '' ?>
                onclick="highlightCorrect(this)">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <input type="hidden" name="quiz_json" id="quiz_json">
    <button type="submit">Update Quiz</button>
  </form>

  <script>
    function highlightCorrect(radioBtn) {
      const block = radioBtn.closest(".question-block");
      const options = block.querySelectorAll(".option-wrapper");

      options.forEach(wrapper => {
        wrapper.querySelector("input[type='text']").classList.remove("highlight");
      });

      const textInput = radioBtn.parentElement.querySelector("input[type='text']");
      if (textInput) textInput.classList.add("highlight");
    }

    function generateJSON() {
      const questions = document.getElementsByName("questions[]");
      const optionA = document.getElementsByName("option_a[]");
      const optionB = document.getElementsByName("option_b[]");
      const optionC = document.getElementsByName("option_c[]");
      const optionD = document.getElementsByName("option_d[]");

      const quizArray = [];

      for (let i = 0; i < questions.length; i++) {
        const answerRadio = document.querySelector(`input[name="correct_${i}"]:checked`);
        if (!answerRadio) {
          alert(`Pertanyaan ke-${i + 1} belum memiliki jawaban benar`);
          return false;
        }

        quizArray.push({
          question: questions[i].value,
          options: {
            A: optionA[i].value,
            B: optionB[i].value,
            C: optionC[i].value,
            D: optionD[i].value
          },
          answer: answerRadio.value
        });
      }

      document.getElementById("quiz_json").value = JSON.stringify(quizArray);
      return true;
    }
  </script>

</body>

</html>