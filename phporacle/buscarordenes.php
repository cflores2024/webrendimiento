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

/*

<?php

function do_fetch($myeid, $s)
{
  // Fetch the results in an associative array
  print '<p>$myeid is ' . $myeid . '</p>';
  print '<table border="1">';
  while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
    print '<tr>';
    foreach ($row as $item) {
      print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
    }
    print '</tr>';
  }
  print '</table>';
}

// Create connection to Oracle
$c = oci_connect("phphol", "welcome", "//localhost/orcl");

// Use bind variable to improve resuability, 
// and to remove SQL Injection attacks.
$query = 'select * from employees where employee_id = :eidbv';
$s = oci_parse($c, $query);

$myeid = 101;
oci_bind_by_name($s, ":EIDBV", $myeid);
oci_execute($s);
do_fetch($myeid, $s);

// Redo query without reparsing SQL statement
$myeid = 104;
oci_execute($s);
do_fetch($myeid, $s);

// Close the Oracle connection
oci_close($c);

?>

*/

?>
