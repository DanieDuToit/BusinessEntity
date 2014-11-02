<?php
    if (isset($_POST['Return'])) {
        header("Location: Default.php");
    }
    include "Header.inc.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head></head>
<body>
<h1>BusinessLevel</h1>

<div>
    <table class="noBorder">
        <tr>
            <td class="noBorder">
                <form name="form3" method="post">
                    <input type="submit" value="Return" name="Return" id="Return">
                </form>
            </td>
        </tr>
    </table>
</div>
<br>

<?php


    $dbBaseClass = new BaseDB();
    if (Database::getConnection() === false) {
        die("ERROR: Could not connect." . printf('%s', dbGetErrorMsg()));
    }

    $records = $dbBaseClass->getFieldsForAll('BusinessLevel', array('id', 'Name', 'Active'));


    if ($records === false) {
        die(dbGetErrorMsg());
    }

    echo "<table class ='withBorder'>";
    echo "<tr>";
    echo "<thead>";
    echo "<td>BusinessLevelName</td><td>Active</td>";
    echo "</thead>";
    echo "</tr>";

    while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC)) {

        echo "<tr>";
        echo "<td>{$record['Name']}</td>";
        echo "<td>{$record['Active']}</td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";

    $dbBaseClass->close();

?>


</body>
</html>