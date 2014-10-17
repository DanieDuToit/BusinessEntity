<?php

	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/09
	 * Time: 12:29 PM
	 */
	$path = explode(DIRECTORY_SEPARATOR , __FILE__);

	include_once("functions.php");
	include_once 'DBBase.class.php';
	if (!class_exists('BranchBase')) {
		class BranchBase extends DBBase
		{
			private $dbBaseClass;
			static $Branch = array(
				'BranchCode'               => '',
				'Name'                     => '',
				'Active'                   => 1,
				'CustomMessage'            => '',
				'PhoneNumber'              => '',
				'FaxNumber'                => '',
				'PhysicalAddressLine1'     => '',
				'PhysicalAddressLine2'     => '',
				'PhysicalAddressLine3'     => '',
				'PhysicalAddressLine4'     => '',
				'PhysicalAddressLine5'     => '',
				'PostalAddressLine1'       => '',
				'PostalAddressLine2'       => '',
				'PostalAddressLine3'       => '',
				'PostalAddressLine4'       => '',
				'PostalAddressLine5'       => '',
				'BankName'                 => '',
				'BankBranchName'           => '',
				'BankBranchCode'           => '',
				'BankAccountNumber'        => '',
				'ContactPersonName'        => '',
				'ContactPersonNumber'      => '',
				'ContactPersonEmail'       => '',
				'AdminContactPersonName'   => '',
				'AdminContactPersonNumber' => '',
				'AdminContactPersonEmail'  => '',
				'Longitude'                => 0.000000,
				'Latitude'                 => 0.000000,
				'BusinessEntityId'         => '',
			);

			// Default Constructor
			function __construct()
			{
				$this->dbBaseClass = new DBBase();
			}

			/**
			 * @param $tableName: The name of the table which must be updated
			 * @param $idName: The name of the "ID" field
			 * @param $idValue: The value of the "ID" field
			 * @param $changedRecord: A BranchBase::Branch type parameter containing the changed record
			 *
			 * @return array: An array of errors or empty if no errors
				NB!!!
				Note: empty array is converted to null by non-strict equal '==' comparison.
				Use is_null() or '===' if there is possible of getting empty array.
			 */
			function update($tableName, $idName, $idValue, $changedRecord)
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
	            USE [CALM]
	            GO
	            UPDATE %s
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
	                ,[Longitude] = %f
	                ,[Latitude] = %f
	                ,[BusinessEntityId] = %d
                WHERE %s = %s
	            GO ",
					$tableName,
					formatParameter($this::$Branch['BranchCode'], 'text'),
					formatParameter($this::$Branch[$this::$Branch['Name']],'text'),
					formatParameter($this::$Branch[$this::$Branch['Active']],'checkbox'),
					formatParameter($this::$Branch[$this::$Branch['CustomMessage']],'text'),
					formatParameter($this::$Branch[$this::$Branch['PhoneNumber']],'text'),
					formatParameter($this::$Branch['FaxNumber'],'text'),
					formatParameter($this::$Branch['PhysicalAddressLine1'],'text'),
					formatParameter($this::$Branch['PhysicalAddressLine2'],'text'),
					formatParameter($this::$Branch['PhysicalAddressLine3'],'text'),
					formatParameter($this::$Branch['PhysicalAddressLine4'],'text'),
					formatParameter($this::$Branch['PhysicalAddressLine5'],'text'),
					formatParameter($this::$Branch['PostalAddressLine1'],'text'),
					formatParameter($this::$Branch['PostalAddressLine2'],'text'),
					formatParameter($this::$Branch['PostalAddressLine3'],'text'),
					formatParameter($this::$Branch['PostalAddressLine4'],'text'),
					formatParameter($this::$Branch['PostalAddressLine5'],'text'),
					formatParameter($this::$Branch['BankName'],'text'),
					formatParameter($this::$Branch['BankBranchName'],'text'),
					formatParameter($this::$Branch['BankBranchCode'],'text'),
					formatParameter($this::$Branch['BankAccountNumber'],'text'),
					formatParameter($this::$Branch['ContactPersonName'],'text'),
					formatParameter($this::$Branch['ContactPersonNumber'],'text'),
					formatParameter($this::$Branch['ContactPersonEmail'],'text'),
					formatParameter($this::$Branch['AdminContactPersonName'],'text'),
					formatParameter($this::$Branch['AdminContactPersonNumber'],'text'),
					formatParameter($this::$Branch['AdminContactPersonEmail'],'text'),
					formatParameter($this::$Branch['Longitude'],'text'),
					formatParameter($this::$Branch['Latitude'],'text'),
					formatParameter($this::$Branch['BusinessEntityId'],'text'),
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
	            USE [CALM]
	            GO
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
	                %d )
	            GO ",
					$this::$Branch['BranchCode'],
					$this::$Branch[$this::$Branch['Name']],
					$this::$Branch[$this::$Branch['Active']],
					$this::$Branch[$this::$Branch['CustomMessage']],
					$this::$Branch[$this::$Branch['PhoneNumber']],
					$this::$Branch['FaxNumber'],
					$this::$Branch['PhysicalAddressLine1'],
					$this::$Branch['PhysicalAddressLine2'],
					$this::$Branch['PhysicalAddressLine3'],
					$this::$Branch['PhysicalAddressLine4'],
					$this::$Branch['PhysicalAddressLine5'],
					$this::$Branch['PostalAddressLine1'],
					$this::$Branch['PostalAddressLine2'],
					$this::$Branch['PostalAddressLine3'],
					$this::$Branch['PostalAddressLine4'],
					$this::$Branch['PostalAddressLine5'],
					$this::$Branch['BankName'],
					$this::$Branch['BankBranchName'],
					$this::$Branch['BankBranchCode'],
					$this::$Branch['BankAccountNumber'],
					$this::$Branch['ContactPersonName'],
					$this::$Branch['ContactPersonNumber'],
					$this::$Branch['ContactPersonEmail'],
					$this::$Branch['AdminContactPersonName'],
					$this::$Branch['AdminContactPersonNumber'],
					$this::$Branch['AdminContactPersonEmail'],
					$this::$Branch['Longitude'],
					$this::$Branch['Latitude'],
					$this::$Branch['BusinessEntityId']
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
			private function checkMandatoryFields(){
				$fields = array();
				$i = 0;
				if (BranchBase::$Branch['BranchCode'] == null) {
					$fields[$i++] = 'A value for Branch Code must be supplied';
				}
				if (BranchBase::$Branch['Active'] == null) {
					$fields[$i] = 'A value for Active must be supplied';
				}
				return $fields;
			}

			private function checkFieldFormats() {
				$fields = array();
				$i = 0;
				if (!isValidPhoneNumber(BranchBase::$Branch['PhoneNumber'])) {
					$fields[$i++] = 'PhoneNumber contains invalid characters';
				}
				if (!isValidPhoneNumber(BranchBase::$Branch['FaxNumber'])) {
					$fields[$i++] = 'FaxNumber contains invalid characters';
				}
				if (!isValidCoordinate(BranchBase::$Branch['Longitude'])) {
					$fields[$i++] = 'Longitude contains invalid characters';
				}
				if (!isValidCoordinate(BranchBase::$Branch['Latitude'])) {
					$fields[$i] = 'Latitude contains invalid characters';
				}
				return $fields;
			}
		}
	}