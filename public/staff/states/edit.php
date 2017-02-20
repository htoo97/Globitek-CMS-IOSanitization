<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$sanitized_id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$states_result = find_state_by_id($sanitized_id);
// No loop, only one result
$state = db_fetch_assoc($states_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($states_result) === 0) {
  redirect_to('index.php');
}

// set default values for all variables the page needs
$errors = array();

if (is_post_request()) {
    // confirm all values are present before accessing them
    if (isset($_POST['name'])) {
        $state['name'] = h(strip_tags($_POST['name']));
    }
    if (isset($_POST['code'])) {
        $state['code'] = h(strip_tags($_POST['code']));
    }
    if (isset($_POST['country_id'])) {
        $state['country_id'] = h(strip_tags($_POST['country_id']));
    }

    $result = update_state($state);
    if ($result === true) {
        redirect_to('show.php?id=' . u(filter_var($state[id], FILTER_SANITIZE_URL)));
    }
    else {
        $errors = $result;
    }
}

?>
<?php $page_title = 'Staff: Edit State ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to States List</a><br />

  <h1>Edit State: <?php echo $state['name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo u(filter_var($state['id'], FILTER_SANITIZE_URL)); ?>>" method="post">
    State name:<br />
    <input type="text" name="name" value="<?php echo $state['name']; ?>" /><br />
    State code:<br />
    <input type="text" name="code" value="<?php echo $state['code']; ?>" /><br />
    Country ID:<br />
    <input type="text" name="country_id" value="<?php echo $state['country_id']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update" />
    <a href="<?php echo 'show.php?id=' . u(filter_var($state['id'], FILTER_SANITIZE_URL)); ?>"> Cancel</a>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
