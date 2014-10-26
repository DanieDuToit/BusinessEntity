<?php

	include_once "functions.inc.php";
	include_once 'BaseDB.class.php';

	class BaseCompany extends BaseDB
	{
		private $dbBaseClass;

		static $company = array(
			'Name'             =>
                array('FieldName' => 'Name', 'FriendlyName' => 'Name', 'Helptext' => '', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::required_par => true,FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
			'CompanyCode'      =>
                array('FieldName' => 'CompanyCode', 'FriendlyName' => '', 'Helptext' => 'Company code', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
			'Active'           =>
                array('FieldName' => 'Active', 'FriendlyName' => 'Active', 'Helptext' => 'Tick to make this record active', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
					array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
			'ShortName'       =>
                array('FieldName' => 'ShortName', 'FriendlyName' => '', 'Helptext' => 'Short Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 6)),
			'BusinessEntityId' =>
                array('FieldName' => 'BusinessEntityId', 'FriendlyName' => '', 'Helptext' => '', 'Type' => 'int', 'CheckValidFormat' => 'isDigitOnly', 'Value' => '', 'Meta' =>
                   array(FieldParameters::maxlength_par => 8, FieldParameters::nullIfZero_par => true))
		);


		// Default Constructor
		function __construct()
		{
			$this->dbBaseClass = new BaseDB();
		}




		public function insert($record)
		{
			//populate $company array
			if (!is_array($record)) {
				return array(printf('A record was expected as a prameter but a %s was received', gettype($record)));
			}

			$this::$company = $record;
			$sqlCommand = sprintf("
				BEGIN
				INSERT INTO [dbo].[Company] (
				[Name],
				[CompanyCode],
				[Active],
				[ShortName],
				[BusinessEntityId] )
				VALUES (
				 '%s',
				 '%s',
				 %d,
				 '%s',
				 %d) END",
				$this::$company['Name']['Value'],
				$this::$company['CompanyCode']['Value'],
				$this::$company['Active']['Value'],
				$this::$company['ShortName']['Value'],
				$this::$company['BusinessEntityId']['Value']
            );

			$stmt = sqlsrv_prepare(Database::getConnection(), $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
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
		}


		public function update($id, $value, $changeRecord)
		{

			if (!is_array($changeRecord)) {
				return array(printf('A Company Record was expected as a parameter but a %s was received', gettype($changeRecord)));
			}
			//populate the company array
			$this::$company = $changeRecord;

			$sqlCommand = sprintf("
				BEGIN
				UPDATE Company
				SET
				[Name] = '%s' ,
				[CompanyCode] = '%s',
				[Active] = %d,
				[ShortName] = '%s',
				[BusinessEntityId] = %d
				WHERE %s = '%s'
				END",
				$this::$company['Name']['Value'],
				$this::$company['CompanyCode']['Value'],
				$this::$company['Active']['Value'],
				$this::$company['ShortName']['Value'],
				$this::$company['BusinessEntityId']['Value'],
				$id,
				$value);
			$stmt = sqlsrv_prepare(Database::getConnection(), $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
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
		}
	}