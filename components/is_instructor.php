<?php function isInstructor()
{ ?>
  <?php if ($_SESSION['roles'] !== "instructor" || $_SESSION['roles'] !== 'admin'): ?>
    <script>
      alert('Anda bukan Instruktur');
      window.location.href = '../dashboard.php';
    </script>
  <?php endif ?>
<?php } ?>