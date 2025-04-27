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
      header("Location: login.php");
      $error = "Email dan password tidak sesuai.";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login E-Learning</title>
</head>

<body>
  <h2>Login</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="submit">Login</button>
  </form>
</body>

</html>