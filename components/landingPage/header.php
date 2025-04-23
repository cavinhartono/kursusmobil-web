<?php function headerLogo()
{ ?>
  <header id="header" class="header">
    <a href="../../index.php" class="logo">
      <div class="icon"><ion-icon name="id-card"></ion-icon></div>
      Kursus Mobil <br> Indonesia Mandiri
    </a>
    <ul class="nav">
      <li class="list active"><a href="" class="link">Berada</a></li>
      <li class="list"><a href="" class="link">Materi</a></li>
      <li class="list"><a href="" class="link">Tentang</a></li>
    </ul>
    <ul class="action">
      <li class="list">
        <?php

        $action = isset($_SESSION['auth']) ? "../../auth/logout.php" : "../../auth/login.php";

        ?>
        <a href="<?= $action ?>" class="btn">
          <?php if (isset($_SESSION['auth'])): ?>
            <?= $_SESSION['name'] ?>
          <?php else: ?>
            Masuk
          <?php endif ?>

        </a>
      </li>
      <li class="list"><a href="#" class="btn primary">Ambil Lisensi</a></li>
    </ul>
  </header>
<?php } ?>