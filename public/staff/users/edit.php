<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}

$id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$users_result = find_user_by_id($id);
// No loop, only one result
$user = db_fetch_assoc($users_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($users_result) === 0) {
  redirect_to('index.php');
}

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) {
    $user['first_name'] = h(strip_tags($_POST['first_name']));
  }
  if(isset($_POST['last_name'])) {
    $user['last_name'] = h(strip_tags($_POST['last_name']));
  }
  if(isset($_POST['username'])) {
    $user['username'] = h(strip_tags($_POST['username']));
  }
  if(isset($_POST['email'])) {
    $user['email'] = h(strip_tags($_POST['email']));
  }


  $result = update_user($user);
  if($result === true) {
    redirect_to('show.php?id=' . u(filter_var($user['id'], FILTER_SANITIZE_URL)));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />

  <h1>Edit User: <?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo u(filter_var($user['id'], FILTER_SANITIZE_URL)); ?>" method="post">
    First name:<br />
    <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /><br />
    Last name:<br />
    <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" /><br />
    Username:<br />
    <input type="text" name="username" value="<?php echo $user['username']; ?>" /><br />
    Email:<br />
    <input type="text" name="email" value="<?php echo $user['email']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update"  />
    <a href="<?php echo 'show.php?id=' . u(filter_var($user['id'], FILTER_SANITIZE_URL));?>">  Cancel</a>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
