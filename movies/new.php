<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php not_admin_redirect(base_path . '/movies') ?>

<?php
  $_title = "New Movie";
  $_active = "movies";
?>

<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid login-container">
  <header class="register">
    <h1 register-title><?= $_title ?></h1>
    <hr>
    <?php if (ADMIN): ?>
      <small>
        <a href="./"><i class="fa fa-chevron-left"></i>&nbsp;Back to movies...</a>
      </small>
    <?php endif ?>
  </header>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 border">
            <?php include_once(ROOT . '/movies/_form.php') ?>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>


<?php include_once(ROOT . '/partials/_footer.php') ?>