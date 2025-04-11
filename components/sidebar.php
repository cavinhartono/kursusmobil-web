<?php function sidebar()
{ ?>
  <div class="sidebar">
    <div class="sidebar-action">
      <h3>Kursus Mobil</h3>
      <button class="toggle-btn" onclick="toggleSidebar()">
        <span class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
            <line x1="88" y1="152" x2="424" y2="152" style="fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:48px" />
            <line x1="88" y1="256" x2="424" y2="256" style="fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:48px" />
            <line x1="88" y1="360" x2="424" y2="360" style="fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:48px" />
          </svg>
        </span>
      </button>
    </div>
    <a href="../dashboard.php">Dashboard</a>
    <button class="dropdown" onclick="toggleDropdown()">Kelola <span>▼</span></button>
    <div class="dropdown-content" id="dropdown-content">
      <a href="../students/index.php">Pengemudi</a>
      <a href="../instructors/index.php">Instruktur</a>
      <a href="../courses/index.php">Kursus</a>
      <a href="../cars/index.php">Mobil</a>
    </div>
    <a href="#">Jadwal (User)</a>
    <a href="#">Penilaian (User)</a>
    <a href="#">Sertifikat (User)</a>
    <a href="#">Laporan</a>
  </div>
<?php } ?>