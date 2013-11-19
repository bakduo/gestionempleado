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
        //$json = '[{"objetivo":"tres","empleado":"12","target":"Sin target"},{"objetivo":"Mantener una adecuada y oportuna comunicación con los\/as usuarios\/as para canalizar los requerimientos de información en las diferentes áreas.\\r","empleado":"12","target":"Sin target"},{"objetivo":"Testear los programas elaborados para eliminar o corregir deficiencias o errores.\\r","empleado":"12","target":"Sin target"},{"objetivo":"uno","empleado":"12","target":"Sin target"},{"objetivo":"dos","empleado":"12","target":"Sin target"}]';
        $j = json_decode($json);
        for ($i=0; $i < sizeof($j) ; $i++) { 
          $test= QuerySQL::getInstance();
          $test->setSQL("select objetivo from objetivos where descripcion = '".$j[$i]->objetivo."'");
          $record=$test->excuteSQL();
          if($record == ''){
            $test= QuerySQL::getInstance();
            $test->setSQL("select count(*) from objetivos");
            $cant=$test->excuteSQL();
            $cant = $cant[0] + 1;
            $test= QuerySQL::getInstance();
            $test->setSQL("insert into objetivos (objetivo, descripcion) VALUES(".$cant.",'".$j[$i]->objetivo."')");
            $obj=$test->excuteSQL();
            $objetivo_id = $cant;
          }else{
            $objetivo_id = $record[0]; 
          }
          $test= QuerySQL::getInstance();
          $test->setSQL("insert into objetivos_targets_empleado (objetivo_id, empleado_id, target) VALUES(".$objetivo_id.",".$j[$i]->empleado.",'".$j[$i]->target."')");
          $test->excuteSQL();
        }
      }

      public function setJustificaEmpleado($json){
        require_once('lib/model/SQL.php');
        //$json = '{"periodo":"2013-11-19","empleado":"12","respuestafeedback":"esta seria la justificacion del empleado"}';
        $j = json_decode($json);

        $test= QuerySQL::getInstance();
        $test->setSQL("insert into justificacion_empleados ( empleado_id,periodo,respuesta_feedback ) values( ".$j->empleado.", '".$j->periodo."', '".$j->respuestafeedback."' ) ");
        $result=$test->excuteSQL();
      }

      public function setMensajeInicialDelJefe($json){
        require_once('lib/model/SQL.php');
        $json = '{"periodo":"2013-11-19","empleado":"10","descripcion":"esta es la descripcion del estado inicial", "estado":"false"}';
        $j = json_decode($json);

        $test= QuerySQL::getInstance();
        $test->setSQL("insert into informe_empleados (empleado_id,periodo,descripcion_inicial,estado_inicial) values( ".$j->empleado.", '".$j->periodo."', '".$j->descripcion."', ".$j->estado.") ");
        $result=$test->excuteSQL();
      }

      public function setMensajeFinalDelJefe($json){
        require_once('lib/model/SQL.php');
        $json = '{"periodo":"2013-11-19","empleado":"10","descripcion":"esta es la descripcion del estado final", "estado":"true"}';
        $j = json_decode($json);
        
        $test= QuerySQL::getInstance();
        $q = "update informe_empleados set descripcion_final='".$j->descripcion."', estado_final=".$j->estado."  where empleado_id=".$j->empleado." and periodo='".$j->periodo."'";
        $test->setSQL("update informe_empleados set descripcion_final='".$j->descripcion."', estado_final=".$j->estado."  where empleado_id=".$j->empleado." and periodo='".$j->periodo."'");
        
        $result=$test->excuteSQL();
      }


}

?>
