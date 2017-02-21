<?php
require_once('../../../private/initialize.php');

// set default values for all variables the page needs
$errors = array();
$country = array(
    'name' => '',
    'code' =>  ''
);


if (is_post_request()) {
    // confirm values are present before accessing them
    if (isset($_POST['name'])) {
        $country['name'] = h(strip_tags($_POST['name']));
    }
    if (isset($_POST['code'])) {
        $country['code'] = h(strip_tags($_POST['code']));
    }

    $result = insert_country($country);
    if ($result === true) {
        $new_id = db_insert_id($db);
        redirect_to('show.php?id=' . u(filter_var($new_id, FILTER_SANITIZE_URL)));
    }
    else {
        $errors = $result;
    }
}
?>

<?php $page_title = 'Staff: New Country'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Countries List</a><br />

  <h1>New Country</h1>

  <?php echo display_errors($errors); ?>

  <form action="new.php" method="post">
    Country name:<br />
    <input type="text" name="name" value="<?php echo $country['name']; ?>" /><br />
    Country code:<br />
    <input type="text" name="code" value="<?php echo $country['code']; ?>" /><br />
    <br>
    <input type="submit" name="submit" value="Create" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
