<?php function isAdmin()
{ ?>
  <?php if ($_SESSION['roles'] !== "admin"): ?>
    <script>
      alert('Anda bukan Admin');
      window.location.href = '../dashboard.php';
    </script>
  <?php endif ?>
<?php } ?>