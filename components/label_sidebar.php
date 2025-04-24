<?php function labelSidebar($title)
{ ?>
  <div class='fixed-header'>
    <h2><?= $title ?></h2>
    <a href="../auth/logout.php" class="link">
      Logout
      <ion-icon name="log-out-outline"></ion-icon>
    </a>
  </div>
<?php } ?>