<?php

// load Smarty library
require('lib/smarty/Smarty.class.php');

// The setup.php file is a good place to load
// required application library files, and you
// can do that right here. An example:

class Smarty_Proyect extends Smarty {

	function __construct(){
		parent::__construct(); 
        $this->setTemplateDir('resources/template/');
        $this->setCompileDir('resources/compiled/');
        $this->setConfigDir('resources/config');
        $this->setCacheDir('resources/cache/');
        $this->caching = true;
        $this->assign('app_name', 'Proyect');
	}

}
?>
