<?php
include_once("../database/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $phoneNumber = $_POST['phone'];

    $connect->query("INSERT INTO Users(roles, name, email, password, phone) VALUES ('student', '$name', '$email', '$password', '$phoneNumber')");

    header("location: login.php");
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Kursus Mobil</title>
  <link rel="stylesheet" href="../assets/css/auth/style.css">
</head>

<body>
  <div class="container">
    <h2 class="title">Buat Akun</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" class="form">
      <div class="field">
        <label for="email">Email:<sup>*</sup></label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="field">
        <label for="name">Nama Lengkap:<sup>*</sup></label>
        <input type="text" name="name" id="name" required>
      </div>
      <div class="field">
        <label for="phone">No. Telpon:<sup>*</sup></label>
        <input type="text" name="phone" id="phone" required>
      </div>
      <div class="field">
        <label for="password">Password:<sup>*</sup></label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="action">
        <a href="./login.php" class="btn">Masuk Akun</a>
        <button type="submit" name="submit" class="btn primary">Buat <ion-icon name="arrow-forward-outline"></ion-icon></button>
      </div>
    </form>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>