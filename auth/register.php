<?php
include_once("../database/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $phoneNumber = $_POST['phone'];

    $connect->query("INSERT INTO Users(roles, name, email, password, phone) VALUES ('student', '$name', '$email', '$password', '$phoneNumber')");

    header("location: ../index.php");
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Register E-Learning</title>
</head>

<body>
  <h2>Register E-Learning Driving School</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    Email: <input type="email" name="email" required><br>
    Nama Lengkap: <input type="text" name="name" required><br>
    No. Telpon: <input type="text" name="phone" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="submit">Buat</button>
  </form>
</body>

</html>