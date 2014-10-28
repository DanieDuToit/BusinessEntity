<?php

//collate SQL_Latin1_General_CP1_CI_AS
if (!class_exists('ApplicationSettings')) {

	class ApplicationSettings
	{
		static $versionNumber = "1.0.0.0 ";
		static $applicationPrefix = "BUSSINESSENTITY";
		static $applicationTitle = "Business Entity";
	}
}

	if (!class_exists('DBSettings')) {
		class DBSettings
		{
			static $extension = "sqlsrv";
			static $database = "CALM";
			static $dbUser = "calm";
			static $dbPass = "calm";
            static $conn = null;
			// At work
		static $Server = "vmhost\sql2012";

			// At home
//			static $Server = "DANIE-HP";
		}
	}
?>
