<?php
    /**
     * Created by PhpStorm.
     * User: dutoitd1
     * Date: 2014/10/08
     * Time: 1:29 PM
     */

    $path = explode(DIRECTORY_SEPARATOR, __FILE__);
    include_once "IncludesAndClasses/DBBase.class.php";
    include_once @"IncludesAndClasses/BranchBase.class.php";
    include_once "IncludesAndClasses/functions.inc.php";

    $dbBaseClass = new DBBase();

    $BranchBase   = new BranchBase();
    $BranchRecord = $BranchBase::$Branch;

    $name = $BranchRecord['BranchCode']['FieldName'];
    $help = $BranchRecord['BranchCode']['Helptext'];
    initializeFieldParametersArray($fieldParams);

    $t  = array_key_exists(FieldParameters::class_par, $BranchRecord['BranchCode'][0]);
    $v1 = $BranchRecord['BranchCode'][0][FieldParameters::class_par];
    $t  = array_key_exists(FieldParameters::groupIdName_par, $BranchRecord['BranchCode'][0]);
    $t  = array_key_exists(FieldParameters::autoRefresh_par, $BranchRecord['BranchCode'][0]);

    $BranchRecord['BranchCode']['Value']        = "Branch'Code";
    $BranchRecord['Name']['Value']              = "Names's";
    $BranchRecord['Active']['Value']            = '0';
    $BranchRecord['ContactPersonName']['Value'] = 'ContactPersonName';
    $BranchRecord['PhoneNumber']['Value']       = '(012)2311234';
    $BranchRecord['FaxNumber']['Value']         = '(012)2311234';
    $BranchRecord['Longitude']['Value']         = '123.4567';
    $BranchRecord['Latitude']['Value']          = '123.4567';
    $BranchBase->update('Branch', 'id', 1, $BranchRecord);

    if ($dbBaseClass->conn) {
        echo "Connection established.<br />";
    } else {
        echo "Connection could not be established.<br />";
        die(dbGetErrorMsg());
    }
    // Using dbQuery
    echo '<h2>Using dbQuery</h2>';
    $sql  = "SELECT TOP(10) Name FROM company";
    $stmt = $dbBaseClass->dbQuery($sql);
    if ($stmt === false) {
        die(dbGetErrorMsg());
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo $row['Name'] . ", " . "<br />";
    }
    sqlsrv_free_stmt($stmt);

    // Using getAll
    echo '<h2>Using getAll</h2>';
    $stmt = $dbBaseClass->getAll('Company');
    if ($stmt === false) {
        die(dbGetErrorMsg());
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo $row['Name'] . ", " . "<br />";
    }
    sqlsrv_free_stmt($stmt);

    // Using getAllByFieldname
    echo '<h2>Using getAllByFieldname</h2>';
    $stmt = $dbBaseClass->getAllByFieldName('Company', 'Name', 'Protea Security');
    if ($stmt === false) {
        die(dbGetErrorMsg());
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo $row['Name'] . ", " . "<br />";
    }
    sqlsrv_free_stmt($stmt);

    // Using getFieldsByFieldname
    echo '<h2>Using getFieldsByFieldname</h2>';
    $fields = array('Name', 'CompanyCode');
    $stmt   = $dbBaseClass->getFieldsByFieldName('Company', 'Name', 'Protea Security', $fields);
    if ($stmt === false) {
        die(dbGetErrorMsg());
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "{$row['Name']} , {$row['CompanyCode']} <br />";
    }
    sqlsrv_free_stmt($stmt);

    // Using getFieldsForAll
    echo '<h2>Using getFieldsForAll</h2>';
    $fields = array('Name', 'CompanyCode');
    $stmt   = $dbBaseClass->getFieldsForAll('Company', $fields);
    if ($stmt === false) {
        die(dbGetErrorMsg());
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "{$row['Name']} , {$row['CompanyCode']} <br />";
    }
    sqlsrv_free_stmt($stmt);
?>
