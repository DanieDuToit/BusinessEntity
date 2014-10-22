<?php
/**
 * Created by PhpStorm.
 * User: dutoitd1
 * Date: 2014/10/14
 * Time: 09:56 AM
 */
$action = '';
include_once 'IncludesAndClasses/functions.inc.php';
include_once 'IncludesAndClasses/DBBase.class.php';
include_once 'IncludesAndClasses/BranchBase.class.php';
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
$dbBaseClass = new DBBase();
if ($dbBaseClass->conn === false) {
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

$BusinessLevelBase = BusinessLevelBase::$BusinessLevel;
function echoField($fieldIdName)
{
	global $action;
	global $record;
	global $BusinessLevelBase;
	$fieldParams = initializeFieldParametersArray($fieldIdName, $BusinessLevelBase);
	if ($action == 'r' || $action == 'd') {
		$fieldParams[FieldParameters::disabled_par] = 'Disabled';
	}
	$inputField = (string)drawInputField($fieldIdName, $BusinessLevelBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
	echo "<td class=\"fieldName\"><b>$fieldIdName</ b></td>";
	echo("<td>$inputField</td>");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
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
echo sprintf('<div class="heading"><h1>%s a Branch</h1></div>', $val);
?>

<form action="Branch/BranchAction.php" method="post">
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
	</div>
</form>
</body>
</html>