<?php
	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/22
	 * Time: 08:42 AM
	 */
	include "Header.inc.php";

	$recordBase = new BaseBusinessEntity();
	if (Database::getConnection() === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	$recordTemplate = BaseBusinessEntity::$BusinessEntity;
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
		echo "<div class='message'> <h3>Not implemented yet</h3></div>";
		die;
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
		$record['BusinessEntityParentId']['Value'] = $_POST['BusinessEntityParentId'];
		$updateErrors = $recordBase->insert($record);
		if ($updateErrors) {
			if ($updateErrors) {
				echo "<div class='error'><h3>$updateErrors</h3></div><br>";
			}
			die;
		}
	}
	header("Location: DivisionDisplayGrid.php");
