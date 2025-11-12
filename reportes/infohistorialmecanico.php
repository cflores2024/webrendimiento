<?php
    session_start(); 
 
    $idusuario=$_SESSION['id'];
    
    include "../configuracion/conexion.php";

    $encabezado="
                 <table class='table table-hover' id='miTabla'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Mecanico</th>
                        <th scope='col'>Orden</th>
                        <th scope='col'>Titulo Orden</th>
                        <th scope='col'>F. Inicio</th>
                        <th scope='col'>F. Fin</th>
                        <th scope='col'>Tiempo (hh:mm)</th>
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
        $fila="";
        $filameca="";
        $i=1;
        /*
            $sql="-- LISTADO DE TAREAS REALIZADAS
                    SELECT b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS mecanico,a.`numorden`,
                    b.`idtarea`,d.`descripciontarea`,b.`fechaini`,b.`fechaobs`,
                    ROUND(TIMESTAMPDIFF(MINUTE,b.`fechaini`,b.`fechaobs`)/60,2) AS ttiempo
                    FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                                INNER JOIN tareas d ON (b.`idtarea`=d.`idtarea` AND d.`accion`!='B')
                    WHERE a.`accion`!='B' AND b.`estado`='F' AND (DATE(a.fentrega) BETWEEN '".$fini."' AND '".$ffin."') AND 
                        (a.`numorden` LIKE '%".$num."%') AND (d.`descripciontarea` LIKE '%".$titulo."%') 
                        AND (CONCAT(c.`apellido`,',',c.`nombre`) LIKE '%".$emp."%')
                    GROUP BY 1,2,3,4,5,6,7
                    ORDER BY 1;";
                    */
            $sql="
                -- LISTADO DE ORDENES REALIZADAS Y FINALIZADAS
                SELECT b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS mecanico,a.`numorden`,a.`tituloorden`,
	                   MIN(b.`fechaini`) AS fechaini,MAX(b.`fechaobs`) AS fechaobs,
	                   ROUND(TIMESTAMPDIFF(MINUTE,MIN(b.`fechaini`),MAX(b.`fechaobs`))/60,2) AS ttiempo
                FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
		                           INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                WHERE a.`accion`!='B' AND b.`estado`='F' AND (DATE(a.fentrega) BETWEEN '".$fini."' AND '".$ffin."') AND 
                        (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%') 
                        AND (CONCAT(c.`apellido`,',',c.`nombre`) LIKE '%".$emp."%')
                    GROUP BY 1,2,3,4
                    ORDER BY 1;
                 ";
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
                    if (strlen($row["idempleado"])>0)
                    {
                        $fila=$fila."<tr class='fila'>
                                        <th scope='row'>".$i."</th>
                                        <td>".$row['mecanico']."</td>
                                        <td><a href='#' onclick='vercontenidotarea(".$row['numorden'].",".$idusuario.",".$row['idtarea'].")'>#".$row['numorden']."</a></td>
                                        <td>".$row['tituloorden']."</td>
                                        <td>".$row['fechaini']."</td>
                                        <td>".$row['fechaobs']."</td>
                                        <td>".$row['ttiempo']."</td>
                                    </tr>";
                        $i=$i+1;
                    }
                }
            }

            desconectar($con);   
            
            $tablageneral="";

            if ($fila!="") echo $encabezado."".$fila."".$pie;
            else echo $encabezado."<tr><td style='text-align: center;' colspan='7'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='7'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>