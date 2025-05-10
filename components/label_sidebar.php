<?php function labelSidebar($title)
{ ?>
  <div class='fixed-header'>
    <h2><?= $title ?></h2>
    <a href="/auth/logout.php" class="link <?= str_contains($_SERVER['REQUEST_URI'], '/auth/logout.php') ? 'active' : '' ?>">
      <?php if (isset($_SESSION['auth'])): ?>
        <?= $_SESSION['name'] ?>
      <?php endif ?>
      <ion-icon name="log-out-outline"></ion-icon>
    </a>
  </div>
<?php } ?>