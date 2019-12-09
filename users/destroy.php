<?php
  // Get the user
  include_once(dirname(__DIR__) . '/_config.php');
  if (session_status() === PHP_SESSION_NONE) session_start();
  if (!AUTH || ($_GET['id'] !== $_SESSION['user']['id'] && !ADMIN)) redirect(base_path);
  // Get the user if admin and they've passed a get request id
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  $sql = "SELECT * FROM users WHERE id=:id"; // sql string
  $stmt = $conn->prepare($sql); // prepare the sql and return the prepared statement
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute(); // execute the statement
  $user = $stmt->fetch();
  $stmt->closeCursor();
  // Admins can't delete themselves
  if (ADMIN && $user['id'] === $_SESSION['user']['id']) redirect_with_errors(base_path . "/users/show.php?id={$user['id']}", "Sorry Admin, You can't go!!");
  // Destroy the user
  $sql = "DELETE FROM users WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $user['id']);
  $stmt->execute();
  
  // Log them out and send them home if they destroyed themselves
  if ($user['id'] === $_SESSION['user']['id']) {
    unset($_SESSION['user']);
    redirect_with_success(base_path . "/", "You have successfully deleted your account");
  }
  // If the administrator deleted a user let them know they were deleted successfully
  redirect_with_success(base_path . "/users", "You have successfully deleted " . $user['first_name'] . " " . $user['last_name']);