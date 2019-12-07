<?php
  include_once(dirname(__DIR__) . '/_config.php');
  include_once(ROOT . '/includes/_connect.php');
  $conn = connect();
  // Create a message system
  if (session_status() === PHP_SESSION_NONE) session_start();
  $_SESSION['flash'] = [];
  // Validate the user supplied email
  $valid_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  // Sanitize the user supplied email
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  /*
    You'll notice we're not passing the password to our SQL query.
    This is intentional. The password can contain illegal characters
    in order to make it more secure. Because of this, we can't sanitize
    it. Because we can't sanitize it we don't want to pass it to the database.
    Instead we'll just evaluate the returned user against the password they're
    attempting.
  */
  // Check if the user exists in the database
  $sql = "SELECT * FROM users WHERE email = :email"; // using variables to properly bind
  $stmt = $conn->prepare($sql); // preparing our sql
  $stmt->bindParam(":email", $email, PDO::PARAM_STR); // binding our parameter
  $stmt->execute(); // executing the sql statement
  $user = $stmt->fetch(); // forces the return to be a boolean value
  // Check the user exists and the password is correct
// Check the user exists and the password is correct

    if (!$user || !password_verify($_POST['password'], $user['password'])) { // password_verify will evalute the password against the hash and see if they match
        $_SESSION['flash']['danger'][] = "The email or password is incorrect."; // Security by obscurity! Don't give more information than absolutely necessary
        $_SESSION['form_data']['email'] = $_POST['email'];
        header('Location: ' . base_path . '/sessions/login.php'); // redirect back to the form
        exit; // we must exit or the script will continue to run
    }
    // Set a session variable to verify the user is authenticated
    unset($user['password']);
    $_SESSION['user'] = $user;
    // Return the user to their profile page
    $_SESSION['flash']['success'][] = "You logged in successfully";
    header('Location: ' . base_path . '/movies'); // redirect to an index page
    exit; // we must exit or the script will continue to run


