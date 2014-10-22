<?php
	/**
	 * Created by PhpStorm.
	 * User: Danie
	 * Date: 2014/10/21
	 * Time: 09:30 PM
	 */
	$action = '';
	include_once '../IncludesAndClasses/functions.inc.php';
	include_once '../IncludesAndClasses/DBBase.class.php';
	include_once '../IncludesAndClasses/DivisionBase.class.php';

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
	$dbBaseClass = new DBBase();
	if ($dbBaseClass->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}

	// An existing record is expected when the action is not "Create"
	if ($action != 'c') {
		// Read the record
		$records = $dbBaseClass->getAllByFieldName('BusinessEntity', 'id', $id);

		if ($records === false) {
			die(dbGetErrorMsg());
		}

		// Get the specific record
		$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
	}
	$recordBase = DivisionBase::$Division;

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
		echo "<td class=\"fieldName\"><b>$fieldIdName</ b></td>";
		echo("<td>$inputField</td>");
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
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
	echo sprintf('<div class="heading"><h1>%s a Division</h1></div>', $val);
?>
<form action="DivisionAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
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
	</div>
</form>
