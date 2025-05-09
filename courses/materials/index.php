<?php
function modalForMaterial($type, $fields = [], $actionName = '', $id = '', $values = [])
{
  $modalId = $type . 'Modal' . ($id ? $id : '');
  $submitName = $type === 'create' ? 'add' : 'update';
  $action = getFormAction($type);
?>
  <div id="<?= $modalId ?>" class="modal">
    <div class="modal-content">
      <span class="modal-close" onclick="closeModal('<?= $modalId ?>')">&times;</span>
      <h3>
        <?php switch ($type):
          case 'create': ?>
            <?= "Tambah Data $actionName" ?>
            <?php break; ?>
          <?php
          default: ?>
            <?= "Edit Data $actionName" ?>
            <?php break; ?>
        <?php endswitch ?>
      </h3>
      <form action="<?= $action ?>" method="POST" onsubmit="return submitForm()">
        <?php if ($type === 'update'): ?>
          <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        <?php foreach ($fields as $field): ?>
          <?php if ($field['name'] === 'content'): ?>
            <label><?= $field['label'] ?>:</label>
            <div id="editor"></div>
            <input type="hidden" name="content" id="content">
          <?php elseif ($field['type'] === 'hidden'): ?>
            <input type="hidden" name="<?= $field['name'] ?>" value="<?= $field['value'] ?>">
          <?php else: ?>
            <label><?= $field['label'] ?>:</label>
            <input
              type="<?= $field['type'] ?>"
              name="<?= $field['name'] ?>"
              required>
          <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" name="<?= $submitName ?>" class="btn primary"><ion-icon name="checkmark"></ion-icon></button>
      </form>
    </div>
  </div>
<?php } ?>

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
  <title><?= $course->name ?></title>
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="stylesheet" href="../../assets/js/quilljs/quill.snow.css">
  <style>
    .modal-content {
      width: 900px !important;
    }
  </style>
</head>

<body>
  <?php
  $fields = [
    ['name' => 'course_id', 'value' => $course_id, 'type' => 'hidden'],
    ['name' => 'order_index', 'label' => 'Kode Materi', 'type' => 'text'],
    ['name' => 'title', 'label' => 'Judul', 'type' => 'text'],
    ['name' => 'content', 'label' => 'Isi Materi'],
  ];
  modalForMaterial('create', $fields, 'Materi');
  ?>

  <?php sidebar() ?>
  <div class="content">
    <?php labelSidebar("Materi untuk $course->name"); ?>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <button class="btn primary" onclick="openModal('createModal')"><ion-icon name="add"></ion-icon></button>
          <input type="text" id="searchInput" placeholder=" Pencarian Nama">
        </div>
        <div class="dataTable">
          <table id="dataTable">
            <thead>
              <tr>
                <th width="120">#</th>
                <th>Nama Materi</th>
                <th style="text-align: center;">Tanggal Dibuat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <?php
            $Materials = $connect->query("SELECT * FROM Materials WHERE course_id = $course_id");

            $editData = null;
            if (isset($_GET['edit'])) {
              $id = (int) $_GET['edit'];
              $data = mysqli_query($connect, "SELECT * FROM Materials WHERE id = $id")->fetch_assoc();

              if ($data) {
                modalForMaterial("update", $fields, "Materi", $id, $data);
                echo "<script>window.onload = () => openModal('updateModal$id');</script>";
              }
            }

            if (isset($_GET['delete'])) {
              $id = $_GET['delete'];
              $connect->query("DELETE FROM Materials WHERE id=$id");

              header("Location: index.php");
            }
            ?>
            <tbody>
              <?php while ($material = mysqli_fetch_object($Materials)): ?>
                <tr>
                  <td><?= $material->order_index ?></td>
                  <td><?= $material->title ?></td>
                  <td style="text-align: center;"><?= timeAgo($material->uploaded_at) ?></td>
                  <td>
                    <a href="?id=<?= $course_id ?>&edit=<?= $material->id ?>" class="btn warning"><ion-icon name="create-outline"></ion-icon></a>
                    <a href="?id=<?= $course_id ?>&delete=<?= $material->id ?>" class="btn danger" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-bin-outline"></ion-icon></a>
                    <a href="view.php?id=<?= $course_id ?>&page=<?= $material->id ?>" class="btn danger">View</a>
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php if ($_SESSION['roles'] !== 'admin'): ?>
    <script>
      alert('Anda bukan Admin');
      window.location.href = '../../dashboard.php';
    </script>
  <?php endif ?>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../../assets/js/quilljs/quill.min.js"></script>
  <script>
    var quill = new Quill('#editor', {
      theme: 'snow'
    });

    function submitForm() {
      document.getElementById('content').value = quill.root.innerHTML;
      return true;
    }
  </script>
  <script src="../../assets/js/script.js"></script>
</body>

</html>