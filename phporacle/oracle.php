<?php
    include "connect.php";

$username = 'CESAR';
$password = 'cesar';
$connection_string = '//134.14.1.88/orcl';

// Establish a connection
$c = oci_connect($username, $password, $connection_string);

// Use bind variable to improve resuability, 
// and to remove SQL Injection attacks.
$query = 'SELECT numero_or,fecha_carga_or,fecha_entrega_estimada_or,cliente,chasis,patente,kilom,dni,telefono,email 
        FROM CAB_ORDREP_W 
        WHERE numero_or = :eidbv';

$s = oci_parse($c, $query);

$myeid = 170803;
oci_bind_by_name($s, ":EIDBV", $myeid);
oci_execute($s);

 $datos=array();

 while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
    
    foreach ($row as $item) {
     //print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
     $datos[]=$item;
   }
   
 }

// Close the Oracle connection
oci_close($c);

echo $datos[3];
?>