<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$country_result = find_country_by_id($id);
// No loop, only one result
$country = db_fetch_assoc($country_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($country_result) === 0) {
  redirect_to('index.php');
}

?>

<?php $page_title = 'Staff: Country of ' . $country['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Countries List</a><br />

  <h1>Country: <?php echo $country['name']; ?></h1>

  <?php
    echo "<table id=\"country\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . $country['name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Code: </td>";
    echo "<td>" . $country['code'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "</tr>";
    echo "</table>";
?>
    <br />
    <a href="edit.php?id=<?php echo u(filter_var($country['id'], FILTER_SANITIZE_URL)) ?>">Edit</a><br />
    <hr />

    <h2>States</h2>
    <br />
    <a href="../states/new.php?country_id=<?php echo u(filter_var($country['id'], FILTER_SANITIZE_URL)) ?>">Add a State</a><br />

<?php
    $state_result = find_states_for_country_id($country['id']);

    echo "<ul id=\"territories\">";
    while($state = db_fetch_assoc($state_result)) {
      echo "<li>";
      echo "<a href=\"" . "../states/show.php?id=" . u(filter_var($state['id'], FILTER_SANITIZE_URL)) . "\">";
      echo $state['name'];
      echo "</a>";
      echo "</li>";
    } // end while $territory
    db_free_result($state_result);
    echo "</ul>"; // #territories

    db_free_result($country_result);
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
