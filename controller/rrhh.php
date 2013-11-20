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

        $j = json_decode($json);

        $total = count($j);
        
        //$fp = fopen(LOGLOCAL, 'w');
        //fwrite($fp, 'SaveTargets...\n');
        //fwrite($fp,$json."\n");

        for ($i=0; $i < $total ; $i++) { 
          $record=$j[$i];
          
          /*
          echo $record->objetivo;
          fwrite($fp,(string)$record->objetivo."\n");
          fwrite($fp, "\n");
          echo $record->empleado;
          fwrite($fp,(string)$record->empleado."\n");
          fwrite($fp,"\n");
          echo $record->target;
          fwrite($fp,(string)$record->target."\n");
          fwrite($fp,"\n");
          */
          
          $test= QuerySQL::getInstance();

          $sql="select objetivo 
            from objetivos
            where descripcion = '".(string)$record->objetivo."'";
          //fwrite($fp,"Debug busqueda sql : ".$sql."\n");
          $test->setSQL($sql);

          $objetivo_buscado=$test->excuteSQL();

          //fwrite($fp,"Debug busqueda: ".print_r($objetivo_buscado)."\n");

          if($objetivo_buscado==false){
            //fwrite($fp,"No Encontrado objetido: ".$record->objetivo);
            //$test= QuerySQL::getInstance();
            $test->setSQL("select count(*) as cantidad from objetivos");
            $cantidad=$test->excuteSQL();
            $cant = $cantidad[0] + 1;
            //$test= QuerySQL::getInstance();
            $test->setSQL("insert into objetivos (objetivo, descripcion) VALUES(".$cant.",'".$record->objetivo."')");
            $obj=$test->excuteSQL();
            $objetivo_id = $cant;
          }else{
            //fwrite($fp,"Encontrado objetido: ".$record->objetivo);
            $objetivo_id = $objetivo_buscado[0];
          }
          //$test= QuerySQL::getInstance();
          $test->setSQL("insert into objetivos_targets_empleado (objetivo_id, empleado_id, target) VALUES(".$objetivo_id.",".$record->empleado.",'".$record->target."')");
          $test->excuteSQL();
        }
        //fwrite($fp,"-------------------------fin---target---------\n");
        //fclose($fp);
      }

      public function setJustificaEmpleado($json){
        require_once('lib/model/SQL.php');
        //$json = '{"periodo":"2013-11-19","empleado":"12","respuestafeedback":"esta seria la justificacion del empleado"}';
        $j = json_decode($json);

        /**
        *Debug para justificacion
        **/
        $fp = fopen(LOGLOCAL, 'w');
        fwrite($fp, 'justificacion\n');
        fwrite($fp,$json."\n");
        fclose($fp);
        $record=$j[0];
        $test= QuerySQL::getInstance();
        $test->setSQL("insert into justificacion_empleados ( empleado_id,periodo,respuesta_feedback ) values( ".$record->empleado.", '".$record->periodo."', '".$record->respuestafeedback."' ) ");
        $result=$test->excuteSQL();
        
      }

      public function setMensajeInicialDelJefe($json){
        require_once('lib/model/SQL.php');
        $j = json_decode($json);
         /**
        *Debug para justificacion
        **/
        $fp = fopen(LOGLOCAL, 'w');
        fwrite($fp, 'justificacion inicial jefe\n');
        fwrite($fp,$json."\n");
        
        $record=$j[0];
        if ($record->estado=='true'){
           $estado_msj='T';
        }else{
          $estado_msj='F';
        }
        $test= QuerySQL::getInstance();
        $sql="insert into informe_empleados 
        (empleado_id,periodo,estado_inicial,estado_final,descripcion_inicial,descripcion_final) 
        values( ".$record->empleado.", '".$record->periodo."', '".$estado_msj."','','".$record->descripcion."','')";
        fwrite($fp,$sql."\n");
        $test->setSQL($sql);        
        $result=$test->excuteSQL();
        fclose($fp);
      }

      public function setMensajeFinalDelJefe($json){
        require_once('lib/model/SQL.php');
        //$json = '{"periodo":"2013-11-19","empleado":"10","descripcion":"esta es la descripcion del estado final", "estado":"true"}';
        $j = json_decode($json);

        $fp = fopen(LOGLOCAL, 'w');
        fwrite($fp, 'justificacion final jefe\n');
        fwrite($fp,$json."\n");
        
        $record=$j[0];
        if ($record->estado=='true'){
           $estado_msj='T';
        }else{
          $estado_msj='F';
        }

        $test= QuerySQL::getInstance();
        $sql = "update informe_empleados set descripcion_final='".$record->descripcion."', estado_final='".$estado_msj."'  where empleado_id=".$record->empleado." and periodo='".$record->periodo."'";
        $test->setSQL($sql);
        fwrite($fp,$sql."\n");
        fclose($fp);
        $result=$test->excuteSQL();

      }


}

?>
