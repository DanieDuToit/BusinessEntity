
<!doctype html>
<html>
<head>
<style>
table,td,th {border:1px solid black}
thead{ font-size: medium}

table {
       border-collapse: collapse
       background-color #00ff00
	   }
td,th {padding: 5px}
</style>

<meta charset="utf-8">
</head>

<body>

<?php


include_once @'IncludesAndClasses\DBBase.class.php';
include_once @'IncludesAndClasses\CompanyBase.class.php';

$dbBaseClass = new DBBase();
if ($dbBaseClass->conn === false)
{
    die("ERROR: could not connect." . $dbBaseClass->dbGetErrorMsg());
}
$records = $dbBaseClass->getFieldsForAll('Company', array('id','Name','CompanyCode','Active','ShortName','BusinessEntityId'));

if($records === false)
{
    die($dbBaseClass->dbGetErrorMsg());
}

    echo "<table>";
   echo "<tr>";
   echo "<thead>";
   echo "<td>CompanyName</td><td>CompanyCode</td><td>Active</td><td>ShortName</td>";
   echo "<td colspan =\"3\">Action</td>";
   echo "</thead>";
   echo "</tr>";
while ($record =  sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC)){

         echo "<tr>";
         echo "<td>{$record['Name']}</td>";
         echo "<td>{$record['CompanyCode']}</td>";
         echo "<td>{$record['Active']}</td>";
         echo "<td>{$record['ShortName']}</td>";
         echo "<td><a href=\"Company.php?action=r&id={$record['id']} \">Display </a></td> ";
         echo "<td><a href=\"Company.php?action=u&id={$record['id']} \">Edit </a></td> ";
         echo "<td><a href =\"Company.php?action=d&id={$record['id']} \"> Delete </a> </td>";
         echo "</tr>";
}
echo "</table>";

$dbBaseClass->close();
        
        
?>

</body>
</html>

