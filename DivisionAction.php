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
	 * User: dutoitd1
	 * Date: 2014/10/22
	 * Time: 08:42 AM
	 */
	//	include_once "Classes/BaseClasses/BaseDB.class.php";
	//	include_once "Classes/BaseClasses/BaseDivision.class.php";
	//	include_once "Includes/functions.inc.php";
	include "Header.inc.php";

	//	echo buildPostForDebug($_POST);
	//	die;

	$recordBase = new BaseDivision();
	if ($recordBase->conn === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	$recordTemplate = BaseDivision::$Division;
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
			if ($updateErrors) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
			die;
		}
	}
	header("Location: DivisionDisplayGrid.php");
