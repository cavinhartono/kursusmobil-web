<?php function form($title, $fields)
{ ?>
  <div id="modalForm" class="modal">
    <form method="POST" action="./store.php" class="modal-content">
      <span class="close" onclick="document.querySelector('#modalForm').style.display = 'none'">&times;</span>
      <h3><?= $title ?></h3>
      <?php foreach ($fields as $field): ?>
        <div class="form-group">
          <label for="<?= $field['label'] ?>" style="text-transform: capitalize;"><?= $field['title'] ?></label>
          <input type="<?= $field['type'] ?>" name="<?= $field['label'] ?>" id="<?= $field['label'] ?>" required>
        </div>
      <?php endforeach ?>
      <!-- <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email">
      </div>
      <div class="form-group">
        <label for="phone">Nomor Telepon</label>
        <input type="number" id="phone">
      </div> -->
      <button type="submit" class="btn primary">Simpan</button>

    </form>
  </div>
<?php } ?>