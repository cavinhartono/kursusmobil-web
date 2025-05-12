<!DOCTYPE html>
<html lang="en">

<?php
session_start();

include_once("../../database/connect.php");

foreach (glob("../../components/*.php") as $file) {
  require $file;
}

$id = $_GET['id'];

$course = $connect->query("SELECT name, quiz_json FROM Courses WHERE id = $id")->fetch_object();

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
    <?php labelSidebar("Edit Soal Ujian Praktik"); ?>
    <div class="content-body">
      <div class="container">
        <form method="POST" action="store.php" onsubmit="return generateJSON()">
          <input type="hidden" name="course_id" value="<?= $id ?>">
          <div id="kategori-container"></div>
          <button type="button" onclick="addKategori()">+ Kategori</button>
          <input type="hidden" name="quiz_json" id="quiz_json">
          <button type="submit" name="exam">Update</button>
        </form>
      </div>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    let Categories = <?= json_encode(json_decode($course->quiz_json, true)) ?>;
    let categoryCount = 0;

    function renderForm() {
      Categories.forEach((category, idx) => {
        addKategori(category.category, category.items);
      });
    }

    function addKategori(categoryName = '', items = []) {
      const container = document.getElementById('kategori-container');
      const wrapper = document.createElement('div');
      wrapper.innerHTML = `
    <hr>
    <label>Kategori:</label>
    <input type="text" name="categories[${categoryCount}]" value="${categoryName}" required><br>
    <div id="items-${categoryCount}"></div>
    <button type="button" onclick="addItem(${categoryCount})">+ Item</button>
  `;
      container.appendChild(wrapper);
      const itemContainer = wrapper.querySelector(`#items-${categoryCount}`);
      items.forEach(item => {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `item[${categoryCount}][]`;
        input.value = item;
        itemContainer.appendChild(input);
      });

      if (items.length === 0) {
        addItem(categoryCount);
      }

      categoryCount++;
    }

    function addItem(index) {
      const div = document.getElementById(`items-${index}`);
      const input = document.createElement('input');
      input.type = "text";
      input.name = `item[${index}][]`;
      input.placeholder = "Checklist item";
      div.appendChild(input);
    }

    function generateJSON() {
      const form = document.forms[0];
      const category = form.querySelectorAll('[name^="categories"]');
      const soal = [];

      category.forEach((el, idx) => {
        const name = el.value;
        const items = Array.from(form.querySelectorAll(`[name="item[${idx}][]"]`))
          .map(i => i.value).filter(v => v.trim() !== "");
        soal.push({
          category: name,
          items: items
        });
      });

      document.getElementById('quiz_json').value = JSON.stringify(soal);
      return true;
    }

    window.onload = renderForm;
  </script>

</body>

</html>