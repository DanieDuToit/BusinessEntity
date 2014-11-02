<?php
    /**
     * Created by PhpStorm.
     * User: dutoitd1
     * Date: 2014/10/24
     * Time: 03:48 PM
     */

    include "Header.inc.php";
    if (!isset($_GET['company'])) {
        echo '<script language="JavaScript">';
        echo 'alert("No Company was selected.")';
        echo '</script>';
    }
    $division    = $_GET['company'];
    $divisionId  = $_GET['divisionId'];
    $displayType = $_GET['displayType'];

    try {
        $dbBaseClass = new BaseDB();
    } catch (Exception $exc) {
        if (Database::getConnection() === false) {
            die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
        }

    }

    $divisionBase = new BaseBusinessEntity();
    //    $companyBase = new BaseCompany();
    $prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Id', 'Name'), "WHERE BusinessEntityParentId = $division");
    if ($displayType == 'd' || $displayType == 'r') {
        while ($division = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC)) {
            if ($division['Id'] == $divisionId) {
                echo "<option selected = \"selected\" value=" . $division['Id'] . ">${division['Name']}</option>";
                return;
            }
        }
    }
    while ($division = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC)) {
        if ($division['Id'] == $divisionId) {
            echo "<option selected = \"selected\" value=" . $division['Id'] . ">${division['Name']}</option>";
        } else {
            echo "<option value=" . $division['Id'] . ">${division['Name']}</option>";
        }
    }
    $err = printf('%s', dbGetErrorMsg());

