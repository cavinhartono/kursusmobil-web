<?php function sidebar()
{ ?>
  <?php $current = $_SERVER['REQUEST_URI']; ?>
  <div class="sidebar">
    <div class="sidebar-action">
      <h3>Kursus Mobil</h3>
      <button class="toggle-btn" onclick="toggleSidebar()">
        <ion-icon name="menu"></ion-icon>
      </button>
    </div>
    <a href="/dashboard.php" class="<?= str_contains($current, '/dashboard.php') ? 'active' : '' ?>">Dashboard</a>
    <?php if ($_SESSION['roles'] === "admin"): ?>
      <a href="/list_transaction.php" class="<?= str_contains($current, '/list_transaction.php') ? 'active' : '' ?>">Transaksi</a>
      <button class="dropdown" onclick="toggleDropdown()">Kelola <span>▼</span></button>
      <div class="dropdown-content" id="dropdown-content">
        <a href="/students/index.php" class="<?= str_contains($current, '/students') ? 'active' : '' ?>">Pengemudi</a>
        <a href="/instructors/index.php" class="<?= str_contains($current, '/instructors') ? 'active' : '' ?>">Instruktur</a>
        <a href="/courses/index.php" class="<?= str_contains($current, '/courses') ? 'active' : '' ?>">Kursus</a>
        <a href="/cars/index.php" class="<?= str_contains($current, '/cars') ? 'active' : '' ?>">Mobil</a>
      </div>
      <a href="/reports.php" class="<?= str_contains($current, '/reports') ? 'active' : '' ?>">Laporan</a>
    <?php elseif ($_SESSION['roles'] === "instructor"): ?>
      <a href="/schedule.php" class="<?= str_contains($current, '/schedule') ? 'active' : '' ?>">Jadwal</a>
      <a href="/grades.php" class="<?= str_contains($current, '/grades') ? 'active' : '' ?>">Penilaian</a>
    <?php else: ?>
      <a href="/schedule.php" class="<?= str_contains($current, '/schedule') ? 'active' : '' ?>">Jadwal</a>
      <a href="/grades.php" class="<?= str_contains($current, '/grades') ? 'active' : '' ?>">Penilaian</a>
      <a href="/certificate.php" class="<?= str_contains($current, '/certificate') ? 'active' : '' ?>">Sertifikat</a>
    <?php endif ?>
  </div>
<?php } ?>