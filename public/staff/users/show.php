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

?>

<?php $page_title = 'Staff: User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />

  <h1>User: <?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>

  <?php
    echo "<table id=\"user\">";
    echo "<tr>";
    echo "<td>Name: </td>";
    echo "<td>" . $user['first_name'] . " " . $user['last_name'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Username: </td>";
    echo "<td>" . $user['username'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Email: </td>";
    echo "<td>" . $user['email'] . "</td>";
    echo "</tr>";
    echo "</table>";

    db_free_result($users_result);
  ?>
  <br />
  <a href="edit.php?id=<?php echo u(filter_var($user['id'], FILTER_SANITIZE_URL)); ?>">Edit</a><br />

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
