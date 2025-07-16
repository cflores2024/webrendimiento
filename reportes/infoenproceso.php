<?php
    session_start(); 
 
    $idusuario=$_SESSION['id'];

    include "../configuracion/conexion.php";

    $encabezado="<table class='table table-hover'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Orden</th>
                        <th scope='col'>Titulo</th>
                        <th scope='col'>Estado</th>
                        <th scope='col'>F. Recepción</th>
                        <th scope='col'>F. Entrega</th>
                        <th scope='col'>Tiempo Tratamiento (hh)</th>
                        <th scope='col'>Tiempo Suspendida (hh)</th>
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
                    CASE WHEN a.`estado`='P' THEN 'En Proceso'
                        ELSE 'Error' END estado,
                    a.`fecha` AS frecepcion,
                    a.`fentrega` AS fentrega,
                    TIMESTAMPDIFF(HOUR,a.`fecha`,a.`fechaaccion`) AS torden,
                    (SELECT CASE WHEN aa.`ffin` IS NULL THEN 
                                    TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),NOW()) 
                            ELSE 
                                    TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),MAX(aa.`ffin`)) 
                            END
                     FROM tareassuspendidas aa 
                     WHERE aa.`numorden`=a.`numorden`) tsuspendida
                FROM numeroorden a
                WHERE a.`accion`!='B' AND a.estado='P' AND (DATE(a.`fentrega`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%')
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
                                <td><a href='#' onclick='vercontenidotarea(".$row['numorden'].",".$idusuario.")'>#".$row["numorden"]."</a></td>
                                <td>".$row["tituloorden"]."</td>
                                <td>".$row["estado"]."</td>
                                <td>".$row["frecepcion"]."</td>
                                <td>".$row["fentrega"]."</td>
                                <td>".$row["torden"]."</td>
                                <td>".$row["tsuspendida"]."</td>
                            </tr>";
                 $i=$i+1;
            }
        }

        desconectar($con);   
      
        if ($fila!="") echo $encabezado."".$fila."".$pie;
        else echo $encabezado."<tr><td style='text-align: center;' colspan='8'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='8'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>