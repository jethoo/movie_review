<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php not_auth_redirect(base_path . '/movies') ?>

<?php
  // Validate
  foreach(['title', 'comment'] as $field) {
    if (empty($_POST[$field])) {
      $formatted = str_replace("_", " ", $field);
      $formatted = ucwords($formatted);
      $errors[] = "{$formatted} is a required field.";
    }
  }
  // Handle errors
  $errors = [];
  if (count($errors) > 0) {
    $_SESSION['flash']['danger'] = $errors;
    $_SESSION['form_data'] = $_POST;
    redirect(base_path . "/movies/{$_POST['id']}");
  }
  /*
    Sanitize our data before validating against
    the database
  */
  $_POST['title'] = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
  $_POST['comment'] = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
  
  // Include our connection and call our defined function
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  // Get the post using the id and user id as our clause
  $sql = "SELECT * FROM movies WHERE id = :id ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT); 
  $stmt->execute();
  $movie = $stmt->fetch();
  var_dump($movie);
  // Verify we have a movie
  
  /*
    Create the comment
  */
  $sql = "INSERT INTO reviews
    (review_Movie_Id, review_User_Id, review_rating , review_content) VALUES (
      :review_Movie_Id,
      {$_SESSION['user']['id']},
      :review_rating,
      :review_content
    )";
  // Prepare, bind and execute our SQL
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':review_Movie_Id', $_POST['movie_id'], PDO::PARAM_STR);
  $stmt->bindParam(':review_content', $_POST['comment'], PDO::PARAM_STR);
  $stmt->bindParam(':review_rating', $_POST['rating'], PDO::PARAM_INT);
  $stmt->execute();
  // Send bacn a success message
  $_SESSION['flash']['success'][] = "You have successfully created a new comment.";
  redirect(base_path . "/movies/show.php?id={$_POST['movie_id']}");