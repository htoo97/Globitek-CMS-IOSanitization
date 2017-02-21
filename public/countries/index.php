<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Staff: Countries'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
    <a href="../index.php">Back to Menu</a><br />

    <h1>Countries</h1>

    <a href="new.php">Add a country</a><br />
    <br />

    <?php
        $countries_result = find_all_countries();

        echo "<table id=\"countries\" style=\"width: 500px;\">";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Code</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
        while ($country = db_fetch_assoc($countries_result)) {
            echo "<tr>";
            echo "<td>" . $country['name'] . "</td>";
            echo "<td>" . $country['code'] . "</td>";
            echo "<td>";
            echo  "<a href=\"show.php?id=" . u(filter_var($country['id'], FILTER_SANITIZE_URL)) . "\" >Show</a>";
            echo "</td>";
            echo "<td>";
            echo "<a href=\"edit.php?id=" . u(filter_var($country['id'], FILTER_SANITIZE_URL)) . "\">Edit</a>";
            echo "</td>";
            echo "</tr>";
        }
    ?>

</div>

<?php include (SHARED_PATH . '/footer.php'); ?>