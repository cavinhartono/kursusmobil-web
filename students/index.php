<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All List Students</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-action">
      <h3>Kursus Mobil</h3>
      <button class="toggle-btn" onclick="toggleSidebar()">Menu</button>
    </div>
    <a href="#">Dashboard</a>
    <button class="dropdown" onclick="toggleDropdown()">Kelola ▼</button>
    <div class="dropdown-content" id="dropdown-content">
      <a href="./index.php">Pengemudi</a>
      <a href="/instructor/index.php">Instruktur</a>
      <a href="/course/index.php">Kursus</a>
    </div>
    <a href="#">Jadwal</a>
    <a href="#">Penilaian</a>
    <a href="#">Sertifikat</a>
    <a href="#">Laporan</a>
  </div>
  <div class="content">
    <div class="fixed-header">
      <h2>Data Pengemudi</h2>
    </div>
    <div class="content-body">
      <div class="container">
        <div action="" class="inputBx">
          <a href="./create.php" class="btn primary">Tambah</a>
          <input type="text" placeholder="Pencarian Nama">
        </div>
        <div class="dataTable">
          <table>
            <thead>
              <tr>
                <th width="120">NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Terakhir Diakses</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>362379001</td>
                <td>Cavin Hartono</td>
                <td style="text-transform: lowercase;">cavin@gmail.com</td>
                <td>4 jam yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>362379002</td>
                <td>Fauzi Riza</td>
                <td style="text-transform: lowercase;">fauzi@gmail.com</td>
                <td>2 hari yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>362379003</td>
                <td>Kevin Hadi</td>
                <td style="text-transform: lowercase;">kevin@gmail.com</td>
                <td>1 bulan yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>362379004</td>
                <td>Fauzan</td>
                <td style="text-transform: lowercase;">fauzan@gmail.com</td>
                <td>3 bulan yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>362379005</td>
                <td>Fiki</td>
                <td style="text-transform: lowercase;">fiki@gmail.com</td>
                <td>4 bulan yang lalu</td>
                <td>
                  <a href="?action=edit">Edit</a>
                  <a href="?action=delete">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
    function toggleDropdown() {
      var dropdownContent = document.getElementById("dropdown-content");
      dropdownContent.style.display =
        dropdownContent.style.display === "block" ? "none" : "block";
    }

    function toggleSidebar() {
      var sidebar = document.querySelector(".sidebar");
      var content = document.querySelector(".content");
      sidebar.classList.toggle("collapsed");
      content.classList.toggle("collapsed");
    }
  </script>
</body>

</html>