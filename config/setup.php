<?php
/*
#############################################################################
#                                                                           #
#   Clase setup                                                             #
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
// load Smarty library
require('lib/smarty/Smarty.class.php');

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
