<?php

require('config/setup.php');
require('lib/model/SQL.php');

session_start();

$smarty = new Smarty_Proyect();

$test= new QuerySQL("select * from empleados");

$record=$test->excuteSQL();

$smarty->assign('empleados',$record);

$smarty->assign('title',"Sistema de autodesempeño");

$smarty->assign('media','media');

$smarty->display('index.html');

?>
