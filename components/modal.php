<?php
function getFormAction($type)
{
  $fileName = $type === 'create' ? 'store.php' : 'update.php';
  return "./$fileName";
}


function modal($type, $fields = [], $actionName = '', $id = '', $values = [])
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
      <form action="<?= $action ?>" method="POST">
        <?php if ($type === 'update'): ?>
          <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        <?php foreach ($fields as $field): ?>
          <?php $value = $values[$field['name']] ?? ''; ?>
          <?php if ($field['type'] === 'select'): ?>
            <label><?= $field['label'] ?>:</label>
            <select name="<?= $field['name'] ?>" required>
              <?php foreach ($field['options'] as $option): ?>
                <option value="<?= $option ?>" style="text-transform: capitalize" <?= $value == $option ? 'selected' : '' ?>>
                  <?= $option ?>
                </option>
              <?php endforeach; ?>
            </select>
          <?php elseif ($field['type'] === 'radio'): ?>
            <label><?= $field['label'] ?>:</label>
            <?php foreach ($field['options'] as $option): ?>
              <label>
                <input type="radio" name="<?= $field['name'] ?>" value="<?= $option ?>" <?= $value == $option ? 'checked' : '' ?> required>
                <?= ucfirst($option) ?>
              </label>
            <?php endforeach; ?>
          <?php else: ?>
            <label><?= $field['label'] ?>:</label>
            <input
              type="<?= $field['type'] ?>"
              name="<?= $field['name'] ?>"
              value="<?= ($field['name'] === "password") ? '' : htmlspecialchars($value) ?>"
              required>
          <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" name="<?= $submitName ?>" class="btn primary"><ion-icon name="checkmark"></ion-icon></button>
      </form>
    </div>
  </div>
<?php } ?>