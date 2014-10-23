<?php

	/**
	 * User: dutoitd1
	 * Date: 2014/10/20
	 * Time: 12:29 PM
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
	include_once "BaseDB.class.php";
	if (!class_exists('BaseBranch')) {
		class BaseBranch extends BaseDB
		{
			private $dbBaseClass;
			static $Branch = array(
				'BranchCode'               =>
					array('FieldName' => 'BranchCode', 'FriendlyName' => 'Branch Code', 'Helptext' => 'The branch code', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::required_par => true, FieldParameters::width_par => 250, FieldParameters::maxlength_par => 10)),
				'Name'                     =>
					array('FieldName' => 'Name', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'Branch Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'Active'                   =>
					array('FieldName' => 'Active', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'CustomMessage'            =>
					array('FieldName' => 'CustomMessage', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 500, FieldParameters::maxlength_par => 800)),
				'PhoneNumber'              =>
					array('FieldName' => 'PhoneNumber', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'FaxNumber'                =>
					array('FieldName' => 'FaxNumber', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine1'     =>
					array('FieldName' => 'PhysicalAddressLine1', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine2'     =>
					array('FieldName' => 'PhysicalAddressLine2', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine3'     =>
					array('FieldName' => 'PhysicalAddressLine3', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine4'     =>
					array('FieldName' => 'PhysicalAddressLine4', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine5'     =>
					array('FieldName' => 'PhysicalAddressLine5', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine1'       =>
					array('FieldName' => 'PostalAddressLine1', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 600)),
				'PostalAddressLine2'       =>
					array('FieldName' => 'PostalAddressLine2', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine3'       =>
					array('FieldName' => 'PostalAddressLine3', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine4'       =>
					array('FieldName' => 'PostalAddressLine4', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine5'       =>
					array('FieldName' => 'PostalAddressLine5', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankName'                 =>
					array('FieldName' => 'BankName', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankBranchName'           =>
					array('FieldName' => 'BankBranchName', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankBranchCode'           =>
					array('FieldName' => 'BankBranchCode', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankAccountNumber'        =>
					array('FieldName' => 'BankAccountNumber', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonName'        =>
					array('FieldName' => 'ContactPersonName', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonNumber'      =>
					array('FieldName' => 'ContactPersonNumber', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonEmail'       =>
					array('FieldName' => 'ContactPersonEmail', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidEmail', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonName'   =>
					array('FieldName' => 'AdminContactPersonName', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonNumber' =>
					array('FieldName' => 'AdminContactPersonNumber', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonEmail'  =>
					array('FieldName' => 'AdminContactPersonEmail', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidEmail', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'Longitude'                =>
					array('FieldName' => 'Longitude', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'decimal', 'CheckValidFormat' => 'isValidCoordinate', 'Value' => 0.0000, 'Meta' =>
						array(FieldParameters::precision_par => 4)),
				'Latitude'                 =>
					array('FieldName' => 'Latitude', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'decimal', 'CheckValidFormat' => 'isValidCoordinate', 'Value' => 0.0000, 'Meta' =>
						array(FieldParameters::precision_par => 4)),
				'BusinessEntityId'         =>
					array('FieldName' => 'BusinessEntityId', 'FriendlyName' => 'Supply friendly name', 'Helptext' => 'No Help Text', 'Type' => 'int', 'CheckValidFormat' => 'isDigitOnly', 'Value' => '', 'Meta' =>
						array(FieldParameters::maxlength_par => 8, FieldParameters::nullIfZero_par => true))
			);

			// Default Constructor
			function __construct()
			{
				$this->dbBaseClass = new BaseDB();
			}

			/**
			 * @param $tableName : The name of the table which must be updated
			 * @param $idName : The name of the "ID" field
			 * @param $idValue : The value of the "ID" field
			 * @param $changedRecord : A BaseBranch::Branch type parameter containing the changed record
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
				$sqlCommand = sprintf("BEGIN
	            UPDATE Branch
	                SET [BranchCode] = %s
	                ,[Name] = %s
	                ,[Active] = %s
	                ,[CustomMessage] = %s
	                ,[PhoneNumber] = %s
	                ,[FaxNumber] = %s
	                ,[PhysicalAddressLine1] = %s
	                ,[PhysicalAddressLine2] = %s
	                ,[PhysicalAddressLine3] = %s
	                ,[PhysicalAddressLine4] = %s
	                ,[PhysicalAddressLine5] = %s
	                ,[PostalAddressLine1] = %s
	                ,[PostalAddressLine2] = %s
	                ,[PostalAddressLine3] = %s
	                ,[PostalAddressLine4] = %s
	                ,[PostalAddressLine5] = %s
	                ,[BankName] = %s
	                ,[BankBranchName] = %s
	                ,[BankBranchCode] = %s
	                ,[BankAccountNumber] = %s
	                ,[ContactPersonName] = %s
	                ,[ContactPersonNumber] = %s
	                ,[ContactPersonEmail] = %s
	                ,[AdminContactPersonName] = %s
	                ,[AdminContactPersonNumber] = %s
	                ,[AdminContactPersonEmail] = %s
	                ,[Longitude] = %f
	                ,[Latitude] = %f
	                ,[BusinessEntityId] = %s
                WHERE %s = %s END",
					$changedRecord['BranchCode']['Value'],
					$changedRecord['Name']['Value'],
					$changedRecord['Active']['Value'],
					$changedRecord['CustomMessage']['Value'],
					$changedRecord['PhoneNumber']['Value'],
					$changedRecord['FaxNumber']['Value'],
					$changedRecord['PhysicalAddressLine1']['Value'],
					$changedRecord['PhysicalAddressLine2']['Value'],
					$changedRecord['PhysicalAddressLine3']['Value'],
					$changedRecord['PhysicalAddressLine4']['Value'],
					$changedRecord['PhysicalAddressLine5']['Value'],
					$changedRecord['PostalAddressLine1']['Value'],
					$changedRecord['PostalAddressLine2']['Value'],
					$changedRecord['PostalAddressLine3']['Value'],
					$changedRecord['PostalAddressLine4']['Value'],
					$changedRecord['PostalAddressLine5']['Value'],
					$changedRecord['BankName']['Value'],
					$changedRecord['BankBranchName']['Value'],
					$changedRecord['BankBranchCode']['Value'],
					$changedRecord['BankAccountNumber']['Value'],
					$changedRecord['ContactPersonName']['Value'],
					$changedRecord['ContactPersonNumber']['Value'],
					$changedRecord['ContactPersonEmail']['Value'],
					$changedRecord['AdminContactPersonName']['Value'],
					$changedRecord['AdminContactPersonNumber']['Value'],
					$changedRecord['AdminContactPersonEmail']['Value'],
					$changedRecord['Longitude']['Value'],
					$changedRecord['Latitude']['Value'],
					$changedRecord['BusinessEntityId']['Value'],
					$idName,
					$idValue
				);
				$this::$Branch = $changedRecord;
//				echo ($sqlCommand); die();
//				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
//				if (!$stmt) {
//					return array(printf('An error was received when the function sqlsrv_prepare was called.
//						The error message was: %s', dbGetErrorMsg()));
//				}
				$result = sqlsrv_query($this->dbBaseClass->conn, $sqlCommand); //sqlsrv_execute($stmt); // Executes a prepared statement.
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
				$sqlCommand = sprintf("
				BEGIN
	            INSERT INTO [dbo].[Branch] (
	                [BranchCode]
	                ,[Name]
	                ,[Active]
	                ,[CustomMessage]
	                ,[PhoneNumber]
	                ,[FaxNumber]
	                ,[PhysicalAddressLine1]
	                ,[PhysicalAddressLine2]
	                ,[PhysicalAddressLine3]
	                ,[PhysicalAddressLine4]
	                ,[PhysicalAddressLine5]
	                ,[PostalAddressLine1]
	                ,[PostalAddressLine2]
	                ,[PostalAddressLine3]
	                ,[PostalAddressLine4]
	                ,[PostalAddressLine5]
	                ,[BankName]
	                ,[BankBranchName]
	                ,[BankBranchCode]
	                ,[BankAccountNumber]
	                ,[ContactPersonName]
	                ,[ContactPersonNumber]
	                ,[ContactPersonEmail]
	                ,[AdminContactPersonName]
	                ,[AdminContactPersonNumber]
	                ,[AdminContactPersonEmail]
	                ,[Longitude]
	                ,[Latitude]
	                ,[BusinessEntityId] )
	             VALUES (
	                %s,
	                %s,
	                %b,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %s,
	                %f,
	                %f,
	                %s )
                END",
					$record['BranchCode']['Value'],
					$record['Name']['Value'],
					$record['Active']['Value'],
					$record['CustomMessage']['Value'],
					$record['PhoneNumber']['Value'],
					$record['FaxNumber']['Value'],
					$record['PhysicalAddressLine1']['Value'],
					$record['PhysicalAddressLine2']['Value'],
					$record['PhysicalAddressLine3']['Value'],
					$record['PhysicalAddressLine4']['Value'],
					$record['PhysicalAddressLine5']['Value'],
					$record['PostalAddressLine1']['Value'],
					$record['PostalAddressLine2']['Value'],
					$record['PostalAddressLine3']['Value'],
					$record['PostalAddressLine4']['Value'],
					$record['PostalAddressLine5']['Value'],
					$record['BankName']['Value'],
					$record['BankBranchName']['Value'],
					$record['BankBranchCode']['Value'],
					$record['BankAccountNumber']['Value'],
					$record['ContactPersonName']['Value'],
					$record['ContactPersonNumber']['Value'],
					$record['ContactPersonEmail']['Value'],
					$record['AdminContactPersonName']['Value'],
					$record['AdminContactPersonNumber']['Value'],
					$record['AdminContactPersonEmail']['Value'],
					$record['Longitude']['Value'],
					$record['Latitude']['Value'],
					$record['BusinessEntityId']['Value']
				);
				$this::$Branch = $record;

//				echo $sqlCommand; die;
//				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
//				if (!$stmt) {
//					return array(printf('An error was received when the function sqlsrv_prepare was called.
//						The error message was: %s', dbGetErrorMsg()));
//				}
				$result = sqlsrv_query($this->dbBaseClass->conn, $sqlCommand); //sqlsrv_execute($stmt); // Executes a prepared statement.
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