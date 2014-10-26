<?php


    include_once "functions.inc.php";
    include_once 'BaseDB.class.php';

    class BaseBusinessEntity extends BaseDB
    {
        public $dbBaseClass;

        static $BusinessEntity = array(

            'Name' =>
                array('FieldName' => 'Name', 'FriendlyName' => 'Name', 'Helptext' => 'BusinesEntity Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::required_par => true, FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
            'BusinessEntityCode' =>
                array('FieldName' => 'BusinessEntityCode', 'FriendlyName' => 'Code', 'Helptext' => 'Business Entity code', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
            'BusinessEntityDescription' =>
                array('FieldName' => 'BusinessEntityDescription', 'FriendlyName' => 'Description', 'Helptext' => 'No Help Text', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
            'BusinessEntityParentId' =>
                array('FieldName' => 'BusinessEntityParentId', 'FriendlyName' => 'Parent Id', 'Helptext' => 'No Help Text', 'Type' => 'int', 'CheckValidFormat' => 'isDigitOnly', 'Value' => '', 'Meta' =>
                    array(FieldParameters::maxlength_par => 8, FieldParameters::nullIfZero_par => true)),
            'BusinessLevelId' =>
                array('FieldName' => 'BusinessLevelId', 'FriendlyName' => 'Business Level Id', 'Helptext' => 'No Help Text', 'Type' => 'int', 'CheckValidFormat' => 'isDigitOnly', 'Value' => '', 'Meta' =>
                    array(FieldParameters::maxlength_par => 8)),
            'Active' =>
                array('FieldName' => 'Active', 'FriendlyName' => 'Active', 'Helptext' => 'No Help Text', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
                    array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 50)),
            'BusinessEntityShortName' =>
                array('FieldName' => 'BusinessEntityShortName', 'FriendlyName' => 'Short Name', 'Helptext' => 'Short Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                    array(FieldParameters::width_par => 250, FieldParameters::maxlength_par => 10))

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
                return array(printf('A record was expected as a parameter but a %s was received', gettype($record)));
            }

            $this::$BusinessEntity = $record;
            $sqlCommand = sprintf("
				BEGIN
				INSERT INTO [dbo].[BusinessEntity] (
				[Name],
				[BusinessEntityCode],
				[BusinessEntityDescription],
				[BusinessEntityParentId],
				[BusinessLevelId],
				[Active],
				[BusinessEntityShortName])
				VALUES (
				 '%s',
				 '%s',
				 '%s',
				 %d,
				 %d,
				 %d,
				 '%s')
				 END",
                $this::$BusinessEntity['Name']['Value'],
                $this::$BusinessEntity['BusinessEntityCode']['Value'],
                $this::$BusinessEntity['BusinessEntityDescription']['Value'],
                $this::$BusinessEntity['BusinessEntityParentId']['Value'],
                2,
                $this::$BusinessEntity['Active']['Value'],
                $this::$BusinessEntity['BusinessEntityShortName']['Value'],
                $this::$BusinessEntity['BusinessEntityId']['Value']
            );

            $stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
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
            $this::$BusinessEntity = $changeRecord;
            $sqlCommand = sprintf("
				BEGIN
				UPDATE BusinessEntity
				SET
				[Name] = '%s',
				[BusinessEntityCode] = '%s',
				[BusinessEntityDescription] = '%s',
				[BusinessEntityParentId] = %s,
				[BusinessLevelId] = %d,
				[Active]= %d,
				[BusinessEntityShortName] = '%s' WHERE %s = '%s' END",
            $this::$BusinessEntity['Name']['Value'],
            $this::$BusinessEntity['BusinessEntityCode']['Value'],
            $this::$BusinessEntity['BusinessEntityDescription']['Value'],
            $this::$BusinessEntity['BusinessEntityParentId']['Value'],
            2,
            $this::$BusinessEntity['Active']['Value'],
            $this::$BusinessEntity['BusinessEntityShortName']['Value'],
            $id,
            $value);
            $stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
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