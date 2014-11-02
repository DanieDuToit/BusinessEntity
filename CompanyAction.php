<style>
    .error {
        color: red;
    }
</style>

<?php

    //include_once 'Includes/functions.inc.php';
    //include_once 'Classes/BaseClasses/BaseDB.class.php';
    //include_once 'Classes/BaseClasses/BaseCompany.class.php';
    include "Header.inc.php";

    //$post = buildPostForDebug($_POST);
    //echo $post;
    //die;
    $companyBase = new BaseCompany();
    if (Database::getConnection() === false) {
        die("ERROR: could not connect . " . printf('%s', dbGetErrorMsg()));

    }

    $companyTemplate = BaseCompany::$company;
    if (!isset($_POST['id'])) {
        echo "<div class='error'><h3> No ID was received for Action.php</h3>";
        die;
    }

    if (isset($_POST['Update'])) {
        if ($_POST['Active'] == 'Active') {
            $active = 1;
        } else {
            $active = 0;
        }
        //Update Busines entity
        $businessEntityBase = new BaseBusinessEntity();
        $sqlCommand         = "BEGIN
				       UPDATE [dbo].[BusinessEntity]
                       SET
                       [Name] = '{$_POST['Name']}',
                       [BusinessEntityCode] = '{$_POST['CompanyCode']}',
				       [BusinessEntityDescription] = '',
                       [BusinessEntityParentId] = null,
				       [BusinessLevelId] = 1,
                       [Active] = $active,
				       [BusinessEntityShortName] = '{$_POST['ShortName']}'
				       WHERE  Id = {$_POST['BusinessEntityId']}
                       END";

        echo $sqlCommand;

        $result = sqlsrv_query(Database::getConnection(), $sqlCommand);
        if (!$result) {
            die(printf('An error was received when the function sqlsrv_query was called.
						The error message was: %s', dbGetErrorMsg()));
        }

        //action = Update;

        $record         = PopulateRecord($_POST, $companyTemplate);
        $validateErrors = ValidateRecord($record);
        $updateErrors   = $companyBase->update("id", $_POST['id'], $record);
        if ($validateErrors) {
            foreach ($validateErrors as $error) {
                echo "<div class='error'><h3>$error</h3></div><br>";
            }
        }
        if ($updateErrors) {
            echo "<div class='error'><h3>$updateErrors</h3></div><br>";
        }
        if ($validateErrors || $updateErrors) {
            die;
        }
    } elseif (isset($_POST['Delete'])) {
        //action = 'Delete'
        echo "<div class='error'> <h3>Not implemented yet</h3></div>";

    } elseif (isset($_POST['Create'])) {
        //action = create
        // Create a  BusinessEntity record for the company
        if ($_POST['Active'] == 'Active') {
            $active = 1;
        } else {
            $active = 0;
        }
        $businessEntityBase = new BaseBusinessEntity();
        $sqlCommand         = "BEGIN INSERT INTO [dbo].[BusinessEntity]
                       ([Name]
                       ,[BusinessEntityCode]
                       ,[BusinessEntityDescription]
                       ,[BusinessEntityParentId]
                       ,[BusinessLevelId]
                       ,[Active]
                       ,[BusinessEntityShortName])
                 VALUES
                       ( '{$_POST['Name']}'
                       ,'{$_POST['CompanyCode']}'
                       ,''
                       ,null
                       ,1
                       ,$active ,
                       '{$_POST['ShortName']}') END";
        $companyBase->dbTransactionBegin();
        $result = sqlsrv_query(Database::getConnection(), $sqlCommand);
        if ($result) {
            $sqlIdentity    = "select @@identity as EntityId";
            $resultIdentity = sqlsrv_query(Database::getConnection(), $sqlIdentity);
            $rowIdentity    = sqlsrv_fetch_array($resultIdentity);
            $entityId       = $rowIdentity["EntityId"];
        } else {
            $companyBase->dbTransactionRollback();
            echo printf('An error was received when the function sqlsrv_query was called.
						The error message was: %s', dbGetErrorMsg());
            die();
        }

        // Create the Company
        $record                              = PopulateRecord($_POST, $companyTemplate);
        $record['BusinessEntityId']['Value'] = $entityId;
        $validateErrors                      = ValidateRecord($record);
        $insertErrors                        = $companyBase->insert($record);
        if ($validateErrors) {
            foreach ($validateErrors as $error) {

                echo "<div class='error'><h3>$error</h3></div><br>";
            }
        }
        if ($insertErrors) {
            foreach ($insertErrors as $error) {
                echo "<div class='error'><h3>$error</h3></div><br>";
            }
        }
        if ($validateErrors || $insertErrors) {
            $companyBase->dbTransactionRollback();
            die;
        }
        $companyBase->dbTransactionCommit();
    }
    header("Location: CompanyDisplayGrid.php");


