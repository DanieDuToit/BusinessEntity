<?php

	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/09
	 * Time: 12:29 PM
	 */
	include_once("functions.php");
	include_once 'DBBase.class.php';
	if (!class_exists('BranchBase')) {
		class BranchBase extends DBBase
		{
			private $dbBaseClass;
			static $Branch = array(
				'BranchCode'               =>
					array('FieldName' => 'BranchCode', 'Helptext' => 'The branch code', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::required_par => true, FieldParameters::width_par => 250, FieldParameters::maxlength_par => 10)),
				'Name'                     =>
					array('FieldName' => 'Name', 'Helptext' => 'Branch Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'Active'                   =>
					array('FieldName' => 'Active', 'Helptext' => 'No Help Text', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'CustomMessage'            =>
					array('FieldName' => 'CustomMessage', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 500, FieldParameters::maxlength_par => 800 )),
				'PhoneNumber'              =>
					array('FieldName' => 'PhoneNumber', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'FaxNumber'                =>
					array('FieldName' => 'FaxNumber', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine1'     =>
					array('FieldName' => 'PhysicalAddressLine1', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine2'     =>
					array('FieldName' => 'PhysicalAddressLine2', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine3'     =>
					array('FieldName' => 'PhysicalAddressLine3', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine4'     =>
					array('FieldName' => 'PhysicalAddressLine4', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PhysicalAddressLine5'     =>
					array('FieldName' => 'PhysicalAddressLine5', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine1'       =>
					array('FieldName' => 'PostalAddressLine1', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 600)),
				'PostalAddressLine2'       =>
					array('FieldName' => 'PostalAddressLine2', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine3'       =>
					array('FieldName' => 'PostalAddressLine3', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine4'       =>
					array('FieldName' => 'PostalAddressLine4', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'PostalAddressLine5'       =>
					array('FieldName' => 'PostalAddressLine5', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankName'                 =>
					array('FieldName' => 'BankName', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankBranchName'           =>
					array('FieldName' => 'BankBranchName', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankBranchCode'           =>
					array('FieldName' => 'BankBranchCode', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'BankAccountNumber'        =>
					array('FieldName' => 'BankAccountNumber', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonName'        =>
					array('FieldName' => 'ContactPersonName', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonNumber'      =>
					array('FieldName' => 'ContactPersonNumber', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidPhoneNumber', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'ContactPersonEmail'       =>
					array('FieldName' => 'ContactPersonEmail', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidEmail', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonName'   =>
					array('FieldName' => 'AdminContactPersonName', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonNumber' =>
					array('FieldName' => 'AdminContactPersonNumber', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'AdminContactPersonEmail'  =>
					array('FieldName' => 'AdminContactPersonEmail', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => 'isValidEmail', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
				'Longitude'                =>
					array('FieldName' => 'Longitude', 'Helptext' => 'No Help Text', 'Type' => 'decimal', 'CheckValidFormat' => 'isValidCoordinate', 'Value' => 0.0000, 'Meta' =>
						array(FieldParameters::precision_par => 4)),
				'Latitude'                 =>
					array('FieldName' => 'Latitude', 'Helptext' => 'No Help Text', 'Type' => 'decimal', 'CheckValidFormat' => 'isValidCoordinate', 'Value' => 0.0000, 'Meta' =>
						array(FieldParameters::precision_par => 4)),
				'BusinessEntityId'         =>
					array('FieldName' => 'BusinessEntityId', 'Helptext' => 'No Help Text', 'Type' => 'int', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
						array(FieldParameters::width_par => 10))
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
				$this::$Branch = $changedRecord;
				// Check if all mandatory fields were supplied
				$invalidFields = $this->checkMandatoryFields();
				// Check if field's formats and valid characters are correct
				$invalidFields2 = $this->checkFieldFormats();
				if (count((array)$invalidFields) > 0) {
					if (count((array)$invalidFields2) > 0) {
						foreach ($invalidFields2 as $invalidField) {
							array_push($invalidFields, $invalidField);
						}
					}
					// Some mandatory fields were left empty
					return $invalidFields;
				}
				$sqlCommand = sprintf("
	            UPDATE Branch
	                SET [BranchCode] = '%s'
	                ,[Name] = '%s'
	                ,[Active] = '%s'
	                ,[CustomMessage] = '%s'
	                ,[PhoneNumber] = '%s'
	                ,[FaxNumber] = '%s'
	                ,[PhysicalAddressLine1] = '%s'
	                ,[PhysicalAddressLine2] = '%s'
	                ,[PhysicalAddressLine3] = '%s'
	                ,[PhysicalAddressLine4] = '%s'
	                ,[PhysicalAddressLine5] = '%s'
	                ,[PostalAddressLine1] = '%s'
	                ,[PostalAddressLine2] = '%s'
	                ,[PostalAddressLine3] = '%s'
	                ,[PostalAddressLine4] = '%s'
	                ,[PostalAddressLine5] = '%s'
	                ,[BankName] = '%s'
	                ,[BankBranchName] = '%s'
	                ,[BankBranchCode] = '%s'
	                ,[BankAccountNumber] = '%s'
	                ,[ContactPersonName] = '%s'
	                ,[ContactPersonNumber] = '%s'
	                ,[ContactPersonEmail] = '%s'
	                ,[AdminContactPersonName] = '%s'
	                ,[AdminContactPersonNumber] = '%s'
	                ,[AdminContactPersonEmail] = '%s'
	                ,[Longitude] = '%f'
	                ,[Latitude] = '%f'
	                ,[BusinessEntityId] = '%d'
                WHERE '%s' = '%s'",
					$this::$Branch['BranchCode']['Value'],
					$this::$Branch['Name']['Value'],
					$this::$Branch['Active']['Value'],
					$this::$Branch['CustomMessage']['Value'],
					$this::$Branch['PhoneNumber']['Value'],
					$this::$Branch['FaxNumber']['Value'],
					$this::$Branch['PhysicalAddressLine1']['Value'],
					$this::$Branch['PhysicalAddressLine2']['Value'],
					$this::$Branch['PhysicalAddressLine3']['Value'],
					$this::$Branch['PhysicalAddressLine4']['Value'],
					$this::$Branch['PhysicalAddressLine5']['Value'],
					$this::$Branch['PostalAddressLine1']['Value'],
					$this::$Branch['PostalAddressLine2']['Value'],
					$this::$Branch['PostalAddressLine3']['Value'],
					$this::$Branch['PostalAddressLine4']['Value'],
					$this::$Branch['PostalAddressLine5']['Value'],
					$this::$Branch['BankName']['Value'],
					$this::$Branch['BankBranchName']['Value'],
					$this::$Branch['BankBranchCode']['Value'],
					$this::$Branch['BankAccountNumber']['Value'],
					$this::$Branch['ContactPersonName']['Value'],
					$this::$Branch['ContactPersonNumber']['Value'],
					$this::$Branch['ContactPersonEmail']['Value'],
					$this::$Branch['AdminContactPersonName']['Value'],
					$this::$Branch['AdminContactPersonNumber']['Value'],
					$this::$Branch['AdminContactPersonEmail']['Value'],
					$this::$Branch['Longitude']['Value'],
					$this::$Branch['Latitude']['Value'],
					$this::$Branch['BusinessEntityId']['Value'],
					$idName,
					$idValue
				);

				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
				if (!$stmt) {
					return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', sqlsrv_errors()));
				}
				$result = sqlsrv_execute($stmt); // Executes a prepared statement.
				if (!$result) {
					return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', sqlsrv_errors()));
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
				// Check if all mandatory fields were supplied
				$invalidFields = $this->checkMandatoryFields();
				// Check if field's formats and valid characters are correct
				$invalidFields2 = $this->checkFieldFormats();
				if (count((array)$invalidFields) > 0) {
					if (count((array)$invalidFields2) > 0) {
						foreach ($invalidFields2 as $invalidField) {
							array_push($invalidFields, $invalidField);
						}
					}
					// Some field errors are present
					return $invalidFields;
				}
				$sqlCommand = sprintf("
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
	                '%s',
	                '%s',
	                '%b',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                '%s',
	                %f,
	                %f,
	                %d )",
					$this::$Branch['BranchCode']['Value'],
					$this::$Branch['Name']['Value'],
					$this::$Branch['Active']['Value'],
					$this::$Branch['CustomMessage']['Value'],
					$this::$Branch['PhoneNumber']['Value'],
					$this::$Branch['FaxNumber']['Value'],
					$this::$Branch['PhysicalAddressLine1']['Value'],
					$this::$Branch['PhysicalAddressLine2']['Value'],
					$this::$Branch['PhysicalAddressLine3']['Value'],
					$this::$Branch['PhysicalAddressLine4']['Value'],
					$this::$Branch['PhysicalAddressLine5']['Value'],
					$this::$Branch['PostalAddressLine1']['Value'],
					$this::$Branch['PostalAddressLine2']['Value'],
					$this::$Branch['PostalAddressLine3']['Value'],
					$this::$Branch['PostalAddressLine4']['Value'],
					$this::$Branch['PostalAddressLine5']['Value'],
					$this::$Branch['BankName']['Value'],
					$this::$Branch['BankBranchName']['Value'],
					$this::$Branch['BankBranchCode']['Value'],
					$this::$Branch['BankAccountNumber']['Value'],
					$this::$Branch['ContactPersonName']['Value'],
					$this::$Branch['ContactPersonNumber']['Value'],
					$this::$Branch['ContactPersonEmail']['Value'],
					$this::$Branch['AdminContactPersonName']['Value'],
					$this::$Branch['AdminContactPersonNumber']['Value'],
					$this::$Branch['AdminContactPersonEmail']['Value'],
					$this::$Branch['Longitude']['Value'],
					$this::$Branch['Latitude']['Value'],
					$this::$Branch['BusinessEntityId']['Value']
				);

				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
				if (!$stmt) {
					return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', sqlsrv_errors()));
				}
				$result = sqlsrv_execute($stmt); // Executes a prepared statement.
				if (!$result) {
					return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', sqlsrv_errors()));
				}
				return array();
				// NB!!!
				// Note: empty array is converted to null by non-strict equal '==' comparison.
				// Use is_null() or '===' if there is possible of getting empty array.
			}

			/**
			 * @return array: An array of invalid fields will be returned - empty array if none
			 */
			private function checkMandatoryFields()
			{
				$fields = array();
				$i = 0;
				if (BranchBase::$Branch['BranchCode']['Value'] == null) {
					$fields[$i++] = 'A value for Branch Code must be supplied';
				}
				if (BranchBase::$Branch['Active']['Value'] == null) {
					$fields[$i] = 'A value for Active must be supplied';
				}
				return $fields;
			}

			private function checkFieldFormats()
			{
				$fields = array();
				$i = 0;
				if (!isValidPhoneNumber(BranchBase::$Branch['PhoneNumber']['Value'])) {
					$fields[$i++] = 'PhoneNumber contains invalid characters';
				}
				if (!isValidPhoneNumber(BranchBase::$Branch['FaxNumber']['Value'])) {
					$fields[$i++] = 'FaxNumber contains invalid characters';
				}
				if (!isValidCoordinate(BranchBase::$Branch['Longitude']['Value'])) {
					$fields[$i++] = 'Longitude contains invalid characters';
				}
				if (!isValidCoordinate(BranchBase::$Branch['Latitude']['Value'])) {
					$fields[$i] = 'Latitude contains invalid characters';
				}
				return $fields;
			}
		}
	}