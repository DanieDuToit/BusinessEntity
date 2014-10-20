<?php

include_once @"functions.php";
include_once @"IncludesAndClasses\DBBase.class.php";

if (isset($_GET['id'])=== false || isset($_GET['action'])=== false){
    
    //header("Location: CompanyDisplayGrid.php");
}
    $id = (int) $_GET['id'];
    $action = $_GET['action'];
    
  function echoValue($fieldIdName, $fieldType , $required)
  {
      global $action;
      initializeFieldParametersArray($fieldParams);
      if($action == 'r' || $action == 'd'){
          $fieldParams[FieldParameters::disabled_par] = 'Disabled';
      }
      $inputField ="";
      switch($fieldType){
          case "text":
              $inputField .= drawInputField($fieldIdName, $fieldType, " ", $fieldParams);
              break;
          case "checkbox":
              $inputField .= drawInputField($fieldIdName, $fieldType, "checked", $fieldParams);
              break;
 
      }
      echo "<td calss = \"fieldName\" ><b>$fieldIdName</b></td>\r\n";
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
 <h1> Create/Read/Update/Delete a Company </h1>
 <form>
     <table width="200" border="0" cellspacing="2px" cellpadding ="2px">
         <tr>
             <?php echoValue("Name" , "text" , true) ?>
         </tr>
         <tr>
             <?php echoValue("CompanyCode", "text", true) ?>
         </tr>
         <tr>
             <?php echoValue("Active", "checkbox", false ) ?>
         </tr>
         <tr>
             <?php echoValue("ShortName", "text", false) ?>
         </tr>
         <tr>
             <?php echoValue("BusinessEntityId", "text", false) ?>
         </tr>
  
     </table>
 </form>