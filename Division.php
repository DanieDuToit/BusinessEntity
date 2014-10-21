<?php
/**
 * Created by PhpStorm.
 * User: Danie
 * Date: 2014/10/21
 * Time: 09:30 PM
 */

$action = '';
include_once 'IncludesAndClasses/functions.inc.php';
include_once 'IncludesAndClasses/DBBase.class.php';
include_once 'IncludesAndClasses/DivisionBase.class.php';
if (!isset($_POST['Create'])) {
	if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
		header("Location: DivisionDisplayGrid.php");
	}
	$id = (int)$_GET['id'];
	$action = $_GET['action'];
	sanitizeString($id);
} else {
	$action = 'c';
	$id = -1;
}
sanitizeString($action);
