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
    $company = $_GET['company'];

    try {
        $dbBaseClass = new BaseDB();
    }
    catch (Exception $exc) {
    if ($dbBaseClass->conn === false) {
        die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
    }

}

    $divisionBase = new BaseBusinessEntity();
    $companyBase = new BaseCompany();
    $prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Id', 'Name'), "WHERE BusinessEntityParentId = $company");
    while ($company = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC)) {
        echo "<option value=" . $company['Id'] . ">${company['Name']}</option>";
    }
        $err = printf('%s', dbGetErrorMsg());

