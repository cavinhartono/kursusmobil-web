<?php function headerLogo()
{ ?>
  <header id="header" class="header">
    <a href="../../index.php" class="logo">
      <div class="icon"><ion-icon name="id-card"></ion-icon></div>
      Kursus Mobil <br> Indonesia Mandiri
    </a>
    <ul class="nav">
      <li class="list active"><a href="" class="link">Berada</a></li>
      <li class="list"><a href="../../courses/all.php" class="link">Kursus</a></li>
      <li class="list"><a href="" class="link">Tentang</a></li>
    </ul>
    <ul class="action">
      <li class="list">
        <a href="<?= isset($_SESSION['auth']) ? '../../auth/logout.php' : '../../auth/login.php' ?>" class="btn">
          <?php if (isset($_SESSION['auth'])): ?>
            <?= $_SESSION['name'] ?>
          <?php else: ?>
            Masuk
          <?php endif ?>
        </a>
      </li>
      <li class="list">
        <a href="<?= isset($_SESSION['auth']) ? '../../dashboard.php' : '../../auth/register.php' ?>" class="btn primary">
          <?php if (isset($_SESSION['auth'])): ?>
            Dashboard
          <?php else: ?>
            Registrasi
          <?php endif ?>
        </a>
      </li>
    </ul>
  </header>
<?php } ?>