<?php include_once(dirname(__DIR__) . '/_config.php') ?>

<?php
  // Get the posts (but we'll also need the author)
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  $sql = "SELECT * FROM movies ORDER BY id DESC";
  $movies = $conn->query($sql)->fetchAll();
?>

<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid movie-container">
    <div class="row">
        <div class="col-md-12">
            <header class="register">
                <h1 class="mt-5 mb-3">
                    Movies
                 <br>
                </h1>
                <p class="text-center">Click On The Movie Title. Read Reviews. Post Reviews.</p>
            </header>
        </div>
    </div>
    <div class="row">
        <div class="archives">
              <?php foreach ($movies as $movie): ?>
                  <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                              <div class="col-1"></div>
                              <div class="col-3">
                                <img src="<?= base_path . $movie['movie_img'] ?>" alt="movies" class="img-fluid img-thumbnail">
                              </div><!--end of col-3-->

                              <div class="col-7">
                                
                                    <div style="width: 100%;" class="clearfix"><small class="pull-right">Rating: <?= $movie['movie_rating'] ?></small></div>
                                    <div class="card-title mt-3">
                                        <h3>
                                          <a href="<?= base_path ?>/movies/show.php?id=<?= $movie['id'] ?>"><?= $movie['movie_name'] ?></a>
                                        </h3>
                                        <hr>
                                      
                                    </div>
                                    <p class="card-text">
                                      <?= $movie['movie_bio']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Stars: </strong><?= $movie['stars']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Director: </strong><?= $movie['director']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Genre: </strong><?= $movie['genre']?>
                                    </p>
                                    <p class="card-text strong">
                                      <strong>Year: </strong><?= $movie['movie_year']?>
                                    </p>



                                    <?php if (ADMIN): ?>
                                      <div>
                                        <a href="<?= base_path ?>/movies/edit.php?id=<?= $movie['id'] ?>">
                                          <i class="fa fa-pencil"></i>
                                          edit
                                        </a>
                                        |
                                        <a href="<?= base_path ?>/movies/destroy.php?id=<?= $movie['id'] ?>" onclick="return confirm('Are you sure you want to delete this movie?')">
                                          <i class="fa fa-trash"></i>
                                          delete
                                        </a>
                                      </div>
                                    <?php endif ?>

                              </div><!--end of col-7-->
                                
                            </div>
                      </div><!--end of row-->
                    </div>
                  <?php endforeach ?>
                </div>
        </div><!--end of row-->
  
    
       
</div>
       
<?php include_once(ROOT . '/partials/_footer.php') ?>