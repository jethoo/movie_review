<?php
  include_once(dirname(__DIR__) . '/_config.php');
// Include our connection and call our defined function
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  // Get the post using the id and user id as our clause
  $sql = "SELECT * FROM reviews WHERE id = :id AND review_User_Id = {$_SESSION['user']['id']}";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $comment = $stmt->fetch();
  
  $movieId = $comment["review_Movie_Id"]; //assigning id of the movie to send the user to the right movie,review was deleted.
  // Verify we have a post  
  if ((!$comment) && (!ADMIN)) {
    $_SESSION['flash']['danger'][] = "You cannot delete others' reviews.";
    // Send them to posts because they're not editing a valid post they own
    redirect(base_path . "/movies");
  }



  /*
    Create the post
  */
  $sql = "DELETE FROM reviews WHERE id = :id";
  // Prepare, bind and execute our SQL
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  // Send bacn a success message
  $_SESSION['flash']['success'][] = "You have successfully deleted your review";
  redirect(base_path . "/movies/show.php?id=$movieId"); //redirects to 