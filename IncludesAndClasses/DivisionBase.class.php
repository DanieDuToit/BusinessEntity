<?php
	/**
	 * User: Danie
	 * Date: 2014/10/21
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
	if (!class_exists('DivisionBase')) {
		class DivisionBase extends DBBase
		{
			private $dbBaseClass;
			static $Division = array(
				'Name'                      =>
					array('FieldName' => 'Name', 'FriendlyName' => 'Division Name', 'Helptext' => 'Division Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::required_par => true)),
				'BusinessEntityCode'        =>
					array('FieldName' => 'BusinessEntityCode', 'FriendlyName' => 'Division Code', 'Helptext' => 'Division Code', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array()),
				'BusinessEntityDescription' =>
					array('FieldName' => 'BusinessEntityDescription', 'FriendlyName' => 'Division Description', 'Helptext' => 'Division Description', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array()),
				'BusinessEntityShortName'   =>
					array('FieldName' => 'BusinessEntityShortName', 'FriendlyName' => 'Short Name', 'Helptext' => 'Division Short Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array()),
				'Active'                    =>
					array('FieldName' => 'Active', 'FriendlyName' => 'Active', 'Helptext' => 'Active?', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
						array()),
			);

			// Default Constructor
			function __construct()
			{
				$this->dbBaseClass = new DBBase();
			}

			/**
			 * @param $idName : The name of the "ID" field
			 * @param $idValue : The value of the "ID" field
			 * @param $changedRecord : A DivisionBase::Division type parameter containing the changed record
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
                UPDATE [dbo].[BusinessEntity]
	                SET [Name] = %s
					,[BusinessEntityCode] = %s
					,[BusinessEntityDescription] = %s
					,[BusinessEntityParentId] = %s
					,[BusinessLevelId] = %s
					,[Active] = %s
					,[BusinessEntityShortName] = %s
                WHERE %s = %s
                END",
					$this::$BusinessLevel['Name']['Value'],
					$this::$BusinessLevel['BusinessEntityCode']['Value'],
					$this::$BusinessLevel['BusinessEntityDescription']['Value'],
					$this::$BusinessLevel['BusinessEntityParentId']['Value'],
					$this::$BusinessLevel['BusinessLevelId']['Value'],
					$this::$BusinessLevel['Active']['Value'],
					$this::$BusinessLevel['BusinessEntityShortName']['Value'],
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
			 * @param $record : A $Division array
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
				$this::$BusinessLevel = $record;
				$sqlCommand = sprintf("
				BEGIN
	            INSERT INTO [dbo].[BusinessEntity] (
	                [Name]
					,[BusinessEntityCode]
					,[BusinessEntityDescription]
					,[BusinessEntityParentId]
					,[BusinessLevelId]
					,[Active]
					,[BusinessEntityShortName]
	             VALUES (
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s)
                END",
					$this::$BusinessLevel['Name']['Value'],
					$this::$BusinessLevel['BusinessEntityCode']['Value'],
					$this::$BusinessLevel['BusinessEntityDescription']['Value'],
					$this::$BusinessLevel['BusinessEntityParentId']['Value'],
					$this::$BusinessLevel['BusinessLevelId']['Value'],
					$this::$BusinessLevel['Active']['Value'],
					$this::$BusinessLevel['BusinessEntityShortName']['Value']
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