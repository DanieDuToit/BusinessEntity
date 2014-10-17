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
	$action = $_GET['action'];

	// Set up DB connection
	$dbBaseClass = new DBBase();
	if ($dbBaseClass->conn === false)
	{
		die("ERROR: Could not connect. " .  printf('%s',$dbBaseClass->dbGetErrorMsg()));
	}

	// Read the records
	$records = $dbBaseClass->getAllByFieldName('Branch', 'id', $id);

	if ($records === false) {
		die($dbBaseClass->dbGetErrorMsg());
	}

	// Get the specific record
	$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);

	$branchBase = BranchBase::$Branch;
	function echoValue($fieldIdName, $fieldType)
	{
		global $action;
		global $record;
		global $branchBase;
		initializeFieldParametersArray($fieldParams, $fieldIdName, $branchBase);
		if ($action == 'r' || $action == 'd') {
			$fieldParams[FieldParameters::disabled_par] = 'Disabled';
		}
//		$inputField = "";
		$inputField = drawInputField($fieldIdName, $branchBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
//		switch($fieldType){
//			case "text":
//				$inputField .= drawInputField($fieldIdName, $branchBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);
//				break;
//			case "checkbox":
//				$fieldParams[FieldParameters::onClick_par] = "onClick()";
//				$inputField .= drawInputField($fieldIdName, $fieldType, $record[$fieldIdName], $fieldParams);
//				break;
//		}
		$temp = "<td class=\"fieldName\"><b>$fieldIdName</ b></td>";
		$temp .= "<td>$inputField</td>";
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

<form action="Branch.php" >
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoValue("BranchCode", "text", true) ?>
		</tr>
		<tr>
			<?php echoValue("Name", "text", false) ?>
		</tr>
		<tr>
			<?php echoValue("Active", "checkbox", false) ?>
		</tr>
		<tr>
			<?php echoValue("CustomMessage", "text", false) ?>
		</tr>
		<tr>
			<?php echoValue("PhoneNumber", "text", false) ?>
		</tr>
		<tr>
			<?php echoValue("FaxNumber", "text", false) ?>
		</tr>
		<tr>
			<?php echoValue("PhysicalAddressLine1", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PhysicalAddressLine2</b></td>-->
			<?php echoValue("PhysicalAddressLine2", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PhysicalAddressLine3</b></td>-->
			<?php echoValue("PhysicalAddressLine3", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PhysicalAddressLine4</b></td>-->
			<?php echoValue("PhysicalAddressLine4", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PhysicalAddressLine5</b></td>-->
			<?php echoValue("PhysicalAddressLine5", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PostalAddressLine1</b></td>-->
			<?php echoValue("PostalAddressLine1", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PostalAddressLine2</b></td>-->
			<?php echoValue("PostalAddressLine2", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PostalAddressLine3</b></td>-->
			<?php echoValue("PostalAddressLine3", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PostalAddressLine4</b></td>-->
			<?php echoValue("PostalAddressLine4", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>PostalAddressLine5</b></td>-->
			<?php echoValue("PostalAddressLine5", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>BankName</b></td>-->
			<?php echoValue("BankName", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>BankBranchName</b></td>-->
			<?php echoValue("BankBranchName", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>BankBranchCode</b></td>-->
			<?php echoValue("BankBranchCode", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>BankAccountNumber</b></td>-->
			<?php echoValue("BankAccountNumber", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>ContactPersonName</b></td>-->
			<?php echoValue("ContactPersonName", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>ContactPersonNumber</b></td>-->
			<?php echoValue("ContactPersonNumber", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>ContactPersonEmail</b></td>-->
			<?php echoValue("ContactPersonEmail", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>AdminContactPersonName</b></td>-->
			<?php echoValue("AdminContactPersonName", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>AdminContactPersonNumber</b></td>-->
			<?php echoValue("AdminContactPersonNumber", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>AdminContactPersonEmail</b></td>-->
			<?php echoValue("AdminContactPersonEmail", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>Longitude</b></td>-->
			<?php echoValue("Longitude", "text", false) ?>
		</tr>
		<tr>
<!--			<td class="fieldName"><b>Latitude</b></td>-->
			<?php echoValue("Latitude", "text", false) ?>
		</tr>
		</tbody>
	</table>
	<div><?php echo drawSubmitButton("Read", "Read")?></div>
</form>
</body>
</html>