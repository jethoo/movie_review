<?php

  // Add the connection script
  if (session_status() === PHP_SESSION_NONE) session_start();
  include_once(dirname(__DIR__) . '/_config.php');
  // User's can't update their profile unless logged in
  // User's can't update other users profiles unless they're administrators
  if (!AUTH || (AUTH && $_POST['id'] !== $_SESSION['user']['id'] && !ADMIN)) {
    redirect(base_path);
  }
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  /*
    Validation will ensure the user enters in our required
    fields and in the required format
  */
  $errors = [];
  // Verify the following aren't empty
  $required = ['user_name', 'full_name', 'email'];
  foreach ($required as $field) {
    if (empty($_POST[$field])) { // Variable variables allow us to use strings to access a variable name
      $formatted = ucfirst(str_replace("_", " ", $field)); // Format it into human readable
      $errors[] = "{$formatted} cannot be empty."; // Add a new error to the array
    }
  }
  // Verify that the email is in the correct format
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Your email is not in a valid format";
  // Return to the form if there are errors (we do this here because we don't want to run malicious code against our database)
  if (count($errors) > 0) { // count the array
    $_SESSION['form_data'] = $_POST;
    redirect_with_errors(base_path . "/users/edit.php?id=" . $_POST['id'], $errors, 'danger');
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
  // Get the user we're editing
  $sql = "SELECT * FROM users WHERE id = :id"; // a string containing our SQL
  $stmt = $conn->prepare($sql); // prepare the statement to avoid SQL injection attacks
  $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_STR); // bind the parameter (enforce it's a string)
  $stmt->execute(); // execute our statement
  $user = $stmt->fetch(); // fetch the results
  // If we're attempting to change the email, we need to verify it doesn't already exist
  if ($_POST['email'] !== $user['email'] && !ADMIN) {
    $sql = "SELECT email FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();
    if (!empty($stmt->fetch())) $errors[] = "This email is unavailable";
  }
  $stmt->closeCursor(); // close the connection cursor so it can await a new statement
  // Return errors
  if (count($errors) > 0) { // count the array
    $_SESSION['form_data'] = $_POST;
    redirect_with_errors(base_path . "/users/edit?id=" . $_POST['id'], $errors);
  }
  // Attempt to write the user to the database
  $sql = "UPDATE users SET username = :username, fullname = :fullname, email = :email, role = :role, profile_Pic = :folder"; // a string containing our SQL
  if (!empty($_POST['password'])) {
    if ($_POST['password'] === $_POST['password_confirmation']) {
      $sql = $sql . ", password = :password";
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
      $errors[] = "You're password must match password confirmation";
      redirect_with_errors(base_path . "/users/edit.php?id=" . $_POST['id'], $errors);
    }
  }
  $sql = $sql . " WHERE id = :id";
  
  $role = 'general'; //default role for all the users

  
    //to update profile picture
    if(!empty($_FILES['file_upload']['name'])){
        $filename = $_FILES["file_upload"]["name"]; //select file from computer
        $tempname = $_FILES["file_upload"]["tmp_name"] ; //FILES php function temporarily stores that file in memory
        $folder = ROOT . '/assets/image/'.$filename ; // define location to move the file
        move_uploaded_file($tempname,$folder); // this function moves the file to desired location
        $picPathForDatabase = '/assets/image/'.$filename; //I defined this for easy file name in database
    }
    //else{
       // $picPathForDatabase = $_SESSION['user']['profile_Pic'];?
    //}
    

  // Bind Parameters
  $stmt = $conn->prepare($sql); // prepare the statement
  $stmt->bindParam(':username', $_POST['user_name'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':fullname', $_POST['full_name'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':role', $role, PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
  $stmt->bindParam(':folder', $picPathForDatabase , PDO::PARAM_STR); // bind the parameter
  

  if (isset($password)) $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute(); // execute
  // Close our connection
  $conn = null;
  // Make sure you repull the user's details if they just modified their profile
  unset($_POST['password']);
  if ($_POST['id'] === $_SESSION['user']['id']) {
    $_SESSION['user'] = array_merge($_SESSION['user'], $_POST);
  }
  
  redirect_with_success(base_path . "/users/show.php?id=" . $_POST['id'], "User was updated successfully");
  
  
