<?php

/*
#############################################################################
#                                                                           #
#   Clase RRHH                                                              #
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

require_once('config/settings.php');

class Rrhh
{

	private $empleados;
	private $total;

        private static $instance;

        function __construct(){
            $this->emplados=NULL;
            $this->total=0;
        }

       public static function getInstance() {
       	if(!self::$instance) {
          self::$instance = new self();
       	}
      	return self::$instance;
       }

       public function getEmpleadoJson($id){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select *
        from empleados
        where empleado = ".$id;
        $test->setSQL($sql);
        return $test->getJson();
       }

       public function getPoEmpleadoJson($id){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select o.puesto,o.objetivo
from empleados e , objetivospuestos o
where e.puesto = o.puesto and e.empleado=".$id;
        $test->setSQL($sql);
        return $test->getJson();
       }

       public function getPoEmpleadoDescJson($id){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select (select descripcion from puestos where puesto = o.puesto) as puesto,(select descripcion from objetivos where objetivo = o.objetivo) as objetivo
from empleados e , objetivospuestos o
where e.puesto = o.puesto and e.empleado=".$id;
        $test->setSQL($sql);
        return $test->getJson();
       }

        public function getPoEmpleadoIdJson($id){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select o.puesto,(select descripcion from objetivos where objetivo = o.objetivo) as objetivo
        from empleados e , objetivospuestos o
        where e.puesto = o.puesto and e.empleado=".$id;
        $test->setSQL($sql);
        return $test->getJson();
       }

       public function getOEmpleadoDescJson($id){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select (select descripcion from objetivos where objetivo = o.objetivo) as objetivo
from empleados e , objetivospuestos o
where e.puesto = o.puesto and e.empleado=".$id;
        $test->setSQL($sql);
        return $test->getJson();
       }       

       public function getEmpleadosJson(){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select *
        from empleados";
        $test->setSQL($sql);
        return $test->getJson();
       }

       public function total_empleados(){
       	require_once('lib/model/SQL.php');
       	$test= QuerySQL::getInstance();
       	$test->setSQL("select count(*) as cantidad_total from empleados");
		    $record=$test->excuteSQL();
		    $this->total = $record->fields['cantidad_total'];
		    return $this->total;
       }

       public function getObjetivosJson(){
        require_once('lib/model/SQL.php');
        $test= QuerySQL::getInstance();
        $sql="select *
        from objetivos";
        $test->setSQL($sql);
        return $test->getJson();
       }

       public function search($id){
       	require_once('lib/model/SQL.php');
       	$test= QuerySQL::getInstance();
       	$sql='select * from empleados where id='.$id;
       	$test->setSQL($sql);
        //return $test->executeByObject();
        return $test->getJson();
       }

      public function setTargets($json){
        require_once('lib/model/SQL.php');
        $fp = fopen(LOGLOCAL,'a+');
        fwrite($fp, 'setTargets.../n');
        fwrite($fp,$json);
        
        $j = json_decode((string)$json);
        
        
        fwrite($fp, '#############/n');
        fwrite($fp, '#############/n');
        fwrite($fp,$j);
        fwrite($fp,"-------------------------fin---setTargets---------/n");
        fclose($fp);
<<<<<<< HEAD
        return print_r(json_decode($json, true));

        //$myArray = print_r(json_decode($json, true));
        //$i = $myArray.lenght();
        //return $i;
        //return print_r($_POST);
=======

        echo "<<<<<<<<<<<<<<<<<<<<<<";
        echo "<<<<<<<<<<<<<<<<<<<<<<";
        echo "<<<<<<<<<<<<<<<<<<<<<<";
        print_r($j);
        echo "<br></br>";
        echo ">>>>>>>>>>>>>>>>>>>>>>";
        echo ">>>>>>>>>>>>>>>>>>>>>>";
        echo ">>>>>>>>>>>>>>>>>>>>>>";
        die("putooo");
        

        echo "<pre>";
        print_r($j);

        for ($i=0; $i <sizeof($j) ; $i++) { 
          $sql = "select objetivo from objetivos where descripcion = '".$j[$i]->objetivo."'";
          print_r($sql);
          echo "<br></br>";
          $test= QuerySQL::getInstance();
          $test->setSQL($sql);
          $record=$test->excuteSQL();
          print_r($record);
        }
        
        die("");
        
>>>>>>> b65220ebcf4c467ba41cb7f471d9605d0cdd9a75
      }

      public function setJustificaEmpleado($json){
        require_once('lib/model/SQL.php');
        http_response_code(200);
        $fp = fopen(LOGLOCAL,'a+');
        fwrite($fp, 'setJustificaEmpleado.../n');
        fwrite($fp,$json);
        fwrite($fp,"-------------------------fin---setJustificaEmpleado---------/n");
        fclose($fp);
        return print_r(json_decode($json, true));
      }

      public function setFeedbackEmpleado($json){
        require_once('lib/model/SQL.php');
        http_response_code(200);
        $fp = fopen(LOGLOCAL, 'a+');
        fwrite($fp, 'setFeedbackEmpleado.../n');
        fwrite($fp,$json);
        fwrite($fp,"-------------------------fin---setFeedbackEmpleado---------/n");
        fclose($fp);
        return print_r(json_decode($json, true));
      }

      public function setPrimerFeedbackJefe($json){
       require_once('lib/model/SQL.php');
        http_response_code(200);
        $fp = fopen(LOGLOCAL, 'a+');
        fwrite($fp, 'setPrimerFeedbackJefe.../n');
        fwrite($fp,$json);
        fwrite($fp,"-------------------------fin---setPrimerFeedbackJefe--------/n");
        fclose($fp);
        return print_r(json_decode($json, true)); 
      }


}

?>
