<?php
  include_once(dirname(__DIR__) . '/_config.php');
  not_admin_redirect(base_path . '/movies');
  $errors = []; // For errors
  /*
    Validate you have all the required fields:
    title, status, and the user_id (content can be blank)
  */
  $required = ['movie_name', 'movie_year', 'movie_bio', 'movie_rating','stars', 'genre','director'];
  foreach($required as $field) {
    if (empty($_POST[$field])) {
      $formatted = str_replace("_", " ", $field);
      $formatted = ucwords($formatted);
      $errors[] = "{$formatted} is a required field.";
    }
  }
  // If there are errors, let the user know
  if (count($errors) > 0) {
    $_SESSION['flash']['danger'] = $errors;
    $_SESSION['form_data'] = $_POST;
    redirect(base_path . "/movies/new.php");
  }
  /*
    Sanitize our data before validating against
    the database
  */
  $_POST['movie_name'] = filter_var($_POST['movie_name'], FILTER_SANITIZE_STRING);
  $_POST['movie_year'] = filter_var($_POST['movie_year'], FILTER_SANITIZE_STRING);
  $_POST['movie_bio'] = filter_var($_POST['movie_bio'], FILTER_SANITIZE_STRING);
  $_POST['movie_rating'] = filter_var($_POST['movie_rating'], FILTER_SANITIZE_STRING);
  $_POST['stars'] = filter_var($_POST['stars'], FILTER_SANITIZE_STRING);
  $_POST['director'] = filter_var($_POST['director'], FILTER_SANITIZE_STRING);
  $_POST['genre'] = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
  
  /*
    Sanitizing the HTML is a little trickier. We can't use
    filter_var() because it will strip out ALL tags
    including HTML tags. Instead we'll use preg_replace
    which will allow us to strip out only the script tags.
  */
  
  /*
    Create the post
  */

    
  $filename = $_FILES["movie_img"]["name"] ; //select file from computer
  $tempname = $_FILES["movie_img"]["tmp_name"] ; //FILES php function temporarily stores that file in memory
  $folder = ROOT . '/assets/image/'.$filename ; // define location to move the file
  move_uploaded_file($tempname,$folder); // this function moves the file to desired location
  $movie_img = '/assets/image/'.$filename; //I defined this for easy file name in database


  $sql = "INSERT INTO movies
    (movie_name, movie_year, movie_rating, movie_bio, movie_img, stars, director, genre) VALUES (
      :movie_name,
      :movie_year,
      :movie_rating,
      :movie_bio,
      :movie_img,
      :stars,
      :director,
      :genre
    )";


  // Include our connection and call our defined function
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  // Prepare, bind and execute our SQL
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':movie_name', $_POST['movie_name'], PDO::PARAM_STR);
  $stmt->bindParam(':movie_year', $_POST['movie_year'], PDO::PARAM_STR);
  $stmt->bindParam(':movie_rating', $_POST['movie_rating'], PDO::PARAM_STR);
  $stmt->bindParam(':movie_bio', $_POST['movie_bio'], PDO::PARAM_STR);
  $stmt->bindParam(':movie_img', $movie_img, PDO::PARAM_STR);
  $stmt->bindParam(':stars', $_POST['stars'], PDO::PARAM_STR);
  $stmt->bindParam(':director', $_POST['director'], PDO::PARAM_STR);
  $stmt->bindParam(':genre', $_POST['genre'], PDO::PARAM_STR);

  $stmt->execute();
  $id = $conn->lastInsertId();
  // Send bacn a success message
  $_SESSION['flash']['success'][] = "You have successfully added a new movie.";
  redirect(base_path . "/movies/show.php?id={$id}");
  exit;