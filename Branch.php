<?php
/**
 * Created by PhpStorm.
 * User: dutoitd1
 * Date: 2014/10/14
 * Time: 09:56 AM
 */
include_once 'functions.php';
include_once 'IncludesAndClasses\DBBase.class.php';
include_once 'IncludesAndClasses\BranchBase.class.php';
if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
	header("Location: BranchDisplayGrid.php");
}
$id = (int)$_GET['id'];
sanitizeString($id);
$action = $_GET['action'];
sanitizeString($action);

// Set up DB connection
$dbBaseClass = new DBBase();
if ($dbBaseClass->conn === false) {
	die("ERROR: Could not connect. " . printf('%s', $dbBaseClass->dbGetErrorMsg()));
}

// An existing record is expected when the action is not "Create"
if ($action != 'c') {
	// Read the record
	$records = $dbBaseClass->getAllByFieldName('Branch', 'id', $id);

	if ($records === false) {
		die($dbBaseClass->dbGetErrorMsg());
	}

	// Get the specific record
	$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
}

$branchBase = BranchBase::$Branch;
function echoField($fieldIdName)
{
	global $action;
	global $record;
	global $branchBase;
	initializeFieldParametersArray($fieldParams, $fieldIdName, $branchBase);
	if ($action == 'r' || $action == 'd') {
		$fieldParams[FieldParameters::disabled_par] = 'Disabled';
	}
	$inputField = (string)drawInputField($fieldIdName, $branchBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
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

<h1>Create / Read / Update / Delete a Branch</h1>

<form action="BranchAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoField("BranchCode") ?>
		</tr>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
		Active
		<tr>
			<?php echoField("CustomMessage") ?>
		</tr>
		<tr>
			<?php echoField("PhoneNumber") ?>
		</tr>
		<tr>
			<?php echoField("FaxNumber") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine1") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine2") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine3") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine4") ?>
		</tr>
		<tr>
			<?php echoField("PhysicalAddressLine5") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine1") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine2") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine3") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine4") ?>
		</tr>
		<tr>
			<?php echoField("PostalAddressLine5") ?>
		</tr>
		<tr>
			<?php echoField("BankName") ?>
		</tr>
		<tr>
			<?php echoField("BankBranchName") ?>
		</tr>
		<tr>
			<?php echoField("BankBranchCode") ?>
		</tr>
		<tr>
			<?php echoField("BankAccountNumber") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonName") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonNumber") ?>
		</tr>
		<tr>
			<?php echoField("ContactPersonEmail") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonName") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonNumber") ?>
		</tr>
		<tr>
			<?php echoField("AdminContactPersonEmail") ?>
		</tr>
		<tr>
			<?php echoField("Longitude") ?>
		</tr>
		<tr>
			<?php echoField("Latitude") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityId") ?>
		</tr>
		</tbody>
	</table>
	<?php if ($action == 'c') ?>
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