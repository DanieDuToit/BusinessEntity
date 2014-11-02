<?php
    /**
     * Created by PhpStorm.
     * User: dutoitd1
     * Date: 2014/10/22
     * Time: 10:56 AM
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

    include_once "functions.inc.php";
    include_once "BaseDB.class.php";
    if (!class_exists('BaseBusinessLevel')) {
        class BaseBusinessLevel extends BaseDB
        {
            private $dbBaseClass;
            static $BusinessLevel = array(
                'Name'   =>
                    array('FieldName' => 'Name', 'FriendlyName' => 'Division Name', 'Helptext' => 'BusinessLevel Name', 'Type' => 'text', 'CheckValidFormat' => '', 'Value' => '', 'Meta' =>
                        array(FieldParameters::required_par => true)),
                'Active' =>
                    array('FieldName' => 'Active', 'FriendlyName' => 'Active', 'Helptext' => 'Active?', 'Type' => 'checkbox', 'CheckValidFormat' => '', 'Value' => 0, 'Meta' =>
                        array(FieldParameters::required_par => true)),
            );

            // Default Constructor
            function __construct()
            {
                $this->dbBaseClass = new BaseDB();
            }

            /**
             * @param $idName : The name of the "ID" field
             * @param $idValue : The value of the "ID" field
             * @param $changedRecord : A BaseDivision::Division type parameter containing the changed record
             *
             * @return array: An array of errors or empty if no errors
             * NB!!!
             * Note: empty array is converted to null by non-strict equal '==' comparison.
             * Use is_null() or '===' if there is possible of getting empty array.
             */
            function update($idName, $idValue, $changedRecord)
            {
                if (!is_array($changedRecord)) {
                    return array(printf('A BusinessLevel record was expected as a parameter but a %s was received', gettype($changedRecord)));
                }
                // Populate the Division array
                $this::$BusinessLevel = $changedRecord;
                $sqlCommand           = sprintf("
				BEGIN
                UPDATE [dbo].[BusinessLevel]
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
                //				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
                //				if (!$stmt) {
                //					$msg = dbGetErrorMsg();
                //					return array(printf('An error was received when the function sqlsrv_prepare was called.
                //						The error message was: %s', $msg));
                //				}
                $result = sqlsrv_query(Database::getConnection(), $sqlCommand); //sqlsrv_execute($stmt); // Executes a prepared statement.
                if (!$result) {
                    $msg = dbGetErrorMsg();
                    return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', $msg));
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
                // Populate the Division array
                if (!is_array($record)) {
                    return array(printf('A BusinessLevel record was expected as a parameter but a %s was received', gettype($record)));
                }
                $this::$BusinessLevel = $record;
                $sqlCommand           = sprintf("
				BEGIN
	            INSERT INTO [dbo].[BusinessLevel] (
	                [Name]
					,[Active]
	             VALUES (
	                %s,
	                %s)
                END",
                    $this::$BusinessLevel['Name']['Value'],
                    $this::$BusinessLevel['Active']['Value']
                );

                //				$stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); // Prepares a Transact-SQL query without executing it. Implicitly binds parameters.
                //				if (!$stmt) {
                //					$msg = dbGetErrorMsg();
                //					return array(printf('An error was received when the function sqlsrv_prepare was called.
                //						The error message was: %s', $msg));
                //				}
                $result = sqlsrv_query(Database::getConnection(), $sqlCommand); //sqlsrv_execute($stmt); // Executes a prepared statement.
                if (!$result) {
                    $msg = dbGetErrorMsg();
                    return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', $msg));
                }
                return array();
                // NB!!!
                // Note: empty array is converted to null by non-strict equal '==' comparison.
                // Use is_null() or '===' if there is possible of getting empty array.
            }
        }
    }

