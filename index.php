<?php

/*
#############################################################################
#                                                                           #
#   index.php                                                               #
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
require 'lib/flight/autoload.php';
use flight\Engine;
$app = new Engine();

// Adds X-Frame-Options to HTTP header, so that page cannot be shown in an iframe.
header('X-Frame-Options: DENY');

// Adds X-Frame-Options to HTTP header, so that page can only be shown in an iframe of the same site.
header('X-Frame-Options: SAMEORIGIN');
//Session PHP clasica

if (!session_id()) session_start();


$enabled=true;

$app->init();
$app->set('flight.log_errors', true);
$app->set('flight.handle_errors',true);
$app->path('controller');
$app->path('media');
$app->path('model');
$app->path('config');
$app->set('flight.base_url','/rest');

$app->register('router', '\flight\net\CustomRouter');

//Mapeos para las consultas de rrhh

$app->router()->mapCustom('/objetivos/',$enabled);
$app->router()->mapCustom('/poempleadoid/@id:[0-9]+',$enabled);
$app->router()->mapCustom('/poempleado/@id:[0-9]+',$enabled);
$app->router()->mapCustom('/oempleado/@id:[0-9]+',$enabled);
$app->router()->mapCustom('/empleado/@id:[0-9]+',$enabled);
$app->router()->mapCustom('/empleados/',$enabled);
$app->router()->mapCustom('/saveTargets',$enabled);
$app->router()->mapCustom('/saveJustificaEmpleado',$enabled);
$app->router()->mapCustom('/saveMensajeInicialDelJefe',$enabled);
$app->router()->mapCustom('/saveMensajeFinalDelJefe',$enabled);


$app->router()->mapCustom('/saveObjetivos',$enabled);
$app->router()->mapCustom('/saveRespuestaJefe',$enabled);

$app->router()->mapCustom('/saveEmpleado',$enabled);



//fin mapeos para las consultas de los hoteles

$route=$app->router()->route($app->request());

if ($route){
    $result=$route->getPattern();
	switch ($result) {
    case '/empleados/':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        echo $r->getEmpleadosJson();
        break;
    case '/objetivos/':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        echo $r->getObjetivosJson();
        break;
    case '/empleado/@id:[0-9]+':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        $parametros=$route->getParams();
        echo $r->getEmpleadoJson($parametros['id']);
        break;
    case '/poempleadoid/@id:[0-9]+':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        $parametros=$route->getParams();
        echo $r->getPoEmpleadoIdJson($parametros['id']);
        break;
    case '/poempleado/@id:[0-9]+':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        $parametros=$route->getParams();
        echo $r->getPoEmpleadoDescJson($parametros['id']);
        break;
    case '/oempleado/@id:[0-9]+':
        require 'controller/rrhh.php';
        $r=new Rrhh();
        $parametros=$route->getParams();
        echo $r->getOEmpleadoDescJson($parametros['id']);
        break;
    case '/saveTargets':
        require 'controller/rrhh.php';
        $parametros=$app->request()->data;
        if ($parametros){
            $r = new Rrhh();
            echo $r->setTargets($parametros['json']);
        }else{
            echo "Error";
        }
        
        break;
    case '/saveJustificaEmpleado':
        require 'controller/rrhh.php';
        $parametros=$app->request()->data;
        if ($parametros){
            $r = new Rrhh();
            echo $r->setJustificaEmpleado($parametros['json']);
        }else{
            echo "Error";
        }
        break;
    case '/saveMensajeInicialDelJefe':
        require 'controller/rrhh.php';
        $parametros=$app->request()->data;
        if ($parametros){
            $r = new Rrhh();
            echo $r->setMensajeInicialDelJefe($parametros['json']);
        }else{
            echo "Error";   
        }
        break;
    case '/saveMensajeFinalDelJefe':
        require 'controller/rrhh.php';
        $parametros=$app->request()->data;
        if ($parametros){
            $r = new Rrhh();
            echo $r->setMensajeFinalDelJefe($parametros['json']);
        }else{
            echo "Error";   
        }
        break;
    }
}else{
	echo "Don't Worry about that";
}
?>
