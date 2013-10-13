<?php

require('config/setup.php');


session_start();

$smarty = new Smarty_Proyect();

$smarty->assign('title',"Sistema de autodesempeño");

$smarty->assign('media','media');

$smarty->display('cargarformulario.html');
