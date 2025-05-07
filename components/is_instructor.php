<?php function isAdmin()
{ ?>
  <?php if ($_SESSION['roles'] !== "instructor"): ?>
    <script>
      alert('Anda bukan Instruktur');
      window.location.href = '../dashboard.php';
    </script>
  <?php endif ?>
<?php } ?>