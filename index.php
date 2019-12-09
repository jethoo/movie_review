
<!--
    admin@test.com - test
    general@test.com - test
    Idea of this project
   Dynamic movie review site, content being rendered from backend
1. Database containing Movie table, users table, review table
2. Movie table will help showing all the movies 
3. Users table will help showing the user profiles
4. Review page will help showing movie as well as reviews shown together, together with the users
   detail , whoever posted the review
5. Only authenticated users, can post review
6. Only admin can add new movies
7. Only admin can add new users
8. Users can only see their profile, upload their profile picture, and see all the reviews of the movie

Movies --> 

<?php include(__DIR__ . '/_config.php') ?>


<?php
  $_title = "Big Screen Review";
  $_active = "home";
?>
<?php include(ROOT . '/partials/_header.php') ?>

  
<div class="container-fluid">
  <div class="row"><!--first row-->
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="assets/image/ford-ferrari-poster.jpg" alt="First slide">
                <div class="jumbotron">
                  <div class="carousel-caption">
                        <h1 class="big-screen">BIG SCREEN REVIEWS</h1>
                        <p class="big-screen-para">Welcome to the BIG SCREEN Movie Review Site</p>
                    </div><!--end of carousel-caption-->
                </div><!--end of jumbotron-->
            </div><!--end of carousel-item active-->

            <div class="carousel-item">
              <img class="d-block w-100 img-responsive" src="assets/image/joker2.jpg" alt="Second slide">
              <div class="jumbotron">
                <div class="carousel-caption">
                   <div class="container"><!--start of container-->
                      <div class="row">
                        <div class="col-md-4 " > <h1 class="big-screen">Rate Movies</h1></div>
                        <div class="col-md-4 ">
                          <p class="big-screen-para">Create an account to review your favorite movies</p>
                        </div>
                        <div class="col-md-4 ">
                             <p><a class="btn btn-lg btn-info" href="<?= base_path ?>/users/new.php" role="button">Sign up today</a></p>
                        </div>                    
                      </div><!--end of row-->
                    </div><!--end of container-->
                  </div><!--end of carousel-caption-->
               </div><!--end of jumbotron-->
            </div><!--end of carousel-item active-->

            <div class="carousel-item">
              <img class="d-block w-100" src="assets/image/irishman.jpg" alt="Third slide">
              <div class="jumbotron">
                  <div class="carousel-caption">
                    <div class="container"><!--start of container-->
                       <div class="row">
                        <div class="col-md-4">
                          <h1 class="big-screen">Read Reviews</h1>
                        </div>
                        <div class="col-md-4">
                          <p class="big-screen-para">Browse all of our reviews and find out more about what others thought of your favorite movies!</p>
                        </div>
                        <div class="col-md-4">
                          <p><a class="btn btn-lg btn-info" href="<?= base_path ?>/movies" role="button">VIEW REVIEWS &raquo;</a></p>
                        </div>
                        </div><!--end of row-->
                    </div><!--end of container-->
                  </div><!--end of carousel-caption-->
              </div><!--end of jumbotron-->
            </div><!--end of carousel-item active-->
      </div><!--end of carousel inner-->
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a><!--buttons to slide next and previous-->
    </div><!--end of examplecontrol div-->
  </div><!--end of first row-->
</div><!--end of container fluid container-->
  
<div class="container detail-container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-4">
				<h2>CREATE ACCOUNT</h2>
				<p>Sign up for an account in order to add a review to your favorite movie</p>
				<p><a class="btn btn-default" href="<?= base_path ?>/users/new.php" role="button">SIGN UP &raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>LIST MOVIES</h2>
				<p>Browse our extensive list of movie titles along with ratings, years, a short synopsis, and even reviews!</p>
				<p><a class="btn btn-default" href="<?= base_path ?>/movies" role="button">VIEW MOVIES &raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>LIST REVIEWS</h2>
				<p>Browse all of our reviews and find out more about what others thought of your favorite movies!</p>
				<p><a class="btn btn-default" href="<?= base_path ?>/movies" role="button">VIEW REVIEWS &raquo;</a></p>
			</div>
		</div>

	</div> <!-- /container -->



<?php include(ROOT . '/partials/_footer.php') ?>

