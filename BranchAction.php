<style>
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
	include "Header.inc.php";
//	include_once "Classes/BaseClasses/BaseDB.class.php";
//	include_once "Classes/BaseClasses/BaseBranch.class.php";
//	include_once "Includes/functions.inc.php";
	//	echo buildPostForDebug($_POST);
	//	die();
	$recordBase = new BaseBranch();
	if ($recordBase->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	$recordTemplate = BaseBranch::$Branch;
	if (!isset($_POST['id']) && !isset($_POST['Create'])) {
		echo "<div class='error'> <h3>No ID was received for ACTION.PHP</h3></div>";
		die;
	}
	if (isset($_POST['Update'])) {
//	$action = 'Update';
		$record = PopulateRecord($_POST, $recordTemplate);
		$validateErrors = ValidateRecord($record);
		$updateErrors = $recordBase->update("id", $_POST['id'], $record);
		if ($validateErrors) {
			foreach ($validateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($updateErrors) {
			echo "<div class='error'><h3>$updateErrors</h3></div><br>";
		}
		if ($validateErrors || $updateErrors) {
			die;
		}
	} elseif (isset($_POST['Delete'])) {
//	$action = 'Delete';
		echo "<div class='error'> <h3>Not implemented yet</h3></div>";
	} elseif (isset($_POST['Create'])) {
//	$action = 'Create';
		$record = PopulateRecord($_POST, $recordTemplate);
		$validateErrors = ValidateRecord($record);
		if ($validateErrors) {
			foreach ($validateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
			die;
		}
		$updateErrors = $recordBase->insert($record);
		if ($updateErrors) {
			foreach ($updateErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
			die;
		}
	}
	header("Location: BranchDisplayGrid.php");


