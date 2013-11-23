<?php

/*
#############################################################################
#                                                                           #
#@copyright   Copyright (c) 2013, linuxknow <linuxknow@gmail.com            #
#   Clase QuerySQL                                                          #
#   This program is free software: you can redistribute it and/or modify    #
#   it under the terms of the GNU General Public License as published by    #
#   the Free Software Foundation, either version 3 of the License, or       #
#   (at your option) any later version.                                     #
#                                                                           #
#   This program is distributed in the hope that it will be useful,         #
#   but WITHOUT ANY WARRANTY; without even the implied warranty of          #
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
#   GNU General Public License for more details.                            #
#                                                                           #
#   You should have received a copy of the GNU General Public License       #
#   along with this program.  If not, see <http://www.gnu.org/licenses/>    #
#                                                                           #
#############################################################################
*/
include_once ('config/settings.php');

class PGCustom
{

  private $link=NULL;
  private $q=NULL;
  private $dsn = "";

  public function setDSN($dsn){
    $this->dsn=$dsn;
  }

  private function getDSN(){
    return $this->dsn;
  }

  public function connect(){
  	$this->link = pg_Connect($this->getDSN());
  }

  public function returnByJson($sql){
  	$result = pg_query($this->link,$sql);
  	return json_encode(pg_fetch_array($result));
  }
/*
  $answercreatequery = pg_query_params('INSERT INTO answer
  (questionid, adescription, afilelocation, iscorrect) VALUES ($1, $2, $3, $4)',
  array($thisquestionid, $adescription1, $afilelocation, $iscorrect1));
*/
  public function insertByParam($sql,$array){
	 $this->q=pg_query_params($this->link,$sql,$array);
	 if (!$this->q) {
        die("Error in SQL query: " . pg_last_error());
        return pg_last_error();
    }
    return $this->q;
  }

  public function insert($sql){
  	$sql=pg_escape_string($sql);
  	$this->q=pg_query($this->link,$sql);
  	if (!$this->q) {
        die("Error in SQL query: " . pg_last_error());
    }
  }
  public function returnByResult($sql){
  	$result=pg_query($this->link,$sql);
  	//return pg_fetch_result($result);
  	return pg_fetch_row($result);
  }
  public function retornSimpleValue($sql){
    $result = pg_query($this->link,$sql);
  	return json_encode(pg_fetch_row($result));
  }

  public function returnByObject($sql){
  	$this->q=pg_query($this->link,$sql);
  	return pg_fetch_object($this->q);
  }
  public function retornByAll($sql){
  	$result = pg_query($this->link,$sql);
  	return pg_fetch_all($result);
  }

  public function free(){
  	pg_free_result($this->q);
  }
  public function close(){
  	pg_close($this->link);
  }
	
}

class QuerySQL {

	//singleton instance 
    private static $instance=NULL;
	private $sql ="";
	private $db = NULL;
	private $contador=0;
	private $pg=NULL;
    
	function __construct(){
	    $this->sql="";
	    $this->pg=new PGCustom();
	}

  public function setDSN($dsn){
    $this->pg->setDSN($dsn);
  }
	
	public static function getInstance() {

    if (!self::$instance instanceof self)
      {
         self::$instance = new self;
      }
      return self::$instance;
    }
    
    public function insertQueryParams($sql,$array){
    	$this->pg->connect();
    	$valor=$this->pg->insertByParam($sql,$array);
    	$this->pg->free();
  		$this->pg->close();
  		return $valor;
    }

    public function setSQL($sql){
       $this->sql = $sql;
    }
    
    public function getSQL($sql){
       return $this->sql;
    }
    
    public function escape_string($var){
    	return pg_escape_string($var);
    }

    public function commit(){

    }
    public function insert($sql){
    	$this->pg->connect();
    	$this->pg->insert($sql);
    	$this->pg->free();
  		$this->pg->close();
    }

    public function executeByObject(){
    	$this->pg->connect();
    	$result=$this->pg->returnByObject($this->sql);
    	$this->pg->free();
    	$this->pg->close();
    	return $result;
    }

    public function excuteSQL(){
    	$this->pg->connect();
    	$result=$this->pg->returnByResult($this->sql);
    	$this->pg->close();
    	return $result;
    }

    public function getAssoc(){
    	$this->pg->connect();
    	$result=$this->pg->retornAll($this->sql);
    	$this->pg->close();
    	return $result;
    }

    public function getAll(){
    	$this->pg->connect();
    	$result=$this->pg->retornByAll($this->sql);
    	$this->pg->close();
    	return $result;
    }

    public function getJson(){
    	$this->pg->connect();
    	$result=$this->pg->retornByAll($this->sql);
    	$this->pg->close();
    	//return $result;
    	return json_encode($result);
    }
		
}


?>
