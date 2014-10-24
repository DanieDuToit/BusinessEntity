<?php
	/**
	 * Created by PhpStorm.
	 * User: dutoitd1
	 * Date: 2014/10/24
	 * Time: 03:48 PM
	 */

	function selectbox($arr)
	{
		echo "<option>Select</option>";
		$i = 0;
		foreach ($arr as $v) {
			$i += 1;
			echo "<option value=" . $i . ">$v</option>";
		}
	}

	if (!isset($_GET['company'])) {
		echo '<script language="JavaScript">';
		echo 'alert("No Company was selected.")';
		echo '</script>';
	}
	$company = $_GET['company'];

	$dbBaseClass = new BaseDB();
	$divisionBase = new BaseBusinessEntity();
	$companyBase = new BaseCompany();
	$prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('BusinessEntityParentId'), "WHERE id = $id");
	$rec = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC);
	$prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Name'), "WHERE id = {$rec['BusinessEntityParentId']}");

	switch ($_GET['company']) {
		case 1:
			$companies = array("Apples", "Bananans", "Pineapples");
			break;
		case "3":
			$companies = array("Sour Worms", "Wilsons Toffee", "Bar One");
			break;
		case 2:
			$companies = array("Potato", "Carrot", "Cabbage");
			break;
		default:
			break;
	}
	selectbox($companies);

