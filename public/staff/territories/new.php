<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['state_id'])) {
  redirect_to('index.php');
}

$state_id = h(strip_tags(filter_var($_GET['state_id'], FILTER_SANITIZE_URL)));

// set default values for all variables the page needs
$errors = array();
$territory = array(
    'name' => '',
    'state_id' => $state_id,
    'position' => ''
);

if (is_post_request()) {
    // confirm values are present before accessing them
    if (isset($_POST['name'])) {
        $territory['name'] = h(strip_tags($_POST['name']));
    }
    if (isset($_POST['position'])) {
        $territory['position'] = h(strip_tags($_POST['position']));
    }

    $result = insert_territory($territory);
    if ($result === true) {
        $new_id = db_insert_id($db);
        redirect_to('show.php?id=' . u(filter_var($new_id, FILTER_SANITIZE_URL)));
    }
    else {
        $errors = $result;
    }
}

?>

<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="<?php echo '../states/show.php?id=' . u(filter_var($territory['state_id'], FILTER_SANITIZE_URL)); ?>">Back to State Details</a><br />

  <h1>New Territory</h1>

  <?php echo display_errors($errors); ?>
  <form action="<?php echo 'new.php?state_id=' . u(filter_var($territory['state_id'], FILTER_SANITIZE_URL)); ?>" method="post">
    Territory Name:<br />
    <input type="text" name="name" value="<?php echo $territory['name']; ?>" /><br />
    State ID:<br />
    <?php echo $territory['state_id']; ?> <br />
    Position:<br />
    <input type="text" name="position" value="<?php echo $territory['position']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Create" />

  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
