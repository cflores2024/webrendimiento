<?php
    session_start(); 
 
    $idusuario=$_SESSION['id'];
    
    include "../configuracion/conexion.php";

    if (isset($_GET['orden']))
    {
        $num=$_GET['orden'];
        $filameca="";
      
        //TABLA QUE MUESTRA TOTALES GENERALES AGRUPADOS POR MECANICOS DE LA ANTERIOR TABLA
        $encabezadomeca="
                        <table class='table table-hover' id='miTabla'>
                            <thead>
                            <tr>
                                <th scope='col'>Mecanico</th>
                                <th scope='col'>Nombre de la Tarea</th>
                                <th scope='col'>Estado</th>
                                <th scope='col'>Fecha Inicio</th>
                                <th scope='col'>Fecha Fin</th>
                                <th scope='col'>Tiempo Productivo (hh:mm)</th>
                                <th scope='col'>Tiempo Suspendida (hh:mm)</th>
                            </tr>
                            </thead>
                            <tbody>";

        $piemeca="</tbody>
                </table>";
                

        $sql="SELECT a.`numorden`,b.`idempleado`,c.`urlfoto`,CONCAT(c.`apellido`,', ',c.`nombre`) AS mecanico,
                                    b.`idtarea`,d.`descripciontarea`,
                                     CASE WHEN b.`estado`='S' THEN 'No Disponible'
                                        WHEN b.`estado`='D' THEN 'Disponible'
                                        WHEN b.`estado`='F' THEN 'Finalizada'
                                        WHEN b.`estado`='P' THEN 'En Proceso'
                                        ELSE 'Error' END estado,
                                    b.`fechaini`,b.`fechaobs`,
                                    CASE WHEN b.`fechaobs` IS NULL THEN TIMESTAMPDIFF(HOUR,b.fechaini,NOW()) ELSE TIMESTAMPDIFF(HOUR,b.`fechaini`,b.`fechaobs`) END ttiempo,
                                    (SELECT CASE WHEN aa.`ffin` IS NULL THEN 
                                                        TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),NOW()) 
                                                ELSE 
                                                        TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),MAX(aa.`ffin`)) 
                                                END
                                        FROM tareassuspendidas aa 
                                        WHERE aa.`numorden`=a.`numorden` AND aa.idtarea=b.`idtarea`) tsuspendida  
            FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                                INNER JOIN tareas d ON (b.`idtarea`=d.`idtarea` AND d.`accion`!='B')
            WHERE a.`accion`!='B' AND a.estado!='S' AND a.`numorden`='".$num."';";

        //echo $sql;
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
            $i=0;
           
            while($row = mysqli_fetch_array($result))
            {
                if ($i==0)
                {
                    $i=$result->num_rows+1;

                    $filameca="
                                    <tr class='fila' style='text-align: center;'>
                                        <td scope='col' rowspan='".$i."'>
                                            <p>
                                                <label>".$row['mecanico']."</label>
                                            </p>
                                            <p>
                                                <img src='assets/img/".$row['urlfoto']."' alt='Profile'  width='48' height='64'>
                                            </p>
                                            <p>
                                                <a href='#' onclick='vercontenidotarea(".$row['numorden'].",".$idusuario.",".$row['idempleado'].")'>#".$row['numorden']."</a>
                                            </p>
                                        </td>
                                        <td>".$row['descripciontarea']."</td>
                                        <td>".$row['estado']."</td>
                                        <td>".$row['fechaini']."</td>
                                        <td>".$row['fechaobs']."</td>
                                        <td>".$row['ttiempo']."</td>
                                        <td>".$row['tsuspendida']."</td>
                                    </tr>";
                }
                else
                {
                    $filameca=$filameca."<tr class='fila' style='text-align: center;'>
                                            <td>".$row['descripciontarea']."</td>
                                            <td>".$row['estado']."</td>
                                            <td>".$row['fechaini']."</td>
                                            <td>".$row['fechaobs']."</td>
                                            <td>".$row['ttiempo']."</td>
                                            <td>".$row['tsuspendida']."</td>
                                        </tr>";
                }
            }
        }

        //echo $tablafoto;
      
        desconectar($con);   
        
        if ($filameca!="") echo $encabezadomeca."".$filameca."".$piemeca;
        else echo $encabezadomeca."<tr><td style='text-align: center;' colspan='7'>Sin datos para mostrar</td></tr>".$piemeca;

        //FIN TABLA QUE MUESTRA TOTALES GENERALES DE LA ANTERIOR TABLA  
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='7'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
         
?>