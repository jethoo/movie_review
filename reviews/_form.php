<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php if (!AUTH) redirect(base_path . "/movies") ?>

<?php
include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  // Get the post using the id and user id as our clause
  $sql = "SELECT * FROM movies WHERE id = :id ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT); 
  $stmt->execute();
  $movie = $stmt->fetch();
?>
<?php if (!isset($movie['id'])) redirect("/movies") ?>

<?php $form_data = $form_data ?? null ?>
<?php $_action = $_action ?? base_path . "/reviews/create.php" ?>

<div class="row mb-5">
  <div class="col-sm-3">
    
  </div>
  <div class="col-sm-6 mt-5">
    <form action="<?= $_action ?>" method="post">
      <input type="hidden" name="movie_id" value="<?= $movie['id'] ?? null ?>">
      
      <div class="form-group">
        <label for="title">Your Stars for the Movie: Rate from 1 to 5</label>
        <input type="text" class="form-control" name="rating" placeholder="How many Stars for the movie?" value="<?= $form_data['review_rating'] ?? null ?>">
      </div>

      <div class="form-group">
        <label for="comment">Your Comment:</label>
        <textarea type="text" class="form-control" name="comment" rows="5"><?= $form_data['review_content'] ?? null ?></textarea>
      </div>

      <div class="form-group clearfix">
        <button class="btn btn-primary pull-right" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>