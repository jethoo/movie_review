<?php include_once(dirname(__DIR__) . '/_config.php') ?>

<?php
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  
  $sql = "SELECT * FROM movies WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $movies = $stmt->fetch();
  
 
  
  $sql = "SELECT *, reviews.id as id FROM reviews
    JOIN users ON reviews.review_User_Id = users.id
WHERE reviews.review_Movie_Id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $reviews = $stmt->fetchAll();
  //var_dump($reviews);
?>


<!--first i need to join reviews and movies -->

<!--second i need to join reviews and users, to find out which user commented -->
<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid movie-container"> <!--start of container fluid-->
   
<div class="row">
        <div class="col-md-12">
            <header class="register">
                <h1 class="mt-5 mb-3">
                    Movies
                <br>
                </h1>
            </header>
        </div>
    </div>
   
    
                <div class="row">
                <div class="archives">
                 
                      <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                              <div class="col-1"></div>
                              <div class="col-3">
                                <img src="<?= base_path . $movies['movie_img'] ?>" alt="movies" class="img-fluid img-thumbnail">
                              </div><!--end of col-3-->

                              <div class="col-7">
                                
                                    <div style="width: 100%;" class="clearfix"><small class="pull-right">Rating: <?= $movies['movie_rating'] ?></small></div>
                                    <div class="card-title mt-3">
                                        <h3>
                                          <a href="<?= base_path ?>/movies/show.php?id=<?= $movies['id'] ?>"><?= $movies['movie_name'] ?></a>
                                        </h3>
                                        <hr>
                                      
                                    </div>
                                    <p class="card-text">
                                      <?= $movies['movie_bio']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Stars: </strong><?= $movies['stars']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Director: </strong><?= $movies['director']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Genre: </strong><?= $movies['genre']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Year: </strong><?= $movies['movie_year']?>
                                    </p>



                                    <?php if (ADMIN): ?>
                                      <div>
                                        <a href="<?= base_path ?>/movies/edit.php?id=<?= $movies['id'] ?>">
                                          <i class="fa fa-pencil"></i>
                                          edit
                                        </a>
                                        |
                                        <a href="<?= base_path ?>/movies/destroy.php?id=<?= $movies['id'] ?>" onclick="return confirm('Are you sure you want to delete this movie?')">
                                          <i class="fa fa-trash"></i>
                                          delete
                                        </a>
                                      </div>
                                    <?php endif ?>

                              </div><!--end of col-7-->
                                
                            </div>
                      </div><!--end of row-->
                    </div>
                
                </div>
        </div><!--end of row-->
  

    <div class="row"><!--start of comments row-->
      <div class="col-md-2"></div>
      <div class="col-md-8"><!--start of comments col-12-->
              <?php if (isset($reviews) && count($reviews) > 0): ?>
              
                  <h2 class="text-center mt-2">Movie Reviews</h2>

                  <div class="mt-5">
                    <ul class="list-group">
                      <?php foreach ($reviews as $review): ?>
                        <li class="list-group-item">
                          <h5 class="mb-4">
                            <?= $review['review_rating'] ?>/5 Stars<br>
                            <small>Username: <?= $review['username'] ?></small>
                          </h5>
                          <hr>
                          <div class="ml-5 d-flex flex-row justify-content-between align-items-center">
                            <img src="<?= base_path . $review['profile_Pic'] ?>" alt="placeholder" class="img-fluid img-thumbnail mr-2" style="max-width: 150px; border-radius: 150px;">
                            
                            <p>
                              <?= $review['review_content']?>&hellip;
                              <a href="<?= base_path ?>/reviews/show.php?id=<?= $review['id']?>">more</a></p>

                            <?php if ((ADMIN) || ((AUTH) && $review['review_User_Id'] === $_SESSION['user']['id'])):?> <!--delete options for the right user-->
                              <p><a href="<?= base_path ?>/reviews/destroy.php?id=<?= $review['id'] ?>" onclick="return confirm('Are you sure you want to delete this movie?')">
                                          <i class="fa fa-trash"></i>
                                          delete
                                        </a></p>
                            <?php endif ?>

                          </div>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                
              <?php endif ?>
      </div><!--end of comments col-12-->
    </div><!--end of comments row-->
    <hr>
    <div class="row">
  <div class="col-md-12">
      <?php
        if (AUTH) {
          include_once(ROOT . "/reviews/_form.php");
        }
      ?>
  </div>
</div><!--end of comment-form row-->
</div><!--end of div container fluid-->
<?php include_once(ROOT . '/partials/_footer.php') ?>

