<style>
	.error {
		color: red;
	}
</style>

<?php

	//include_once 'Includes/functions.inc.php';
	//include_once 'Classes/BaseClasses/BaseDB.class.php';
	//include_once 'Classes/BaseClasses/BaseCompany.class.php';
	include "Header.inc.php";

	//$post = buildPostForDebug($_POST);
	//echo $post;
	//die;
	$companyBase = new BaseCompany();
	if ($companyBase->conn === false) {
		die("ERROR: could not connect . " . printf('%s', dbGetErrorMsg()));

	}

	$companyTemplate = BaseCompany::$company;
	if (!isset($_POST['id'])) {
		echo "<div class='error'><h3> No ID was received for Action.php</h3>";
		die;
	}

	if (isset($_POST['Update'])) {

		$record = PopulateRecord($_POST, $companyTemplate);
		$validateErrors = ValidateRecord($record);
		$updateErrors = $companyBase->update("Company", "id", $_POST['id'], $record);
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
		//action = 'Delete'
		echo "<div class='error'> <h3>Not implemented yet</h3></div>";

	} elseif (isset($_POST['Create'])) {
		//action = create

		$record = PopulateRecord($_POST, $companyTemplate);
		$validateErrors = ValidateRecord($record);
		$insertErrors = $companyBase->insert($record);

		if ($validateErrors) {
			foreach ($validateErrors as $error) {

				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($insertErrors) {
			foreach ($insertErrors as $error) {
				echo "<div class='error'><h3>$error</h3></div><br>";
			}
		}
		if ($validateErrors || $insertErrors) {
			die;
		}
	} else {
		header("Location: CompanyDisplayGrid.php");
	}

	echo "<h1>Successful</h1>";


