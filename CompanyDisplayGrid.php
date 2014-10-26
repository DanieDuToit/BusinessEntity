<?php
    // Start the session
    session_start();
?>
<?php
if (isset($_POST['Return'])) {
    header("Location: Default.php");
}
include "Header.inc.php";
$conn = Database::getConnection();

/**
 * Created by PhpStorm.
 * User: dutoitd1
 * Date: 2014/10/14
 * Time: 01:52 PM
 */

?>
<body>
<h1>Company</h1>

<form name="form1" action="CompanyDisplayGrid.php" method="post">
    <div>
        <label for="SearchN">Company Name</label>
        <input type="text" name="SearchN" id="SearchN">
        <label for="Search"></label>
        <input type="submit" value="Search" name="Search">
    </div>
</form>
<div>
    <table class="noBorder">
        <tr>
            <td class="noBorder">
                <form name="form2" action="Company.php" method="post">
                    <input type="submit" value="Create" name="Create" id="Create">
                </form>
            </td>
            <td class="noBorder">
                <form name="form3" action="CompanyDisplayGrid.php" method="post">
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
    die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
}
if (isset($_POST["Search"])) {
    $bc = $_POST['SearchN'];
//    echo $bc;
    $records = $dbBaseClass->getFieldsByFilter('Company', array('id','Name','CompanyCode','Active','ShortName'),
        "WHERE Name LIKE '%$bc%'");
} else {
    $records = $dbBaseClass->getFieldsForAll('Company', array('id', 'Name','CompanyCode','Active','ShortName'));
}
if ($records === false) {
    die(dbGetErrorMsg());
}
//$numFields = sqlsrv_num_fields($records);
echo "<table class='withBorder'>";
echo '<thead>';
echo '<tr></tr><th>Name</th><th>Company Code</th><th>Active</th><th>ShortName</th><th colspan="3">Action</th> <tr></tr>';
echo '<tr>';
echo '</tr>';
echo '</thead>';
while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_BOTH)) {
    echo "<tr>";
    echo "<td>{$record['Name']}</td>";
    echo "<td>{$record['CompanyCode']}</td>";
    echo "<td>{$record['Active']}</td>";
    echo "<td>{$record['ShortName']}</td>";
    echo "<td><a href=Company.php?action=r&id={$record['id']}><img src=\"images/icons/view.png\" /></a></td>";
    echo "<td><a href=Company.php?action=u&id={$record['id']}><img src=\"images/icons/edit.png\" /></a></td>";
    echo "<td><a href=Company.php?action=d&id={$record['id']}><img src=\"images/icons/delete.png\" /></a></td>";
    echo "</tr>";
}
echo "</table>";
$dbBaseClass->close();
?>
</body>