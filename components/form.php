<?php function form($title, $fields, $data = [], $action = './store.php')
{ ?>
  <div id="modalForm" class="modal">
    <form method="POST" action="<?= $action ?>" class="modal-content">
      <span class="close" onclick="document.querySelector('#modalForm').style.display = 'none'">&times;</span>
      <h3><?= $title ?></h3>

      <?php foreach ($fields as $field): ?>
        <div class="form-group">
          <label for="<?= $field['label'] ?>" style="text-transform: capitalize;"><?= $field['title'] ?></label>
          <input
            type="<?= $field['type'] ?>"
            name="<?= $field['label'] ?>"
            id="<?= $field['label'] ?>"
            value="<?= $data[$field['label']] ?? '' ?>"
            required>
        </div>
      <?php endforeach ?>

      <?php if (!empty($data['id'])): ?>
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <?php endif; ?>

      <button type="submit" name="submit" class="btn primary">Simpan</button>
    </form>
  </div>
<?php } ?>