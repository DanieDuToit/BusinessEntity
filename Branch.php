<?php
	// Start the session
	session_start();

?>

<?php
	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/14
	 * Time: 09:56 AM
	 */
	if (isset($_POST['Return'])) {
		header("Location: BranchDisplayGrid.php");
	}
	include "Header.inc.php";
	$action = '';
	$selectList = '';
	$dbBaseClass = new BaseDB();
	$companyName = '';
	$divisionId = '';
	if (!isset($_POST['Create'])) {
		if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
			header("Location: BranchDisplayGrid.php");
		}
		$id = (int)$_GET['id'];
		$action = $_GET['action'];
		sanitizeString($id);

		// Get the Division EntityId
		$divisionStmnt = $dbBaseClass->getFieldsForAll("BusinessEntity", array('BusinessEntityParentId'), "WHERE id = {$_GET['entityId']}");
		if ($divisionStmnt == false) {
			$_SESSION['error'] = "The branch does not have a related division.";
			header("Location: BranchDisplayGrid.php");
			exit;
		}
		$divisionRecord = sqlsrv_fetch_array($divisionStmnt, SQLSRV_FETCH_ASSOC);
		$divisionId = $divisionRecord['BusinessEntityParentId'];

		// Get the Company EntityId
		$companyStmnt = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Name', 'Id', 'BusinessEntityParentId'), "WHERE id = $divisionId");
		if ($companyStmnt == false) {
			$_SESSION['error'] = "The branch does not have a related company.";
			header("Location: BranchDisplayGrid.php");
			exit;
		}
		$companyRecord = sqlsrv_fetch_array($companyStmnt, SQLSRV_FETCH_ASSOC);
		$companyId = $companyRecord['BusinessEntityParentId'];

		// If a record is only displayed then the Company and Division should not be allowed to change
		// Get the company that this branch is related with
		$companyRecords = $dbBaseClass->getFieldsByFilter("BusinessEntity", array('Id', 'Name'), "WHERE Id = $companyId");
		$company = sqlsrv_fetch_array($companyRecords, SQLSRV_FETCH_ASSOC);
		$selectList = "<option selected=selected value='{$company['Id']}'>{$company['Name']}</option>";

		// TODO
		// Get the Division that this branch is related with and make it the only available selection
//        if ($action == 'r' || $action == 'd') {
//            $divisionSelectList = "<option selected=\"selected\" value='{$companyRecord['Id']}'>{$companyRecord['Name']}</option>";
//        }
	} else {
		$companyRecords = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Id', 'Name'), 'WHERE BusinessLevelId = 1');
		while ($company = sqlsrv_fetch_array($companyRecords, SQLSRV_FETCH_ASSOC)) {
			$selectList .= "<option value='{$company['Id']}'>{$company['Name']}</option>";
		}
		$action = 'c';
		$id = -1;
	}
	sanitizeString($action);

	// Set up DB connection
	if (Database::getConnection() === false) {
		$_SESSION['error'] = "ERROR: Could not connect. " . printf('%s', dbGetErrorMsg());
		header("Location: BranchDisplayGrid.php");
		exit;
	}

	// An existing record is expected when the action is not "Create"
	if ($action != 'c') {
		// Read the record
		$records = $dbBaseClass->getAll('Branch', "WHERE id = $id");

		if ($records === false) {
			$_SESSION['error'] = "ERROR: Could not connect. " . printf('%s', dbGetErrorMsg());
			header("Location: BranchDisplayGrid.php");
			exit;
		}

		// Get the specific record
		$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
	}

	$recordBase = BaseBranch::$Branch;
	function echoField($fieldIdName, $hidden = false)
	{
		global $action;
		global $record;
		global $recordBase;
		$fieldParams = initializeFieldParametersArray($fieldIdName, $recordBase);
		if ($action == 'r' || $action == 'd') {
			$fieldParams[FieldParameters::disabled_par] = 'Disabled';
		}
		if ($hidden) {
			echo "<input type=hidden value=\"$record[$fieldIdName]\" id=\"$fieldIdName\"  name=\"$fieldIdName\">";
		} else {
			$inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName],
				$fieldParams, $recordBase[$fieldIdName]['FriendlyName'], $recordBase[$fieldIdName]['Helptext']);
			$str = (string)$recordBase[$fieldIdName]['FriendlyName'];
			if ($str == "") $str = $fieldIdName;
			echo "<th class=\"fieldName\">$str</th>";
			echo("<td>$inputField</td>");
		}
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
	<input type="hidden" value="<?php echo $action ?>" id="displayType">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
	<input type="hidden" value="<?php echo $divisionId ?>" id="divisionId">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<th>Company</th>
			<td>
				<label for='Company'></label>
				<select id='Company' name='Company'>
					<?php echo $selectList; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>Division</th>
			<td>
				<label for='Division'></label>
				<select id='Division' name='Division'>
					<option>Select</option>
				</select>
			</td>
		</tr>
		<tr>
			<?php echoField("BranchCode") ?>
		</tr>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
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
			<?php echoField("BusinessEntityId", true) ?>
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
				echo (string)drawSubmitButton("Return", "Return");
			?>
		</form>
	</div>
</form>
</body>
</html>
<script type="text/javascript" src="JavaScripts/jquery-2.0.2.js"></script>
<script type="text/javascript" src="JavaScripts/BranchStartup.js"></script>
