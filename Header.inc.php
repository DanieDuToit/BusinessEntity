<!-- 
	Meta handles browser instructions as instructed to content(utf-8) and version (Edge being latest) to ensure correct display
    link handles multiple types
    	Example rel="shortcu icon" includes favicon image in the tab of the browser
        		rel="stylesheet" includes defined css classes and customised styling
    It might be better to include this after php in the event that sessions are created.
-->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>CALM business Entity</title>


    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link href="skin/stylesheetSapWebX.css" rel="stylesheet" type="text/css">
    <link href="skin/demo/menu.css" rel="stylesheet" type="text/css">
    <link href="skin/stylesheet.css" rel="stylesheet" type="text/css">

    <?php
        if (isset($_SESSION['error'])) {
            ?>
            <div class="ErrorDiv">
                <?php echo $_SESSION['error']; ?>
            </div>
            <br>
            <?php
            unset($_SESSION['error']);
        }
    ?>

<?php
    /**
     * Created by PhpStorm.
     * User: dutoitd1
     * Date: 2014/10/23
     * Time: 07:21 AM
     */

    include_once "BaseClasses/settings.inc.php";
    include_once "BaseClasses/BaseDB.class.php";
    include_once "BaseClasses/BaseBranch.class.php";
    include_once "BaseClasses/BaseBusinessLevel.class.php";
    include_once "BaseClasses/BaseCompany.class.php";
    include_once "BaseClasses/BaseBusinessEntity.class.php";
    include_once "BaseClasses/functions.inc.php";
    include_once "BaseClasses/Database.class.php";
?>