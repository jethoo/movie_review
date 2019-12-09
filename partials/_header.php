<?php
  // Include our common config file
  include_once(dirname(__DIR__) . "/_config.php");
  // Start the session
  if (session_status() === PHP_SESSION_NONE) session_start();
  // Assign the session variables
  $flash_data = $_SESSION['flash'] ?? null;
  $form_data = $_SESSION['form_data'] ?? null;
  // Clear the session variables so it's blank the next time
  unset($_SESSION['flash']);
  unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html>
  <head>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title><?= $_title ?? "Big Screen Review" ?></title>
    <link rel="stylesheet" href="<?= base_path ?>/css/main.css"/>
  </head>

  <body>
    <?php include(ROOT . '/partials/_main-nav.php') ?>
    <?php include(ROOT . '/partials/_flash.php') ?>