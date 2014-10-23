<?php
	/**
	 * Created by PhpStorm.
	 * User: Danie
	 * Date: 2014/10/21
	 * Time: 09:30 PM
	 */

	if (isset($_POST['Return'])) {
		header("Location: DivisionDisplayGrid.php");
	}

	$action = '';
	include "Header.inc.php";
//	include_once "BaseClasses/settings.inc.php";
//	include_once "BaseClasses/BaseDB.class.php";
//	include_once "BaseClasses/BaseBranch.class.php";
//	include_once "BaseClasses/BaseBusinessLevel.class.php";
//	include_once "BaseClasses/BaseDivision.class.php";
//	include_once "BaseClasses/functions.inc.php";

//	echo buildPostForDebug($_GET);
//	die;

	if (!isset($_POST['Create'])) {
		if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
			header("Location: DivisionDisplayGrid.php");
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
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}

	// Get the BusinessLevel records
	$businessLevelBase = new BaseBusinessLevel();
	$businessLevelRecords = $dbBaseClass->GetAll("BusinessLevel", "WHERE BusinessLevelId = 2");

	// An existing record is expected when the action is not "Create"
	if ($action != 'c') {
		// Read the record
		$records = $dbBaseClass->getAllByFieldName('BusinessEntity', 'id', $id);

		if ($records === false) {
			die(dbGetErrorMsg());
		}

		// Get the specific record
		$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
		$businessLevelId = $record['BusinessLevelId']['Value'];
	}
	$recordBase = BaseDivision::$Division;

	function echoField($fieldIdName)
	{
		global $action;
		global $record;
		global $recordBase;
		$fieldParams = initializeFieldParametersArray($fieldIdName, $recordBase);
		if ($action == 'r' || $action == 'd') {
			$fieldParams[FieldParameters::disabled_par] = 'Disabled';
		}
		$inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
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
<!--	<script type='text/javascript' src='JavaScripts/jquery-2.0.2.js'></script>-->
<!--	<script type='text/javascript' src='JavaScripts/fieldValidators.js'></script>-->
<!--	<script type="text/javascript" src="JavaScripts/jsFunctions.js"></script>-->
<!--	<script type='text/javascript' src='JavaScripts/jquery-ui-1.10.3.custom.js'></script>-->
<!--	<script type="text/javascript" src="tinymce/tinymce.min.js"></script>-->
<!--	<link href="select2/select2.css" rel="stylesheet"/>-->
	<script src="select2/select2.js"></script>

	<title>Division</title>
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
	echo sprintf('<div class="heading"><h2>%s a Division</h2></div>', $val);
?>
<form action="DivisionAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
	<input type="hidden" value="" id="CompanyId" name="CompanyId">
	<input type="hidden" value="<?php echo $record["BusinessLevelId"] ?>" id="BusinessLevelId" name="BusinessLevelId">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityCode") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityDescription") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityShortName") ?>
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
		<form action="Division.php" method="post">
			<?php
				echo (string)(drawSubmitButton("Return", "Return"));
			?>
		</form>
	</div>
</form>
