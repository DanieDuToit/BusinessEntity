<?php
    // Start the session
    session_start();

?>
<?php
    if (isset($_POST['Return'])) {
        header("Location: Default.php");
    }
    include "Header.inc.php";

    $cbStatus = '';
    $filter   = '';
    $active   = null;
    if (isset($_POST["Search"])) {
        $bc     = $_POST['SearchBC'];
        $filter = "WHERE BranchCode LIKE '%$bc%'";
        if (isset($_POST['cbActive'])) {
            $active = true;
            $filter .= ' AND Active = 1';
        } else {
            $action = false;
            $filter .= ' AND Active = 0';
        }
    } else {
        $filter = "WHERE Active = 1";
        $active = true;
    }
?>
<title>Branches</title>
<body>
<h1>Branches</h1>

<form name="form1" action="BranchDisplayGrid.php" method="post">
    <table width="400" border="1" cellspacing="2px" cellpadding="2px">
        <tbody>
        <tr>
            <td><label for="SearchBC">Branch Code</label>
                <input type="text" name="SearchBC" id="SearchBC"></td>
            <td>Active?
                <input name="cbActive" type="checkbox" id="cbActive" title="Active"
                    <?php
                        if ($active === true) {
                            echo ' checked="checked"';
                        }
                    ?>
                    >
            </td>
            <td><label for="Search"></label>
                <input type="submit" value="Search" name="Search"></td>
        </tr>
        </tbody>
    </table>
    <!--	<div>-->
    <!--		<label for="SearchBC">Branch Code</label>-->
    <!--		<input type="text" name="SearchBC" id="SearchBC">-->
    <!--		<label for="Search"></label>-->
    <!--		<input type="submit" value="Search" name="Search">-->
    <!--	</div>-->
</form>
<div>
    <table class="noBorder">
        <tr>
            <td class="noBorder">
                <form name="form2" action="Branch.php" method="post">
                    <input type="submit" value="Create" name="Create" id="Create">
                </form>
            </td>
            <td class="noBorder">
                <form name="form3" action="BranchDisplayGrid.php" method="post">
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
        $_SESSION['error'] = "ERROR: Could not connect. " . printf('%s', dbGetErrorMsg());
        header("Location: Default.php");
        exit;
    }
    $records = $dbBaseClass->getFieldsByFilter('Branch', array('id', 'BranchCode', 'Name', 'PhoneNumber',
                                                               'ContactPersonName', 'ContactPersonNumber', 'FaxNumber', 'ContactPersonEmail', 'BusinessEntityId'), $filter);
    if ($records === false) {
        $_SESSION['error'] = dbGetErrorMsg();
        header("Location: Default.php");
        exit;
    }
    $numFields = sqlsrv_num_fields($records);
    echo "<table class='withBorder'>";
    echo "<thead>";
    echo "<tr><th>Branch</th><th>Name</th><th>Phone Number</th><th>ContactPersonName</th><th>ContactPersonNumber</th><th>FaxNumber</th><th>ContactPersonEmail</th><th colspan=\"3\">Actions</th></tr>";
    echo '</thead>';
    while ($record = sqlsrv_fetch_array($records, SQLSRV_FETCH_BOTH)) {
        echo "<tr>";
        echo "<td>{$record['BranchCode']}</td>";
        echo "<td>{$record['Name']}</td>";
        echo "<td>{$record['PhoneNumber']}</td>";
        echo "<td>{$record['ContactPersonName']}</td>";
        echo "<td>{$record['ContactPersonNumber']}</td>";
        echo "<td>{$record['FaxNumber']}</td>";
        echo "<td>{$record['ContactPersonEmail']}</td>";
        echo "<td><a href=Branch.php?action=r&id={$record['id']}&entityId={$record['BusinessEntityId']}><img src=\"images/icons/view.png\" /></a></td>";
        echo "<td><a href=Branch.php?action=u&id={$record['id']}&entityId={$record['BusinessEntityId']}><img src=\"images/icons/edit.png\" /></a></td>";
        //		echo "<td><a href=Branch.php?action=d&id={$record['id']}&entityId={$record['BusinessEntityId']}><img src=\"images/icons/delete.png\" /></a></td>";
        echo "</tr>";
    }
    echo "</table>";
    $dbBaseClass->close();
?>
</body>