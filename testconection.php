<?php

$conn_string = "dbname=dbhfgnl9g3dkkk host=ec2-50-19-101-44.compute-1.amazonaws.com port=5432 user=amgxszynwpmopo password=MzgLlHjfYHqA2Lrfne49-aKhAt sslmode=require";

$dbconn = pg_connect($conn_string) 
          or die('Could not connect: ' . pg_last_error());

echo "Connected to the DB";

?>
