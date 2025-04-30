<?php
include_once("../database/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $connect->query("SELECT * FROM Users WHERE email = '$email'");
    $auth = $statement->fetch_object();

    if ($auth && password_verify($password, $auth->password)) {
      $_SESSION['auth'] = $auth->id;
      $_SESSION['name'] = explode(" ", $auth->name)[0];
      $_SESSION['roles'] = $auth->roles;

      switch ($_SESSION['roles']) {
        case 'admin':
          header("Location: ../dashboard.php");
          break;
        case 'instructor':
          header("Location: ../dashboard.php");
          break;
        case 'student':
          header("Location: ../index.php");
          break;
      }
    } else {
      $error = "Email dan password tidak sesuai.";
      header("Location: login.php");
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/auth/style.css">
  <title>Login - Kursus Mobil</title>
</head>

<body>
  <div class="container">
    <h2 class="title">Masuk Akun</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" class="form">
      <div class="field">
        <label for="email">Email:<sup>*</sup></label>
        <input type="email" name="email" id="email" placeholder="user@email.com" required>
      </div>
      <div class="field">
        <label for="password">Password:<sup>*</sup></label>
        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required>
      </div>
      <div class="action">
        <a href="./register.php" class="btn">Buat Akun</a>
        <button type="submit" class="btn primary" name="submit">Lanjut</button>
      </div>
    </form>
  </div>
</body>

</html>