<?php

$fini=$_GET['fini'];
$ffin=$_GET['ffin'];
$username = 'CESAR';
$password = 'cesar';
$connection_string = '//134.14.1.88/orcl';

// Establish a connection
$c = oci_connect($username, $password, $connection_string);

$query = "SELECT numero_or,fecha_carga_or,fecha_entrega_estimada_or,cliente,chasis,patente,kilom,dni,telefono,email 
          FROM CAB_ORDREP_W 
          WHERE numero_or='170804';";

$s = oci_parse($c, $query);

oci_execute($s);

$titulo= '<p>Ordenes recuperadas dentro de las fechas: ' . $fini . ' y '. $ffin .'</p>';

$fil="";
while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
    $fil=$fil ."<tr><td>". $row['numero_or'] ."</td></tr>";
}

$tabla=$titulo ."<table border='1'>". $fil ."</table>";

// Close the Oracle connection
oci_close($c);

echo $tabla;

//echo "Recibe las fechas=". $fini ."-". $ffin;

?>
