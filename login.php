<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=invoice_manager';
$username = "root";
$password = "970426";

try {
  $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  $error = $e->getMessage();
  echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <h1>Login</h1>
  <form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
  </form>
  <?php if (isset($error)) : ?>
    <p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>
  <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>

</html>