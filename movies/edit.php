<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php not_admin_redirect(base_path . '/movies') ?>

<?php
  // Get the post
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  $sql = "SELECT * FROM movies WHERE id=:id"; // sql string
  $stmt = $conn->prepare($sql); // prepare the sql and return the prepared statement
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute(); // execute the statement
  $_SESSION['form_data'] = $stmt->fetch();
?>


<?php 
  
  $_title = "Edit Movie";
  $_active = "movies";
  $_action = base_path . "/movies/update.php";

?>

<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid login-container">
  <header class="register">
    <h1>
     <?= $_title ?>
    </h1>
  </header>
  <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 border">
            <?php include_once(ROOT . '/movies/_form.php') ?>
        </div>
        <div class="col-sm-2"></div>
    </div>

<?php include_once(ROOT . '/partials/_footer.php') ?>