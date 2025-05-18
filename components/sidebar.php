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
    <a href="/dashboard.php" class="link <?= str_contains($current, '/dashboard.php') ? 'active' : '' ?>"><ion-icon name="albums-outline"></ion-icon> Dashboard</a>
    <?php if ($_SESSION['roles'] === "admin"): ?>
      <a href="/list_transaction.php" class="link <?= str_contains($current, '/list_transaction.php') ? 'active' : '' ?>"><ion-icon name="swap-horizontal-outline"></ion-icon> Transaksi</a>
      <button class="dropdown" onclick="toggleDropdown()">
        <div class="link"><ion-icon name="server-outline"></ion-icon> Kelola</div>
        <span>▼</span>
      </button>
      <div class="dropdown-content" id="dropdown-content">
        <a href="/students/index.php" class="link <?= str_contains($current, '/students') ? 'active' : '' ?>"><ion-icon name="people-outline"></ion-icon> Pengemudi</a>
        <a href="/instructors/index.php" class="link <?= str_contains($current, '/instructors') ? 'active' : '' ?>"><ion-icon name="person-outline"></ion-icon> Instruktur</a>
        <a href="/courses/index.php" class="link <?= str_contains($current, '/courses') ? 'active' : '' ?>"><ion-icon name="book-outline"></ion-icon> Kursus</a>
        <a href="/cars/index.php" class="link <?= str_contains($current, '/cars') ? 'active' : '' ?>"><ion-icon name="car-sport-outline"></ion-icon> Mobil</a>
      </div>
      <a href="/reports.php" class="link <?= str_contains($current, '/reports') ? 'active' : '' ?>"><ion-icon name="copy-outline"></ion-icon> Laporan</a>
    <?php elseif ($_SESSION['roles'] === "instructor"): ?>
      <a href="/schedules/index.php" class="link <?= str_contains($current, '/schedules') ? 'active' : '' ?>"><ion-icon name="time-outline"></ion-icon> Jadwal Penilaian</a>
    <?php else: ?>
      <a href="/schedules" class="link <?= str_contains($current, '/schedules') ? 'active' : '' ?>"><ion-icon name="time-outline"></ion-icon> Jadwal</a>
      <a href="/certification/my_list.php" class="link <?= str_contains($current, '/certification') ? 'active' : '' ?>"><ion-icon name="school-outline"></ion-icon> Penilaian</a>
    <?php endif ?>
  </div>
<?php } ?>