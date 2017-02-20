<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}

$id = h(strip_tags(filter_var($_GET['id'])));
$territories_result = find_territory_by_id($id);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($territories_result) === 0) {
  redirect_to('index.php');
}

// set default values for all variables the page needs
$errors = array();

if (is_post_request()) {

    // confirm that values are present before accessing them
    if (isset($_POST['name'])) {
        $territory['name'] = h(strip_tags($_POST['name']));
    }
    if (isset($_POST['position'])) {
        $territory['position'] = h(strip_tags($_POST['position']));
    }

    $result = update_territory($territory);
    if ($result === true) {
        redirect_to('show.php?id=' . u(filter_var($territory['id'], FILTER_SANITIZE_URL)));
    }
    else {
        $errors = $result;
    }
}

?>
<?php $page_title = 'Staff: Edit Territory ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="<?php echo '../states/show.php?id=' . u(filter_var($territory['state_id'], FILTER_SANITIZE_URL)); ?>">Back to State Details</a><br />

  <h1>Edit Territory: <?php echo $territory['name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="<?php echo 'edit.php?id=' . u(filter_var($territory['id'], FILTER_SANITIZE_URL)); ?>" method="post" >
    Territory Name:<br />
    <input type="text" name="name" value="<?php echo $territory['name']; ?>" /><br />
    State ID:<br />
    <?php echo h(strip_tags($territory['state_id'])); ?> <br />
    Position:<br />
    <input type="text" name="position" value="<?php echo $territory['position']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update" />
    <a href="<?php echo 'show.php?id=' . u(filter_var($territory['id'], FILTER_SANITIZE_URL)); ?>"> Cancel</a>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
