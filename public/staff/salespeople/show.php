<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = h(strip_tags(filter_var($_GET['id'], FILTER_SANITIZE_URL)));
$salespeople_result = find_salesperson_by_id($id);
// No loop, only one result
$salesperson = db_fetch_assoc($salespeople_result);

// sql query returns no rows; record doesn't exist
if (db_num_rows($salespeople_result) === 0) {
  redirect_to('index.php');
}
?>

<?php $page_title = 'Staff: Salesperson ' . $salesperson['first_name'] . " " . $salesperson['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Salespeople List</a><br />

  <h1>Salesperson: <?php echo $salesperson['first_name'] . " " . $salesperson['last_name']; ?></h1>

  <?php
    echo "<table id=\"salesperson\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . $salesperson['first_name'] . " " . $salesperson['last_name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Phone: </td>";
    echo "<td>" . $salesperson['phone'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Email: </td>";
    echo "<td>" . $salesperson['email'] . "</td>";
    echo "</tr>";
    echo "</table>";

    db_free_result($salespeople_result);
  ?>
  <br />
  <a href="<?php echo 'edit.php?id=' . u(filter_var($salesperson['id'], FILTER_SANITIZE_URL)); ?>">Edit</a><br />
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
