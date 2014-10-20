<?php

include_once 'DBBase.class.php';

class CompanyBase extends DBBase
{
    private $dbBaseClass;
    
    static $company = array (
        'Name'  => '' , 
        'CompanyCode' =>  '' ,
        'Active' =>  1 ,
        'ShortName ' =>  '' ,
        'BusinessEntityId' => ''
    );


	// Default Constructor
	function __construct()
	{
		$this->dbBaseClass = new DBBase();
	}

      //Returns true if all mandatory fields in this instance have values
    
//    function checkMandatoryFields(){
//    
//        if($this->Name === "" ||  $this->Name = " "){
//            return "Name";
//        }
//        if($this->CompanyCode === "" || $this->CompanyCode= ""){
//            return "Company Code";
//        }
//        if($this->Active == "" || $this->Active = ""){
//            return "Active";
//        }
//        return true;
//        }
        
    
    public function insert($record)
    {
        //populate $company array
        if(!is_array($record))
        {
            return array(printf('A record was expected as a prameter but a %s was received' , gettype($record)));
        }

        $this::$company = $record;
        $sqlCommand = sprintf("
             INSERT INTO [dbo].[Company] (
             [Name],
             [CompanyCode],
             [Active],
             [ShortName],
             [BusinessEntityId] )
             VALUES (
             '%s',  
             '%s',  
             '%b',  
             '%s',  
             %d )",
                              $this::$company['Name'],
                              $this::$company['CompanyCode'],
                              $this::$company['Active'],
                              $this::$company['ShortName'],
                              $this::$company['BusinessEntityId']);
        
        echo $sqlCommand;
        
        $stmt = sqlsrv_prepare($this->dbBaseClass->conn, $sqlCommand); //Prepares a transact-sql query without executing it. Implicitly binds parameters
       
        if(!$stmt){

                $retval= dbGetErrorMsg();
		return printf('An error was received when the function sqlsrv_prepare was called.
						The error message was: %s', $retval);
            

        }
      $result = sqlsrv_execute($stmt); //executes the statement
      if (!$result) {
	               return array(printf('An error was received when the function sqlsrv_execute was called.
						The error message was: %s', sqlsrv_errors()));
				}
       return array();
       }
       
       


    public function update($tableName, $id , $value , $changeRecord){
      
        if(!is_array($changeRecord)){
            return array(printf('A Company Record was expected as a parameter but a %s was received', gettype($changeRecord)));
        }
        //populate the company array
        $this::$company = $changeRecord;
        
        //check if all Mandatory fields are provided
        $invalidFields = $this->checkMandatoryFields();
        if(count((array)$invalidFields) >0) {
            //some mandatory fields need are left empty
            return $invalidFields;
        }
        
        $sqlCommand = sprintf("
               UPDATE %s
               SET
               [Name] = '%s' ,
               [CompanyCode] = '%s',
               [Active] = '%b',
               [ShortName] = '%s',
               [BusinessEntityId] = %d
               WHERE %s = %s
               Go" ,
                        $tableName,
                        $this::$company['Name'],
                        $this::$company['CompanyCode'],
                        $this::$company['Active'],
                        $this::$company['ShortName'],
                        $this::$company['BusinessEntityId'],
                        $id,
                        $value);
             
        echo $sqlCommand;
   }
   
   
   
   private function checkMandatoryFields(){
       $fields = array();
       $i = 0;
       if (CompanyBase::$company['Name'] == null){
           $fields[$i++]='Company Name should be supplied';
        }
        
       if(CompanyBase::$company['CompanyCode'] == null){
           $fields[$i++]='Company code should be supplied';
       }
       
       if(CompanyBase::$company['Active']== null){
           $fields[$i++]='A value for Active must be supplied';
       }
       
   }
  
    
  
    }