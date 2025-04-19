<?php
include_once("../database/connect.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $statement = mysqli_query($connect, "SELECT * FROM Users WHERE email = '$email'");
  $result = $statement->fetch_object();

  if (isset($result)) {
    if (password_verify($password, $result->password)) {
      $_SESSION['user_id'] = $result->id;
      $_SESSION['roles'] = $result->roles;

      switch ($result['roles']) {
        case 'instructor':
          echo "Selamat Datang, Instruktur";
          break;
        case 'student':
          echo "Hola, Supir";
          break;
      }
      exit();
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Email tidak ditemukan.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login E-Learning</title>
</head>

<body>
  <h2>Login E-Learning Driving School</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
  </form>
</body>

</html>