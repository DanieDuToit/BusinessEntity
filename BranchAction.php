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

	//    echo buildPostForDebug($_POST);
	//    die;

	$recordBase = new BaseBranch();
	if (Database::getConnection() === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}
	$recordTemplate = BaseBranch::$Branch;
	if (!isset($_POST['id']) && !isset($_POST['Create'])) {
		echo "<div class='error'> <h3>No ID was received for ACTION.PHP</h3></div>";
		die;
	}
	if (isset($_POST['Update'])) {
		// Update BusinessEntity - update branch's record's BusinessParentId (Division) with new value
		// Get BusinessEntity with id = $_POST['BusinessEntityId'] and update BusinessParentId with $_POST['Division']
		// Get the BusinessEntity record
		$sqlCommand = "BEGIN UPDATE BusinessEntity SET BusinessEntityParentId = {$_POST['Division']} WHERE Id = {$_POST['BusinessEntityId']} END";
		$result = sqlsrv_query(Database::getConnection(), $sqlCommand);
		if (!$result) {
			die(printf('An error was received when the function sqlsrv_query was called.
						The error message was: %s', dbGetErrorMsg()));
		}

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
		// Begin a SQL transaction
//        $recordBase->dbTransactionBegin();

		// Create a BusinessEntity record
		if ($_POST['Active'] == 'Active') {
			$active = 1;
		} else {
			$active = 0;
		}
		$businessEntityBase = new BaseBusinessEntity();
		$sqlCommand = "BEGIN INSERT INTO [dbo].[BusinessEntity]
                       ([Name]
                       ,[BusinessEntityCode]
                       ,[BusinessEntityDescription]
                       ,[BusinessEntityParentId]
                       ,[BusinessLevelId]
                       ,[Active]
                       ,[BusinessEntityShortName])
                 VALUES
                       ( '{$_POST['Name']}'
                       ,'{$_POST['BranchCode']}'
                       ,''
                       ,{$_POST['Division']}
                       ,3
                       ,$active ,'') END";
		$result =  sqlsrv_query(Database::getConnection(), $sqlCommand);
		if ($result) {
			$sqlIdentity = "select @@identity as EntityId";
			$resultIdentity = sqlsrv_query(Database::getConnection(),$sqlIdentity);
			$rowIdentity = sqlsrv_fetch_array($resultIdentity);
			$entityId = $rowIdentity["EntityId"];
		}else{
			echo printf('An error was received when the function sqlsrv_query was called.
						The error message was: %s', dbGetErrorMsg());
			die();
		}
		// Create a Branch record (add the entity id from above
		$record = PopulateRecord($_POST, $recordTemplate);
		$record['BusinessEntityId']['Value'] = $entityId;
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

		// Update the BusinessEntity record

		// Commit the transaction
//        $recordBase->dbTransactionCommit();

	}
	header("Location: BranchDisplayGrid.php");


