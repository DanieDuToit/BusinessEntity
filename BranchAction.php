<style>
	.message {
		color: green;
	}

	.error {
		color: red;
	}
</style>
<?php
	/**
	 * Created by PhpStorm.
	 * User: Danie
	 * Date: 2014/10/18
	 * Time: 07:25 PM
	 */
	include_once "IncludesAndClasses/DBBase.class.php";
	include_once "IncludesAndClasses/BranchBase.class.php";
	include_once "IncludesAndClasses/functions.inc.php";
//	echo buildPostForDebug($_POST);
//	die();
	$branchBase = new BranchBase();
	if ($branchBase->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	$branchTemplate = BranchBase::$Branch;
	if (!isset($_POST['id'])) {
		echo "<div class='error'> <h3>No ID was received for ACTION.PHP</h3></div>";
		die;
	}
	if (isset($_POST['Update'])) {
//	$action = 'Update';
		$record = PopulateRecord($_POST, $branchTemplate);
		$validateErrors = ValidateRecord($record);
		$updateErrors = $branchBase->update("id", $_POST['id'], $record);
		if ($validateErrors) {
			foreach ($validateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($updateErrors) {
			foreach ($updateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($validateErrors || $updateErrors) {
			die;
		}
	} elseif (isset($_POST['Delete'])) {
//	$action = 'Delete';
		echo "<div class='error'> <h3>Not implemented yet</h3></div>";
	} elseif (isset($_POST['Create'])) {
//	$action = 'Create';
		$record = PopulateRecord($_POST, $branchTemplate);
		$validateErrors = ValidateRecord($record);
		$updateErrors = $branchBase->insert($record);
		if ($validateErrors) {
			foreach ($validateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($updateErrors) {
			foreach ($updateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($validateErrors || $updateErrors) {
			die;
		}
	} else {
		header("Location: BranchDisplayGrid.php");
	}
	echo "<h1>Successful</h1>";

