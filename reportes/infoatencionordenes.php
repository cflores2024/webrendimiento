<?php
    include "../configuracion/conexion.php";

    $encabezado="<table class='table table-hover'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Orden</th>
                        <th scope='col'>Titulo</th>
                        <th scope='col'>Estado</th>
                        <th scope='col'>F. Recepción</th>
                        <th scope='col'>F. Autoriza</th>
                        <th scope='col'>Demora (hh:mm)</th>
                    </tr>
                    </thead>
                    <tbody>";

    $pie="</tbody>
            </table>";

    if ((isset($_GET['fini']))&&(isset($_GET['ffin']))&&(isset($_GET['num']))&&(isset($_GET['titulo'])))
    {
        $fini=$_GET['fini'];
        $ffin=$_GET['ffin'];
        $titulo=$_GET['titulo'];
        $num=$_GET['num'];
        $fila="";
        $i=1;
  
        $sql="SELECT a.`numorden`,a.`tituloorden`,a.estado,a.`fecha`,b.`fechaautoriza`,ROUND(TIMESTAMPDIFF(MINUTE,a.`fecha`,b.`fechaautoriza`)/60,2) AS ttiempo
                FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden`)
                WHERE a.`accion`!='B' AND a.`estado`='F' AND (DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%')
                ORDER BY 3;";

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
                                <td>".$row["numorden"]."</td>
                                <td>".$row["tituloorden"]."</td>
                                <td>".$row["estado"]."</td>
                                <td>".$row["fecha"]."</td>
                                <td>".$row["fechaautoriza"]."</td>
                                <td>".$row["ttiempo"]."</td>
                            </tr>";
                 $i=$i+1;
            }
        }

        desconectar($con);   
      
        if ($fila!="") echo $encabezado."".$fila."".$pie;
        else echo $encabezado."<tr><td style='text-align: center;' colspan='7'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='7'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>