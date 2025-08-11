<?php
    session_start(); 
    
    $idusuario=$_SESSION['id'];
    
    include "../configuracion/conexion.php";

    $encabezado="
                 <table class='table table-hover' id='miTabla'>
                    <thead>
                    <tr>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Mecanico</th>
                        <th scope='col'>Chasis Auto</th>
                        <th scope='col'>Tarea</th>
                        <th scope='col'>Tiempo (hh:mm)</th>
                        <th scope='col'>&nbsp</th>           
                    </tr>
                    </thead>
                    <tbody>";

    $pie="</tbody>
            </table>";

    if ((isset($_GET['fini']))&&(isset($_GET['ffin']))&&(isset($_GET['num']))&&(isset($_GET['titulo']))&&(isset($_GET['emp'])))
    {
        $fini=$_GET['fini'];
        $ffin=$_GET['ffin'];
        $titulo=$_GET['titulo'];
        $num=$_GET['num'];
        $emp=$_GET['emp'];
       
        $fini30dias = strtotime('-30 day', strtotime($fini));
        $fini30dias = date('Y-m-j', $fini30dias);

        $ffin30dias = strtotime('-1 day', strtotime($fini));
        $ffin30dias = date('Y-m-j', $ffin30dias);
        
       
        $fila="";
              
        //RECUPERO LOS REGISTROS DE REVISITAS A MOSTRAR
            $sql="SELECT DATE(a.`fecha`) AS fecha,
                        CONCAT(d.`apellido`,',',d.`nombre`) AS empleado,
                        a.`numchasis`,c.`descripciontarea`,
                    (
                    SELECT CASE WHEN COUNT(xx.`numchasis`)<=0 THEN 'N' ELSE TIMESTAMPDIFF(HOUR,MIN(zz.`fini`),MAX(zz.`ffin`)) END
                    FROM numeroorden xx INNER JOIN afectadostareas yy ON (xx.`numorden`=yy.`numorden`)
                                        INNER JOIN detalleorden zz ON (xx.numorden=zz.numeroorden AND zz.idtarea=yy.idtarea AND zz.accion!='B')
                    WHERE xx.accion!='B' AND xx.estado='F' AND xx.numchasis=a.`numchasis` AND yy.idtarea=b.`idtarea` AND (DATE(xx.`fecha`) BETWEEN '".$fini30dias."' AND '".$ffin30dias."')
                        ) ttiempo
                FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                INNER JOIN tareas c ON (b.idtarea=c.idtarea AND c.accion!='B')
                                INNER JOIN personas d ON (d.idpersona=b.idempleado AND d.accion!='B')
                WHERE a.`accion`!='B' AND a.`estado`!='S' AND (DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') 
                    AND (c.`descripciontarea` LIKE '%".$titulo."%') AND (CONCAT(d.`apellido`,',',d.`nombre`) LIKE '%".$emp."%') 
                GROUP BY 3,4
                ORDER BY ttiempo ASC;";

           // echo $sql;

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
                $fila="";
                $bandera=false;
                $numchasis="";

                while(($row = mysqli_fetch_array($result))&&($bandera==false))
                {
                    
                    if ($row['ttiempo']=="N")
                    {
                        $bandera=true;
                    }
                    else
                    {
                        $numchasis=$row['numchasis'];

                        $fila=$fila."<tr class='fila'>
                                        <td>".$row['fecha']."</td>
                                        <td>".$row['empleado']."</td>
                                        <td>".$numchasis."</td>
                                        <td>".$row['descripciontarea']."</td>
                                        <td>".$row['ttiempo']."</td>
                                        <td>
                                            <a href='#'>
                                                <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                            </a>
                                        </td>
                                    </tr>";
                    }           
                }
            }
         
            desconectar($con);
        //FIN RECUPERO LOS REGISTROS DE REVISITAS A MOSTRAR
        
            if ($fila!="") echo $encabezado."".$fila."".$pie;
            else echo $encabezado."<tr><td style='text-align: center;' colspan='6'>Sin datos para mostrar</td></tr>".$pie;
    
            }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='6'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>