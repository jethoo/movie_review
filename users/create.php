<?php
// Add the connection script
  include_once(dirname(__DIR__) . '/_config.php');
  // If the user is attempting to create a new user while logged in
  // and they are not an administrator then we'll redirect them
  if (AUTH && !ADMIN) {
    redirect(base_path . '/users/show.php?id=' . $_SESSION['user']['id']);
  }
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  // Create a message system
  if (session_status() === PHP_SESSION_NONE) session_start();
  $_SESSION['flash'] = [];
  /*
    Validation will ensure the user enters in our required
    fields and in the required format
  */
  $errors = [];
  // Verify the following aren't empty
  $required = ['user_name', 'full_name', 'email', 'password', 'password_confirmation'];
  foreach ($required as $field) {
    if (empty($_POST[$field])) { // Variable variables allow us to use strings to access a variable name
      $formatted = ucfirst(str_replace("_", " ", $field)); // Format it into human readable
      $errors[] = "{$formatted} cannot be empty."; // Add a new error to the array
    }
  }
  // Verify that the email is in the correct format
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Your email is not in a valid format";
  
  // Verify that the password and password_confirmation match
  if ($_POST['password'] !== $_POST['password_confirmation']) $errors[] = "Your password and password confirmation must match";
  // Return to the form if there are errors (we do this here because we don't want to run malicious code against our database)
  if (count($errors) > 0) { // count the array
    $_SESSION['flash']['danger'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: ' . base_path . '/users/new.php'); // redirect back to the form
    exit; // we must exit or the script will continue to run
  }
  /* End of validation */
  /*
    Sanitization will prevent data that isn't permitted
    from being entered into our database
  */
  // Sanitize the email
  $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  // Sanitize the other two fields
  // (Below is a single line foreach statement. This can be done if the block only has one statement)
  foreach(['user_name', 'full_name'] as $field) $_POST[$field] = filter_var($_POST[$field], FILTER_SANITIZE_STRING);
  /* End of sanitization */
  // Users need to be unique, so check if the email already exists
  $sql = "SELECT email FROM users WHERE email = :email"; // a string containing our SQL
  $stmt = $conn->prepare($sql); // prepare the statement to avoid SQL injection attacks
  $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR); // bind the parameter (enforce it's a string)
  $stmt->execute(); // execute our statement
  $exists = $stmt->fetch(); // fetch the results
  $stmt->closeCursor(); // close the connection cursor so it can await a new statement
  // Check if the user exists and call an error if it does
  if ($exists) $errors[] = 'This user already exists.';
  // Return errors
  if (count($errors) > 0) { // count the array
    $_SESSION['flash']['danger'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: ' . base_path . '/users/new.php'); // redirect back to the form
    exit; // we must exit or the script will continue to run
  }

    $role = 'general';

    $filename = $_FILES["file_upload"]["name"] ; //select file from computer
    $tempname = $_FILES["file_upload"]["tmp_name"] ; //FILES php function temporarily stores that file in memory
    $folder = ROOT . '/assets/image/'.$filename ; // define location to move the file
    move_uploaded_file($tempname,$folder); // this function moves the file to desired location
    $picPathForDatabase = '/assets/image/'.$filename; //I defined this for easy file name in database
 

  // Attempt to write the user to the database
  $sql = "INSERT INTO users (username, fullname, email, password , profile_Pic, role) VALUES (
    :user_name,
    :full_name,
    :email,
    :password,
    :folder,
    :role
  )"; // a string containing our SQL
    
 
  // Hash password
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  // Bind Parameters
  $stmt = $conn->prepare($sql); // prepare the statement
  $stmt->bindParam(':user_name', $_POST['user_name'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':full_name', $_POST['full_name'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':folder', $picPathForDatabase, PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':password', $password, PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':role', $role, PDO::PARAM_STR); // bind the parameter
  $stmt->execute(); // execute
  // Close our connection
  $conn = null;
  // Send back our success message
  $_SESSION['flash']['success'][] = "User was registered successfully";
  header('Location: ' . base_path . '/index.php'); // redirect to an index page
  exit; // we must exit or the script will continue to run
