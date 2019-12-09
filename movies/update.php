<?php

  // Add the connection script
  if (session_status() === PHP_SESSION_NONE) session_start();
  include_once(dirname(__DIR__) . '/_config.php');
  // User's can't update their profile unless logged in
  // User's can't update other users profiles unless they're administrators
  if (!AUTH || !ADMIN) {
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
  $required = ['movie_name', 'movie_year', 'movie_bio', 'movie_rating','stars', 'genre','director'];
  foreach($required as $field) {
    if (empty($_POST[$field])) {
      $formatted = str_replace("_", " ", $field);
      $formatted = ucwords($formatted);
      $errors[] = "{$formatted} is a required field.";
    }
  }

  // Return to the form if there are errors (we do this here because we don't want to run malicious code against our database)
  if (count($errors) > 0) { // count the array
    $_SESSION['form_data'] = $_POST;
    redirect_with_errors(base_path . "/movies/edit.php?id=" . $_POST['id'], $errors, 'danger');
  }
  /* End of validation */
  /*
    Sanitization will prevent data that isn't permitted
    from being entered into our database
  */
  
  // Sanitize the other two fields
  $_POST['movie_name'] = filter_var($_POST['movie_name'], FILTER_SANITIZE_STRING);
  $_POST['movie_year'] = filter_var($_POST['movie_year'], FILTER_SANITIZE_STRING);
  $_POST['movie_bio'] = filter_var($_POST['movie_bio'], FILTER_SANITIZE_STRING);
  $_POST['movie_rating'] = filter_var($_POST['movie_rating'], FILTER_SANITIZE_STRING);
  $_POST['stars'] = filter_var($_POST['stars'], FILTER_SANITIZE_STRING);
  $_POST['director'] = filter_var($_POST['director'], FILTER_SANITIZE_STRING);
  $_POST['genre'] = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);

  /* End of sanitization */
  // Get the user we're editing
  $sql = "SELECT * FROM movies WHERE id = :id"; // a string containing our SQL
  $stmt = $conn->prepare($sql); // prepare the statement to avoid SQL injection attacks
  $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_STR); // bind the parameter (enforce it's a string)
  $stmt->execute(); // execute our statement
  $movies = $stmt->fetch(); // fetch the results
  
  // Return errors
  if (count($errors) > 0) { // count the array
    $_SESSION['form_data'] = $_POST;
    redirect_with_errors(base_path . "/movies/edit?id=" . $_POST['id'], $errors);
  }
  // Attempt to write the user to the database
  $sql = "UPDATE movies SET movie_name = :movie_name, movie_year = :movie_year, movie_rating = :movie_rating, movie_bio = :movie_bio, 
  movie_img = :movie_img, stars = :stars, director = :director, genre = :genre"; // a string containing our SQL
  
  $sql = $sql . " WHERE id = :id";
  
  //to update profile picture
    if(!empty($_FILES['movie_img']['name'])){
        $filename = $_FILES["movie_img"]["name"]; //select file from computer
        $tempname = $_FILES["movie_img"]["tmp_name"] ; //FILES php function temporarily stores that file in memory
        $folder = ROOT . '/assets/image/'.$filename ; // define location to move the file
        move_uploaded_file($tempname,$folder); // this function moves the file to desired location
        $picPathForDatabase = '/assets/image/'.$filename; //I defined this for easy file name in database
    }
    

  // Bind Parameters
  $stmt = $conn->prepare($sql); // prepare the statement
  $stmt->bindParam(':movie_name', $_POST['movie_name'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':movie_year', $_POST['movie_year'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':movie_rating', $_POST['movie_rating'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':movie_bio', $_POST['movie_bio'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':movie_img', $picPathForDatabase, PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':stars', $_POST['stars'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':director', $_POST['director'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':genre', $_POST['genre'], PDO::PARAM_STR); // bind the parameter
  $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);

  //if (isset($password)) $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute(); // execute
  // Close our connection
  $conn = null;
  // Make sure you repull the user's details if they just modified their profile
 
  redirect_with_success(base_path . "/movies/show.php?id=" . $_POST['id'], "Movie was updated successfully");
  
  
