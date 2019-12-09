<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php not_admin_redirect(base_path . '/movies') ?>

<?php $form_data = $form_data ?? null ?>
<?php $_action = $_action ?? base_path . "/movies/create.php" ?>

<form action="<?= $_action ?>" method="post" enctype="multipart/form-data">

  <?php if (isset($_action)): ?>
    <div class="row">
        <input type="hidden" name="id" value="<?= $form_data['id'] ?>">
  <?php endif ?>

  <div class="form-group col">
      <label for="movie_name">Movie Name:</label>
      <input type="text" class="form-control" id="movie_name" name="movie_name" placeholder="Enter The Movie Name" value="<?= $form_data['movie_name'] ?? null ?>">
    </div>

    <div class="form-group col">
      <label for="full_name">Movie Year:</label>
      <input type="text" class="form-control" id="movie_year" name="movie_year" placeholder="Enter Movie Release Year" value="<?= $form_data['movie_year'] ?? null ?>">
    </div>
  </div>
  
  <div class="form-group ">
    <label for="movie_rating">Movie Rating:</label>
    <input type="text" class="form-control" id="movie_rating" name="movie_rating" placeholder="Enter Movie Rating: PG-13, R,..." value="<?= $form_data['movie_rating'] ?? null ?>">
  </div>
  
  <div class="form-group">
    <label for="movie_bio">Movie Bio:</label>
    <input type="text" class="form-control" id="movie_bio" name="movie_bio" placeholder="Movie Bio" value="<?= $form_data['movie_bio'] ?? null ?>">
  </div>

  <div class="form-group ">
    <label for="Stars">Stars:</label>
    <input type="text" class="form-control" id="stars" name="stars" placeholder="Actors" value="<?= $form_data['stars'] ?? null ?>">
  </div>
  
  <div class="form-group ">
    <label for="director">Director:</label>
    <input type="text" class="form-control" id="director" name="director" placeholder="Director" value="<?= $form_data['director'] ?? null ?>">
  </div>
  
  <div class="form-group ">
    <label for="genre">Genre:</label>
    <input type="text" class="form-control" id="genre" name="genre" placeholder="genre" value="<?= $form_data['genre'] ?? null ?>">
  </div>

  <div class="form-group ">
    <label for="Movie_Image">Upload Movie Image</label>
    <input type="file" class="form-control" id="movie_img" name="movie_img">
  </div>

  <button class="btn btn-primary" type="submit">Submit</button>
</form>
