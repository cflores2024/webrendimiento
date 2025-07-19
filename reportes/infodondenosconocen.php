<?php
    include "../configuracion/conexion.php";

    $encabezado="<table class='table table-hover' id='tablemec'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Canal publicitario</th>
                        <th scope='col'>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>";

    $pie="</tbody>
            </table>";

    if ((isset($_GET['fini']))&&(isset($_GET['ffin'])))
    {
        $fini=$_GET['fini'];
        $ffin=$_GET['ffin'];
        $fila="";
        $i=1;

        $sql="SELECT b.`publicacion`,COUNT(a.`numorden`) AS cant
              FROM numeroorden a INNER JOIN publicaciones b ON (a.`idpublicidad`=b.`idpublicacion`)
              WHERE a.`accion`!='B' AND DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."'
              GROUP BY 1
              ORDER BY 1;";

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
                                <td>".$row['publicacion']."</td>
                                <td>".$row['cant']."</td>
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