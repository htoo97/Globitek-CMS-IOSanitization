<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$state_result = find_state_by_id($id);
// No loop, only one result
$state = db_fetch_assoc($state_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($state_result) === 0) {
  redirect_to('index.php');
}

?>

<?php $page_title = 'Staff: State of ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to States List</a><br />

  <h1>State: <?php echo $state['name']; ?></h1>

  <?php
    echo "<table id=\"state\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . $state['name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Code: </td>";
    echo "<td>" . $state['code'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Country ID: </td>";
    echo "<td>" . $state['country_id'] . "</td>";
    echo "</tr>";
    echo "</table>";
?>
    <br />
    <a href="edit.php?id=<?php echo u(filter_var($state['id'], FILTER_SANITIZE_URL)) ?>">Edit</a><br />
    <hr />

    <h2>Territories</h2>
    <br />
    <a href="<?php echo '../territories/new.php?state_id=' . u(filter_var($state['id'], FILTER_SANITIZE_URL)); ?>">Add a Territory</a><br />

<?php
    $territory_result = find_territories_for_state_id($state['id']);

    echo "<ul id=\"territories\">";
    while($territory = db_fetch_assoc($territory_result)) {
      echo "<li>";
      echo "<a href=\"" . "../territories/show.php?id=" . u(filter_var($territory['id'], FILTER_SANITIZE_URL)) . "\">";
      echo $territory['name'];
      echo "</a>";
      echo "</li>";
    } // end while $territory
    db_free_result($territory_result);
    echo "</ul>"; // #territories

    db_free_result($state_result);
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
