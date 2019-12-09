<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php
  // User's can't view their profile unless logged in
  // User's can't view other users profiles unless they're administrators
  if (!AUTH || (AUTH && $_GET['id'] !== $_SESSION['user']['id'] && !ADMIN)) {
    redirect(base_path);
  }
?>

<?php
  if (session_status() === PHP_SESSION_NONE) session_start();
  // Get the user if admin and they've passed a get request id
  include_once(ROOT . "/includes/_connect.php");
  $conn = connect();
  $sql = "SELECT * FROM users WHERE id = :id"; // sql string
  $stmt = $conn->prepare($sql); // prepare the sql and return the prepared statement
  $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute(); // execute the statement
  $user = $stmt->fetch(); // fetch the user record returned

?>


<?php include_once(ROOT . '/partials/_header.php') ?>

<div class="container-fluid login">
  <header class="register">
    <h1>
      User - <?= $user['fullname'] ?> 
    </h1>
    <hr>

    <!-- Only show the back link if the user is an administrator -->
    <?php if (ADMIN): ?>
      <small>
        <a href="./"><i class="fa fa-chevron-left"></i>&nbsp;Back to users...</a>
      </small>
    <?php endif ?>
  </header>
  
  <div class="row">
     <div class="col-md-2"></div>
    <div class="col-4">
     <img src='<?= base_path . $user['profile_Pic'] ?>' class="profile-image-size img-fluid">
    </div>

    <div class="col-4">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>Name:</th>
            <td><?= $user['fullname'] ?> 
          </tr>
          <tr>
            <th>Email:</th>
            <td><?= $user['email'] ?></td>
          </tr>
          <tr>
            <th>User Name:</th>
            <td>
                <?= $user['username'] ?>
            </td>
          </tr>
          <?php if (ADMIN): ?>
            <tr>
              <th>Role:</th>
              <td><?= $user['role'] ?></td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
      <div>
        <small>
          <a href="<?= base_path ?>/users/edit.php?id=<?= ADMIN ? $_GET['id'] : $_SESSION['user']['id'] ?>">
            <i class="fa fa-pencil">&nbsp;</i>
            Edit your profile...
          </a>
          &nbsp;|&nbsp;
          <a href="<?= base_path ?>/users/destroy.php?id=<?= ADMIN ? $_GET['id'] : $_SESSION['user']['id'] ?>" onclick="return confirm('Are you sure you want to delete your own profile?')">
            <i class="fa fa-remove">&nbsp;</i>
            Delete your profile...
          </a>
        </small>
      </div>
    </div>
  </div>
</div>

<?php include_once(ROOT . '/partials/_footer.php') ?>