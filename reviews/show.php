<?php include_once(dirname(__DIR__) . '/_config.php') ?>

<?php
  // Get the posts (but we'll also need the author)
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  
  //?
  $sql = "SELECT *, reviews.id as id FROM reviews
    JOIN users ON reviews.review_User_Id = users.id  
    WHERE reviews.id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $review = $stmt->fetch();
  
?>

<?php include_once(ROOT . '/partials/_header.php') ?>

<article class="container">
  <div>
    <header class="mt-5">
      <h1>
        <?= $review['review_rating'] ?> /5 STARS 
        <br>
        <small>~<?= $review['username'] ?> </small>
      </h1>
    </header>

    <hr class="m-5">

    <div class="row">
      <div class="col-4">
        <img src="<?= base_path . $review['profile_Pic'] ?>" alt="adf" class="img-fluid">
      </div>

      <div class="col-8">
        <section>
          <p><?= $review['review_content'] ?></p>
        </section>

        <p>
          <a href="<?= base_path ?>/movies/show.php?id=<?= $review['review_Movie_Id'] ?>">Return to movies...</a>
        </p>
      </div>
    </div>

    <hr class="m-5">
  </div>
</article>

<?php include_once(ROOT . '/partials/_footer.php') ?>