<?php
  // Get the user
  include_once(dirname(__DIR__) . '/_config.php');
  if (session_status() === PHP_SESSION_NONE) session_start();
  if (!ADMIN) redirect(base_path);
  // Get the user if admin and they've passed a get request id
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  $sql = "SELECT * FROM movies WHERE id=:id"; // sql string
  $stmt = $conn->prepare($sql); // prepare the sql and return the prepared statement
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute(); // execute the statement
  $movies = $stmt->fetch();
  $stmt->closeCursor();
  // Admins can't delete themselves
  
  // Destroy the user
  $sql = "DELETE FROM movies WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $movies['id']);
  $stmt->execute();
  
  //redirect_with_success(base_path . "/movies", "You have successfully deleted the a");
  
  
  redirect_with_success(base_path . "/movies", "You have successfully deleted " . $movies['movie_name']);