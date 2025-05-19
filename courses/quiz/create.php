<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../../database/connect.php");

foreach (glob("../../components/*.php") as $file) {
  require $file;
}

$course_id = $_GET['id'];

$course = $connect->query("SELECT name FROM Courses WHERE id = $course_id")->fetch_object();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Kuis - <?= $course->name ?></title>
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <style>
    .action {
      display: flex;
      gap: 8px;
    }

    .field,
    input {
      width: 100%;
      margin: 8px 0;
    }

    .question-block {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 20px;
    }

    .option-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }

    .option-wrapper input[type="radio"] {
      width: 64px;
    }

    .option-wrapper input[type="text"] {
      margin-right: 10px;
      border: 2px solid #ccc;
      padding: 5px;
    }

    .option-wrapper input[type="text"].highlight {
      border-color: green;
      background-color: #eaffea;
    }
  </style>
</head>

<body>
  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Buat Soal Kuis"); ?>
    <div class="content-body">
      <div class="container">
        <form method="POST" action="store.php" onsubmit="return generateJSON()">
          <div class="field">
            <label>Judul Quiz:</label>
            <input type="text" name="title" required>
          </div>
          <div class="field">
            <label>Kode Kuis:</label>
            <input type="text" name="order_index" maxlength="7" placeholder="KNDXXXX" required>
          </div>
          <input type="hidden" name="course_id" value="<?= $course_id ?>">
          <div id="questions-container">
            <div class="question-block" data-index="0">
              <div class="field">
                <label>Pertanyaan:</label>
                <input type="text" name="questions[]" required>
              </div>

              <div class="option-wrapper">
                <input type="radio" name="correct_0" value="A" onclick="highlightCorrect(this)">
                <input type="text" name="option_a[]" required placeholder="Opsi A">
              </div>

              <div class="option-wrapper">
                <input type="radio" name="correct_0" value="B" onclick="highlightCorrect(this)">
                <input type="text" name="option_b[]" required placeholder="Opsi B">
              </div>

              <div class="option-wrapper">
                <input type="radio" name="correct_0" value="C" onclick="highlightCorrect(this)">
                <input type="text" name="option_c[]" required placeholder="Opsi C">
              </div>

              <div class="option-wrapper">
                <input type="radio" name="correct_0" value="D" onclick="highlightCorrect(this)">
                <input type="text" name="option_d[]" required placeholder="Opsi D">
              </div>
            </div>
          </div>

          <input type="hidden" name="quiz_json" id="quiz_json">

          <div class="action">
            <button type="button" class="btn warning" onclick="addQuestion()">+ Tambah Pertanyaan</button>
            <button type="submit" name="add" class="btn primary"><ion-icon name="checkmark"></ion-icon></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    let questionCount = 1;

    function addQuestion() {
      const container = document.getElementById("questions-container");
      const original = document.querySelector(".question-block");
      const clone = original.cloneNode(true);
      clone.setAttribute("data-index", questionCount);

      // Reset input values
      clone.querySelectorAll("input[type='text']").forEach(el => {
        el.value = "";
        el.classList.remove("highlight");
      });
      clone.querySelectorAll("input[type='radio']").forEach((el, i) => {
        el.checked = false;
        el.name = `correct_${questionCount}`;
      });

      container.appendChild(clone);
      questionCount++;
    }

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