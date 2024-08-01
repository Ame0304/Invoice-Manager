<?php
$dsn = 'mysql:host=localhost;dbname=invoice_manager';
$username = "root";
$password = "root";

try {
  $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  $error = $e->getMessage();
  echo $error;
  exit();
}

$result = $db->query("SELECT * FROM statuses");
$statuses = $result->fetchAll(PDO::FETCH_COLUMN, 1);
