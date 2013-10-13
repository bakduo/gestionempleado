<?php

include_once ('config/settings.php');


class QuerySQL {

	//singleton instance 
    private static $instance;
	private $sql ="";
    
	function __construct($sql){
	    $this->sql=$sql;
	}
	
	public static function getInstance() { 
       if(!self::$instance) { 
          self::$instance = new self(); 
       }
      return self::$instance;
    }
    
    public function setSQL($sql){
       $this->sql = $sql;
    }
    
    public function getSQL($sql){
       return $this->sql;
    }
    
    public function excuteSQL(){
	   require_once ('lib/adodb/link.php');  
       try { 
			$record= $db->Execute($this->sql);
			return $record;
		} catch (exception $e) { 
		    var_dump($e); 
		    adodb_backtrace($e->gettrace());
	    } 
    }
		
}


?>
