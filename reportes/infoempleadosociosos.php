<?php
    include "../configuracion/conexion.php";

    $encabezado="<table class='table table-hover' id='tablemec'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Apellido</th>
                        <th scope='col'>Nombre</th>
                    </tr>
                    </thead>
                    <tbody>";

    $pie="</tbody>
            </table>";

    if ((isset($_GET['fini']))&&(isset($_GET['ffin']))&&(isset($_GET['emp'])))
    {
        $fini=$_GET['fini'];
        $ffin=$_GET['ffin'];
        $emp=$_GET['emp'];
        $fila="";
        $i=1;

        $sql="SELECT xx.`idpersona`,xx.`apellido`,xx.`nombre`
                FROM personas xx
                WHERE xx.`accion`!='B' AND (CONCAT(xx.`apellido`,',',xx.`nombre`) LIKE '%".$emp."%') AND xx.`idtipopersona`=4 
                    AND xx.`idpersona` NOT IN (SELECT a.`idempleado`
                                                FROM afectadostareas a
                                                WHERE (DATE(a.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."')
                                                GROUP BY 1
                                                ORDER BY 1)
                ORDER BY 1,2;";

            //echo $sql;
        $con=conectar();

        $resp=false;

        $result = $cnx->query($sql);

        if (!$result) 
        {
            die('Invalid query: ' . $cnx->error);
        }

        if (!$result) 
        {
            die('Invalid query: ' . $mysqli->error);
        }
        else
        {
            while($row = mysqli_fetch_array($result))
            {
                $fila=$fila."<tr>
                                <th scope='row'>".$i."</th>
                                <td>".$row['apellido']."</td>
                                <td>".$row['nombre']."</td>
                            </tr>";
                $i=$i+1;
            }
        }

        desconectar($con);   
      
        if ($fila!="") echo $encabezado."".$fila."".$pie;
        else echo $encabezado."<tr><td style='text-align: center;' colspan='3'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='3'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>