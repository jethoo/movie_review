<?php include_once(dirname(__DIR__) . "/_config.php"); ?>

<!-- all the nav detail-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="<?= base_path ?>/"><i class="fa fa-clock-o fa-lg"></i>Big Screen</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php if (AUTH): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_path ?>/users/show.php?id=<?= $_SESSION['user']['id'] ?>">_Welcome-<?= $_SESSION['user']['username'] ?>_</a>
        </li>
      <?php endif ?>


      <li class="nav-item">
        <a class="nav-link" href="<?= base_path ?>">Home</span></a>
      </li>
      
      <?php if (ADMIN): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="blogDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Movies 
          </a>
          <div class="dropdown-menu" aria-labelledby="blogDropdown">
                <a class="dropdown-item" href="<?= base_path ?>/movies/new.php">Add a New Movie</a>
                <a class="dropdown-item" href="<?= base_path ?>/movies">All the Movies</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_path ?>/movies">Movie-Gallery</a>
        </li>
      <?php endif ?>
      
      
      <?php if (ADMIN): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Users
          </a>
          <div class="dropdown-menu" aria-labelledby="usersDropdown">
            <a class="dropdown-item" href="<?= base_path ?>/users/new.php">Create a New User</a>
            <a class="dropdown-item" href="<?= base_path ?>/users">View All Users</a>
          </div>
        </li>
      <?php endif ?>
    </ul>

    <ul class="navbar-nav ml-auto">
      <?php if (!AUTH): ?>
        <li class="nav-item">
          <a href="<?= base_path ?>/sessions/login.php" class="nav-link">
            <i class="fa fa-unlock"></i>&nbsp;Login
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_path ?>/users/new.php" class="nav-link">
            <i class="fa fa-user"></i>&nbsp;Register
          </a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a href="<?= base_path ?>/sessions/logout.php" class="nav-link">
            <i class="fa fa-lock"></i>&nbsp;Logout
          </a>
        </li>
      <?php endif ?>
    </ul>
  </div>
</nav>