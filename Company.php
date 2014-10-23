<?php

 if(isset($_POST['Return']))
 {
     header("Location: CompanyDisplayGrid.php");
 }

$action = '';
	//include_once 'Includes/functions.inc.php';
	//include_once 'Classes/BaseClasses/BaseDB.class.php';
	//include_once 'Classes/BaseClasses/BaseCompany.class.php';
	include "Header.inc.php";
if (!isset($_POST['Create'])) {
    if (isset($_GET['id']) === false || isset($_GET['action']) === false) {

       header("Location: CompanyDisplayGrid.php");
    }
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    sanitizeString($id);
} else {
    $action = 'c';
    $id = -1;
}
sanitizeString($action);

// Set up DB connection
	$dbBaseClass = new BaseDB();
if ($dbBaseClass->conn === false) {
    die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
}

// An existing record is expected when the action is not "Create"
if ($action != 'c') {
    // Read the record
    $records = $dbBaseClass->getAllByFieldName('Company', 'id', $id);

    if ($records === false) {
        die(dbGetErrorMsg());
    }

    // Get the specific record
    $record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
}


	$companyBase = BaseCompany::$company;

  function echoField($fieldIdName)
  {
      global $action;
      global $record;
      global $companyBase;

		$fieldParams = initializeFieldParametersArray($fieldIdName, $companyBase);
		if ($action == 'r' || $action == 'd') {
          $fieldParams[FieldParameters::disabled_par] = 'Disabled';
      }
      $inputField = (string)drawInputField($fieldIdName, $companyBase[$fieldIdName]['Type'], $record[$fieldIdName], $fieldParams);

		echo "<td class='' = \"fieldName\" ><b>$fieldIdName</b></td>";
      echo("<td>$inputField</td>");
    
  }

?>



<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.0.1//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>company</title>
 </head>
 <body>

 <?php
 if ($action == 'c') {
     $val = 'Insert';
 } elseif ($action == 'u') {
     $val = 'Update';
 } elseif ($action == 'd') {
     $val = 'Remove';
 } else {
     $val = 'Display';
 }
 echo sprintf('<div class="heading"><h1>%s a Branch</h1></div>', $val);
 ?>


<form action="CompanyAction.php" method="post">
     <input type="hidden" value="<? echo $id ?>" id="id" name="id">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
         <tr>
             <?php echoField("Name") ?>
         </tr>
         <tr>
             <?php echoField("CompanyCode") ?>
         </tr>
         <tr>
             <?php echoField("Active") ?>
         </tr>
         <tr>
             <?php echoField("ShortName") ?>
         </tr>
         <tr>
             <?php echoField("BusinessEntityId") ?>
         </tr>
  
     </table>
     <div>

         <?php
			if ($action == 'c') {
				echo (string)drawSubmitButton("Create", "Create");
            }
			if ($action == 'u') {
                echo drawSubmitButton("Update", "Update");
            }
			if ($action == 'd') {
                echo drawSubmitButton("Delete", "Delete");
            }
          ?>
         <form>
             <?php
               echo (drawSubmitButton("Return", "Return"));
            ?>

         </form>
     </div>

 </form>


 </body>
</html>
















