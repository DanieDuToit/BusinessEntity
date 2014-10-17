<?php

include_once @"IncludesAndClasses\DBBase.class.php";
include_once @"IncludesAndClasses\CompanyBase.class.php";

$companyBase = new CompanyBase();

$companyRecord = $companyBase::$company;
$companyRecord['Name'] = 'ProteaTest';
$companyRecord['CompanyCode'] = 'Testone';
$companyRecord['ShortName'] = 'test';
$companyRecord['BusinessEntityId'] = 5;
$companyBase->insert($companyRecord);
        
$sql = "SELECT * FROM Company";

$stmt = sqlsrv_query( $dbBaseClass->conn, $sql);
if( $stmt === false ) {
	die( print_r( sqlsrv_errors(), true));
}

$numFields = sqlsrv_num_Fields( $stmt);

while(sqlsrv_fetch($stmt)){
    
    for($i = 0; $i< $numFields; $i++){
        
        echo sqlsrv_get_field($stmt, $i)."";
    }
    
    echo "<br />";
}


//Using update statement from DBBase class

//echo '<h2>Update by Id</h2>';
//$stmt = $dbBaseClass->updateById('Company', 'ID', '5');
//if( $stmt === false ) {
//	die( $dbBaseClass->dbGetErrorMsg());
//}
//else {
//	echo $row .", "."<br />";
//}
//sqlsrv_free_stmt( $stmt);


//while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//	echo $row['Name'].", "."<br />";
//}
//sqlsrv_free_stmt( $stmt);


?>
