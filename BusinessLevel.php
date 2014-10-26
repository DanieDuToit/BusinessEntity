<?php

 if(isset($_POST['Return']))
 {
     header("Location: BusinessLevelDisplayGrid.php");
 }

$action = '';
	//include_once 'Includes/functions.inc.php';
	//include_once 'Classes/BaseClasses/BaseDB.class.php';
	//include_once 'Classes/BaseClasses/BaseBranch.class.php';
	include "Header.inc.php";
if (!isset($_POST['Create'])) {
	if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
		header("Location: BusinessLevelDisplayGrid.php");
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
if (Database::getConnection() === false) {
	die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
}

// An existing record is expected when the action is not "Create"
if ($action != 'c') {
	// Read the record
	$records = $dbBaseClass->getAllByFieldName('BuLevel', 'id', $id);

	if ($records === false) {
		die(dbGetErrorMsg());
	}

	// Get the specific record
	$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
}

	$recordBase = BaseBusinessLevel::$BusinessLevel;
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
//	$inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
	$str = (string)$recordBase[$fieldIdName]['FriendlyName'];
	if ($str == "") $str = $fieldIdName;
	echo "<td class=\"fieldName\"><b>$str</ b></td>";
	echo("<td>$inputField</td>");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<link href="skin/demo/menu.css" rel="stylesheet" type="text/css">
	<link href="skin/stylesheet.css" rel="stylesheet" type="text/css">
	<link href="skin/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
	<title>Branch</title>
</head>
<body>

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
echo sprintf('<div class="heading"><h2>%s a Branch</h2></div>', $val);
?>

<form action="BranchAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
		<tr>
		</tbody>
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
        <form>
            <?php
            echo (drawSubmitButton("Return", "Return"));
            ?>

        </form>
	</div>
</form>
</body>
</html>