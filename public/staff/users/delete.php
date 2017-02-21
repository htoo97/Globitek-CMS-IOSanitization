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

if(is_post_request()) {
    delete_user($user['id']);
    redirect_to('index.php');
}

?>

<?php $page_title = 'Staff: Delete User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />

  <h1>Delete User: <?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>

  <form action="delete.php?id=<?php echo u(filter_var($user['id'], FILTER_SANITIZE_URL)); ?>" method="post">
    <?php
        echo "Are you sure you want to permanently delete the user?";
    ?>
    <br />
    <input type="submit" name="submit" value="Confirm" />
    <a href="<?php echo 'show.php?id=' . u(filter_var($user['id'], FILTER_SANITIZE_URL));?>">  Cancel</a>

  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>