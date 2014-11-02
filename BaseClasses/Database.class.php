<?php

    /**
     * Created by PhpStorm.
     * User: Danie
     * Date: 2014/10/26
     * Time: 01:53 PM
     */
    class Database
    {

        private static $db;

        public static function getConnection()
        {
            $connectionInfo = array("UID"                  => DBSettings::$dbUser,
                                    "PWD"                  => DBSettings::$dbPass,
                                    "Database"             => DBSettings::$database,
                                    "ReturnDatesAsStrings" => true);
            if (!self::$db) {
                self::$db = sqlsrv_connect(DBSettings::$Server, $connectionInfo); // Creates and opens a connection.
            }
            return self::$db;
        }

        function __destruct()
        {
            self::$db->close();
        }
    }
