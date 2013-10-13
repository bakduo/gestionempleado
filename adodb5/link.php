<?php

include_once('lib/adodb/adodb.inc.php');

include_once('lib/adodb/adodb-exceptions.inc.php'); 

try { 
    $db = ADONewConnection(DATABASE_TYPE); 
    $db->debug = DEBUG;
    $db->PConnect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME); 
} catch (exception $e) { 
        var_dump($e); 
        adodb_backtrace($e->gettrace());
} 
 
?>
