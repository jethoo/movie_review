<?php include_once(dirname(__DIR__) . '/_config.php') ?>

<?php
  $_title = "Login To Big Screen";
  $_active = "login";
?>

<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid login-container">
  <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6"><!--md start-->
            <header class="mt-3 text-align-center">
              <h1 class="login">Login</h1>
            </header>
            <section login-form>
                <form action="./authenticate.php" method="post">
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= $form_data['email'] ?? null ?>">
                  </div>

                  <div class="form-group">
                    <label for="email">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                  </div>
                  <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </section>
            <small>Don't have an Account. Create New Account <a href="<?= base_path ?>/users/new.php">Sign Up</a>!</small>
        </div><!--md close-->
        <div class="col-md-3"></div>
    <div><!--end of row-->
</div><!--end of container fluid-->



		
	

<?php include_once(ROOT . '/partials/_footer.php') ?>