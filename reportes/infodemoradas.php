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
                        <th scope='col'>F. Esti. Entrega</th>
                        <th scope='col'>Demora (hh)</th>
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
  
        $sql="SELECT a.`numorden`,a.`tituloorden`,
                    CASE WHEN a.`estado`='S' THEN 'No Disponible'
                        WHEN a.`estado`='D' THEN 'Disponible'
                        WHEN a.`estado`='P' THEN 'En Proceso'
                        ELSE 'Error' END estado,
                    a.`fecha` AS frecepcion,
                    CONCAT(a.`fentrega`,' 18:59:00') AS festimadaentrega,
                    CASE WHEN NOW()=a.fentrega THEN TIMESTAMPDIFF(HOUR,a.`fecha`,a.`fechaaccion`)
                    ELSE TIMESTAMPDIFF(HOUR,a.`fecha`,NOW()) END tiempodemora
            FROM numeroorden a
            WHERE a.`accion`!='B' AND a.`estado`='F' AND DATE(a.`fentrega`)<DATE(a.`fechaaccion`) AND  (DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%')
            ORDER BY a.fecha;";

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
                                <td>".$row["frecepcion"]."</td>
                                <td>".$row["festimadaentrega"]."</td>
                                <td>".$row["tiempodemora"]."</td>
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