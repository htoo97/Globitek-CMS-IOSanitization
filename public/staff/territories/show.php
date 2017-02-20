<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$territory_result = find_territory_by_id($id);
// No loop, only one result
$territory = db_fetch_assoc($territory_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($territory_result) === 0) {
  redirect_to('index.php');
}

?>

<?php $page_title = 'Staff: Territory of ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="<?php echo '../states/show.php?id=' . u(filter_var($territory['state_id'], FILTER_SANITIZE_URL)); ?>">Back to State Details</a>
  <br />

  <h1>Territory: <?php echo $territory['name']; ?></h1>

  <?php
    echo "<table id=\"territory\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . $territory['name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>State ID: </td>";
    echo "<td>" . $territory['state_id'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Position: </td>";
    echo "<td>" . $territory['position'] . "</td>";
    echo "</tr>";
    echo "</table>";

    db_free_result($territory_result);
  ?>
  <br />
  <a href="<?php echo 'edit.php?id=' . u(filter_var($id, FILTER_SANITIZE_URL)); ?>">Edit</a><br />

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
