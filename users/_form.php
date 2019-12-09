<?php include_once(dirname(__DIR__) . '/_config.php') ?>
<?php
  // If the user is attempting to edit and their not authenticated
  // or they're attempting to edit another user and they're not an admin
  if (isset($_action) && (!AUTH || ($_GET['id'] !== $_SESSION['user']['id'] && !ADMIN))) {
    redirect(base_path);
  } else if (!isset($_action) && AUTH && !ADMIN) { // If the user is attempting to create
    // Only admins can create new users while logged in
    redirect(base_path);
  }
?>

<?php $form_data = $form_data ?? null ?>

<form action="<?= $_action ?? base_path . "/users/create.php" ?>" method="post" enctype="multipart/form-data">
  <div class="row">
    <?php if (isset($_action)): ?>
      <input type="hidden" class="form-control" id="id" name="id" value="<?= $form_data['id'] ?>">
    <?php endif ?>

    <div class="form-group col">
      <label for="user_name">User Name:</label>
      <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Your User Name" value="<?= $form_data['username'] ?? null ?>">
    </div>

    <div class="form-group col">
      <label for="full_name">Full Name:</label>
      <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Your Full Name" value="<?= $form_data['fullname'] ?? null ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $form_data['email'] ?? null ?>">
  </div>
  
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>

  <div class="form-group">
    <label for="password_confirmation">Password:</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
  </div>
  <div class="form-group">
    <label for="profile_picture">Upload Profile Picture</label>
    <input type="file" class="form-control" id="file_upload" name="file_upload">
  </div>

  <button class="btn btn-primary" type="submit" >Submit</button>
</form>

