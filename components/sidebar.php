<?php function sidebar()
{ ?>
  <div class="sidebar">
    <div class="sidebar-action">
      <h3>Kursus Mobil</h3>
      <button class="toggle-btn" onclick="toggleSidebar()">
        <ion-icon name="menu"></ion-icon>
      </button>
    </div>
    <a href="../dashboard.php">Dashboard</a>
    <?php if ($_SESSION['roles'] == "admin"): ?>
      <button class="dropdown" onclick="toggleDropdown()">Kelola <span>▼</span></button>
      <div class="dropdown-content" id="dropdown-content">
        <a href="../students/index.php">Pengemudi</a>
        <a href="../instructors/index.php">Instruktur</a>
        <a href="../courses/index.php">Kursus</a>
        <a href="../cars/index.php">Mobil</a>
      </div>
      <a href="#">Laporan</a>
    <?php elseif ($_SESSION['roles'] == "instructor"): ?>
      <a href="#">Jadwal</a>
      <a href="">Penilaian</a>
    <?php else: ?>
      <a href="#">Jadwal</a>
      <a href="#">Penilaian</a>
      <a href="#">Sertifikat</a>
    <?php endif ?>
  </div>
<?php } ?>