<?php
include "configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

if (isset($_GET["num"]))
{  
    $orden=$_GET["num"];

    $sql = "SELECT b.`descripciontarea`,a.`fini`,a.`ffin`,a.`observacion`,a.`estado`
            FROM detalleorden a INNER JOIN tareas b ON (a.`idtarea`=b.`idtarea` AND b.`accion`!='B')
            WHERE a.`accion`!='B' AND a.`numeroorden`='".$orden."'
            ORDER BY b.`descripciontarea`;";

    $con=conectar();

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

        $info="
                <h5 class='card-title'>Listado de tareas - Orden Número ".$orden."</h5>
    
                <table class='table table-hover'>
                    <thead>
                        <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Descripción</th>
                        <th scope='col'>F. Inicio</th>
                        <th scope='col'>F. Fin</th>
                        <th scope='col'>Observacion</th>
                        <th scope='col'>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
            ";

        $fil="";
        $i=1;

        while($row = mysqli_fetch_array($result))
        {
            $fil=$fil."
                <tr>
                    <th scope='row'><a href='#'>#".$i."</a></th>
                    <td>".$row['descripciontarea']."</td>
                    <td>".$row['fini']."</td>
                    <td>".$row['ffin']."</td>
                    <td>".$row['observacion']."</td>
                    <td>";
            
                    switch ($row['estado'])
                    {
                        case "F":
                            $fil=$fil."Fin";
                            break;
                        case "D":
                            $fil=$fil."Disp";
                            break;
                        case "P":
                            $fil=$fil."Proc";
                            break;
                        case "S":
                            $fil=$fil."Esp";
                            break;
                    }
            
            $fil=$fil."</td></tr>";

            $i=$i+1;
        }
    
        if (strlen($fil)<=0)
        {
            $info="No existe información alguna sobre orden seleccionada!!!";
        }
        else
        {
            $info=$info."".$fil."</tbody></table>";
        }
    }
    
    desconectar($con);
}
else
{
    $info="Error. No se recibio correctamente el número de orden!!!";
}

echo $info;
?>