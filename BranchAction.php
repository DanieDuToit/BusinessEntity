<?php
/**
 * Created by PhpStorm.
 * User: Danie
 * Date: 2014/10/18
 * Time: 07:25 PM
 */
include_once "IncludesAndClasses/DBBase.class.php";
include_once "IncludesAndClasses/BranchBase.class.php";
include_once "functions.php";

$branchBase = new BranchBase();
if ($dbBaseClass->conn === false) {
	die("ERROR: Could not connect. " . printf('%s', $dbBaseClass->dbGetErrorMsg()));
}
$branchTemplate = BranchBase::$Branch;
if (isset($_POST['id'])){
	$id = $_POST['id'];
} else {
	$id = null;
}
if (isset($_POST['Update'])){
	$action = 'Update';
	$record = PopulateRecord($_POST, $branchTemplate);
	$errors = ValidateRecord($record);
	$errors = $branchBase->update("id", $id, $record);
	if ($errors){
		// Error/s occurred
		foreach ($errors as $error) {
			echo "<div>$error</div><br>";
		}
		die ($branchBase->dbGetErrorMsg());
	}
} elseif (isset($_POST['Delete'])){
	$action = 'Delete';
} elseif (isset($_POST['Create'])){
	$action = 'Create';
	$record = PopulateRecord($_POST, $branchTemplate);
	$errors = $branchBase->insert($record);
	if ($errors){
		// Error/s occurred
		foreach ($errors as $error) {
			echo "<div>$error</div><br>";
		}
		die ($branchBase->dbGetErrorMsg());
	}
} else {
	header("Location: BranchDisplayGrid.php");
}


