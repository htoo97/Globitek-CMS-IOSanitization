<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$sanitized_id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$country_result = find_country_by_id($sanitized_id);
// No loop, only one result
$country = db_fetch_assoc($country_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($country_result) === 0) {
  redirect_to('index.php');
}

// set default values for all variables the page needs
$errors = array();

if (is_post_request()) {
    // confirm all values are present before accessing them
    if (isset($_POST['name'])) {
        $country['name'] = h(strip_tags($_POST['name']));
    }
    if (isset($_POST['code'])) {
        $country['code'] = h(strip_tags($_POST['code']));
    }

    $result = update_country($country);
    if ($result === true) {
        redirect_to('show.php?id=' . u(filter_var($country[id], FILTER_SANITIZE_URL)));
    }
    else {
        $errors = $result;
    }
}

?>
<?php $page_title = 'Staff: Edit Country ' . $country['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Countries List</a><br />

  <h1>Edit State: <?php echo $country['name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo u(filter_var($country['id'], FILTER_SANITIZE_URL)); ?>>" method="post">
    Country name:<br />
    <input type="text" name="name" value="<?php echo $country['name']; ?>" /><br />
    Country code:<br />
    <input type="text" name="code" value="<?php echo $country['code']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update" />
    <a href="<?php echo 'show.php?id=' . u(filter_var($country['id'], FILTER_SANITIZE_URL)); ?>"> Cancel</a>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
