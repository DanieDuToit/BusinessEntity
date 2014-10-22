<?php

	include_once "functions.inc.php";
	include_once 'BaseDB.class.php';

	class BaseCompany extends BaseDB
	{
		private $dbBaseClass;

		static $company = array(
			'Name'             => '',
			'CompanyCode'      => '',
			'Active'           => 1,
			'ShortName '       => '',
			'BusinessEntityId' => ''
		);


		// Default Constructor
		function __construct()
		{
			$this->dbBaseClass = new DBBase();
		}

		//Returns true if all mandatory fields in this instance have values

//    function checkMandatoryFields(){
//    
//        if($this->Name === "" ||  $this->Name = " "){
//            return "Name";
//        }
//        if($this->CompanyCode === "" || $this->CompanyCode= ""){
//            return "Company Code";
//        }
//        if($this->Active == "" || $this->Active = ""){
//            return "Active";
//        }
//        return true;
//        }


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
				'%b',
				'%s',
				%d END)",
				$this::$company['Name'],
				$this::$company['CompanyCode'],
				$this::$company['Active'],
				$this::$company['ShortName'],
				$this::$company['BusinessEntityId']);

			$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
			if (!$stmt) {
				$msg = dbGetErrorMsg();
				return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', $msg));
			}
			$result = sqlsrv_execute($stmt); // Executes a prepared statement.
			if (!$result) {
				$msg = dbGetErrorMsg();
				return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', $msg));
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
				[Name] = %s ,
				[CompanyCode] = %s,
				[Active] = %b,
				[ShortName] = %s,
				[BusinessEntityId] = %s
				WHERE %S = %S
				END",
				$this::$company['Name'],
				$this::$company['CompanyCode'],
				$this::$company['Active'],
				$this::$company['ShortName'],
				$this::$company['BusinessEntityId'],
				$id,
				$value);
			$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
			if (!$stmt) {
				$msg = dbGetErrorMsg();
				return array(printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', $msg));
			}
			$result = sqlsrv_execute($stmt); // Executes a prepared statement.
			if (!$result) {
				$msg = dbGetErrorMsg();
				return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', $msg));
			}
			return array();
		}
	}