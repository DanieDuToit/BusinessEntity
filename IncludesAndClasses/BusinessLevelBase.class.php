<?php
/**
 * Created by PhpStorm.
 * User: Danie
 * Date: 2014/10/20
 * Time: 08:27 PM
 *
 * Every field in the record base class contains the following objects:
 * (1) Field name
 * (2) A user friendly name for the field
 * (3) Help text
 * (4) Field type (int, string, date, etc.
 * (5)CheckValidFormat: If this value is set, a name of a function must be supplied that will do the validation on the value of the field
 *    Note: If the "required_par" setting of the "Meta" array is not set, the validation will not happen
 * (6) Value of the field
 * (7) Meta data array: Parameters must be set here - See "abstract class FieldParameters" in functions.inc.php for valid parameters.
 */

include_once("functions.inc.php");
include_once 'DBBase.class.php';
if (!class_exists('BusinessLevelBase')) {
	class BusinessLevelBase extends DBBase
	{
		private $dbBaseClass;
		static $BusinessLevel = array(
			'Name'   =>
				array('FieldName' => 'Name', 'FriendlyName' => 'Business Level Name', 'Helptext' => 'Business Level Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
					array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50, FieldParameters::required_par => true)),
			'Active' =>
				array('FieldName' => 'Active', 'FriendlyName' => 'Active', 'Helptext' => 'Active?', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
					array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
		);

		// Default Constructor
		function __construct()
		{
			$this->dbBaseClass = new DBBase();
		}

		/**
		 * @param $tableName : The name of the table which must be updated
		 * @param $idName : The name of the "ID" field
		 * @param $idValue : The value of the "ID" field
		 * @param $changedRecord : A BranchBase::Branch type parameter containing the changed record
		 *
		 * @return array: An array of errors or empty if no errors
		 * NB!!!
		 * Note: empty array is converted to null by non-strict equal '==' comparison.
		 * Use is_null() or '===' if there is possible of getting empty array.
		 */
		function update($idName, $idValue, $changedRecord)
		{
			if (!is_array($changedRecord)) {
				return array(printf('A Branch record was expected as a parameter but a %s was received', gettype($changedRecord)));
			}
			// Populate the Branch array
			$this::$BusinessLevel = $changedRecord;
			$sqlCommand = sprintf("
				BEGIN
                UPDATE Branch
	                SET [Name] = %s
	                ,[Active] = %s
                WHERE %s = %s
                END",
				$this::$BusinessLevel['Name']['Value'],
				$this::$BusinessLevel['Active']['Value'],
				$idName,
				$idValue
			);
//				echo ($sqlCommand); die();
			$stmt = sqlsrv_prepare($this->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
			if (!$stmt) {
				return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', dbGetErrorMsg()));
			}
			$result = sqlsrv_execute($stmt); // Executes a prepared statement.
			if (!$result) {
				return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', dbGetErrorMsg()));
			}
			return array();
			// NB!!!
			// Note: empty array is converted to null by non-strict equal '==' comparison.
			// Use is_null() or '===' if there is possible of getting empty array.
		}

		/**
		 * @param $record : A $Branch array
		 *
		 * @return array: An array of errors or empty if no errors
		 * NB!!!
		 * Note: empty array is converted to null by non-strict equal '==' comparison.
		 * Use is_null() or '===' if there is possible of getting empty array.
		 */
		public function insert($record)
		{
			// Populate the Branch array
			if (!is_array($record)) {
				return array(printf('A Branch record was expected as a parameter but a %s was received', gettype($record)));
			}
			$this::$Branch = $record;
			$sqlCommand = sprintf("
				BEGIN
	            INSERT INTO [dbo].[BusinessLevel] (
	                ,[Name]
	                ,[Active])
	             VALUES (
	                %s,
	                %s,
                END",
				$this::$Branch['Name']['Value'],
				$this::$Branch['Active']['Value']
			);

			$stmt = sqlsrv_prepare($this->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
			if (!$stmt) {
				return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', dbGetErrorMsg()));
			}
			$result = sqlsrv_execute($stmt); // Executes a prepared statement.
			if (!$result) {
				return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', dbGetErrorMsg()));
			}
			return array();
			// NB!!!
			// Note: empty array is converted to null by non-strict equal '==' comparison.
			// Use is_null() or '===' if there is possible of getting empty array.
		}
	}
}