<?php function sidebar()
{ ?>
  <div class="sidebar">
    <div class="sidebar-action">
      <h3>Kursus Mobil</h3>
      <button class="toggle-btn" onclick="toggleSidebar()">Menu</button>
    </div>
    <a href="/dashboard.php">Dashboard</a>
    <button class="dropdown" onclick="toggleDropdown()">Kelola ▼</button>
    <div class="dropdown-content" id="dropdown-content">
      <a href="/students/index.php">Pengemudi</a>
      <a href="/instructor/index.php">Instruktur</a>
      <a href="/course/index.php">Kursus</a>
    </div>
    <a href="#">Jadwal</a>
    <a href="#">Penilaian</a>
    <a href="#">Sertifikat</a>
    <a href="#">Laporan</a>
  </div>
<?php } ?>