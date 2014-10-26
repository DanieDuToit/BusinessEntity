<?php
    // Start the session
    session_start();
?>
<?php
    if (isset($_POST['Return'])) {
        header("Location: CompanyDisplayGrid.php");
    }
    include "Header.inc.php";
    $action = '';

    if (!isset($_POST['Create'])) {
        if (isset($_GET['id']) === false || isset($_GET['action']) === false) {

            header("Location: CompanyDisplayGrid.php");
        }
        $id = (int)$_GET['id'];
        $action = $_GET['action'];
        sanitizeString($id);
    } else {
        $action = 'c';
        $id = -1;
    }
    sanitizeString($action);

    // Set up DB connection
    $dbBaseClass = new BaseDB();
    $recordBase = BaseCompany::$company;
    if (Database::getConnection() === false) {
        die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
    }

    // An existing record is expected when the action is not "Create"
    if ($action != 'c') {
        // Read the record
        $records = $dbBaseClass->getAll('Company', "WHERE id = $id");

        if ($records === false) {
            die(dbGetErrorMsg());
        }

        // Get the specific record
        $record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
    }


    $companyBase = BaseCompany::$company;

    function echoField($fieldIdName)
    {
        global $action;
        global $record;
        global $recordBase;
        $fieldParams = initializeFieldParametersArray($fieldIdName, $recordBase);
        if ($action == 'r' || $action == 'd') {
            $fieldParams[FieldParameters::disabled_par] = 'Disabled';
        }
        $inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName],
            $fieldParams, $recordBase[$fieldIdName]['FriendlyName'], $recordBase[$fieldIdName]['Helptext']);
        $str = (string)$recordBase[$fieldIdName]['FriendlyName'];
        if ($str == "") $str = $fieldIdName;
        echo "<td class=\"fieldName\"><b>$str</ b></td>";
        echo("<td>$inputField</td>");
    }

?>

<?php
    if ($action == 'c') {
        $val = 'Insert';
    } elseif ($action == 'u') {
        $val = 'Update';
    } elseif ($action == 'd') {
        $val = 'Remove';
    } else {
        $val = 'Display';
    }
    echo sprintf('<div class="heading"><h1>%s a Company</h1></div>', $val);
?>


<form action="CompanyAction.php" method="post">
    <input type="hidden" value="<?php echo $id ?>" id="id" name="id">
    <table width="200" border="0" cellspacing="2px" cellpadding="2px">
        <tr>
            <?php echoField("Name") ?>
        </tr>
        <tr>
            <?php echoField("CompanyCode") ?>
        </tr>
        <tr>
            <?php echoField("Active") ?>
        </tr>
        <tr>
            <?php echoField("ShortName") ?>
        </tr>
        <tr>
            <?php echoField("BusinessEntityId") ?>
        </tr>

    </table>
    <div>
        <?php
            if ($action == 'c') {
                echo (string)drawSubmitButton("Create", "Create");
            }
            if ($action == 'u') {
                echo (string)drawSubmitButton("Update", "Update");
            }
            if ($action == 'd') {
                echo (string)drawSubmitButton("Delete", "Delete");
            }
        ?>
        <form action="Company.php" method="post">
            <?php
                echo((string)drawSubmitButton("Return", "Return"));
            ?>

        </form>
    </div>
</form>
<script src="JavaScripts/jquery-2.0.2.js"















