<?php
  include_once(dirname(__DIR__) . '/_config.php');
  if (session_status() === PHP_SESSION_NONE) session_start();
  // Unset the session variable we're using to check if the user is logged in
  unset($_SESSION['user']);
  // Return the user to the home page of the site
  $_SESSION['flash'] = [];
  $_SESSION['flash']['success'][] = "You've logged out successfully";
  header('Location: ' . base_path . '');
  exit;