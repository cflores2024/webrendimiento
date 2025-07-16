<?php
    session_start(); 
 
    $idusuario=$_SESSION['id'];
    
    include "../configuracion/conexion.php";

    $encabezado="<!--div style='text-align: center;'>
                    <!--br/><input type='button' id='btnAccion' class='btn btn-primary' value='Ocultar/Mostrar'-->
                   
                    <!--br/><input type='button' id='btnAccion' class='btn btn-primary' value='Ocultar/Mostrar' onclick='compararmecanicos()'-->
                    <!--label for='ocultarFilas'>Ocultar Filas:</label>
                    <input type='checkbox' id='ocultarFilas' onchange='toggleRows()'-->
                 </div-->
                 <table class='table table-hover' id='miTabla'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Mecanico</th>
                        <th scope='col'>Orden</th>
                        <th scope='col'>Tarea</th>
                        <th scope='col'>F. Inicio</th>
                        <th scope='col'>F. Fin</th>
                        <th scope='col'>Tiempo (hh:mm)</th>
                        <th scope='col'>&nbsp;</th>
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
        $emp=$_GET['emp'];
         $fila="";
        $i=1;

        $sql="-- LISTADO DE TAREAS REALIZADAS
                SELECT b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS mecanico,a.`numorden`,
                d.`descripciontarea`,b.`fechaini`,b.`fechaobs`,
                ROUND(TIMESTAMPDIFF(MINUTE,b.`fechaini`,b.`fechaobs`)/60,2) AS ttiempo
                FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                            INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                            INNER JOIN tareas d ON (b.`idtarea`=d.`idtarea` AND d.`accion`!='B')
                WHERE a.`accion`!='B' AND a.`estado`='F' AND (DATE(a.fentrega) BETWEEN '".$fini."' AND '".$ffin."') AND 
                      (a.`numorden` LIKE '%".$num."%') AND (d.`descripciontarea` LIKE '%".$titulo."%') 
                      AND (CONCAT(c.`apellido`,',',c.`nombre`) LIKE '%".$emp."%')
                GROUP BY 1,2,3,4,5,6
                ORDER BY 1;";
  /*
        $sql="-- total tareas en proceso, no estan suspendidas y no abandono
                SELECT a.`idempleado`,CONCAT(b.`apellido`,',',b.`nombre`) AS mecanico,
                (-- total tareas en proceso, no suspendidas y no abandono
                SELECT COUNT(a1.`idtarea`) FROM afectadostareas a1 
                WHERE a1.`estado`='P' AND a1.`suspendida`='N' AND a1.`abandona`='N' AND (DATE(a1.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a1.idempleado=a.`idempleado`) AS cantproceso,
                (-- total tareas en proceso, suspendidas y no abandono
                SELECT COUNT(a2.`idtarea`) FROM afectadostareas a2 
                WHERE a2.`estado`='P' AND a2.`suspendida`='S' AND a2.`abandona`='N' AND (DATE(a2.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a2.idempleado=a.`idempleado`) AS cantsuspendida,
                (-- total tareas finalizadas, no suspendidas y no abandono
                SELECT COUNT(a3.`idtarea`)FROM afectadostareas a3 
                WHERE a3.`estado`='F' AND a3.`suspendida`='N' AND a3.`abandona`='N' AND (DATE(a3.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a3.idempleado=a.`idempleado`) AS cantfinalizadas,
                (-- total tareas en proceso, no estan suspendidas y abandono
                SELECT COUNT(a4.`idtarea`) FROM afectadostareas a4
                WHERE a4.`estado`='P' AND a4.`suspendida`='N' AND a4.`abandona`='S' AND (DATE(a4.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a4.idempleado=a.`idempleado`) AS cantabproceso,
                (-- total tareas en proceso, suspendidas y abandono
                SELECT COUNT(a5.`idtarea`) FROM afectadostareas a5
                WHERE a5.`estado`='P' AND a5.`suspendida`='S' AND a5.`abandona`='S' AND (DATE(a5.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a5.idempleado=a.`idempleado`) AS cantabsuspendida,
                (-- total tareas finalizadas, no suspendidas y abandono
                SELECT COUNT(a6.`idtarea`) FROM afectadostareas a6
                WHERE a6.`estado`='F' AND a6.`suspendida`='N' AND a6.`abandona`='S' AND (DATE(a6.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND a6.idempleado=a.`idempleado`) AS cantabfinalizadas,
                MONTH(a.`fechaini`) AS mes
                FROM afectadostareas a INNER JOIN personas b ON (a.`idempleado`=b.`idpersona` AND b.`accion`!='B')
		                               INNER JOIN numeroorden c ON (a.`numorden`=c.numorden AND c.accion!='B')
                                       INNER JOIN tareas d ON (a.`idtarea`=d.idtarea AND d.accion!='B')
                WHERE (DATE(a.`fechaini`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (d.`descripciontarea` LIKE '%".$titulo."%') AND (CONCAT(b.`apellido`,',',b.`nombre`) LIKE '%".$emp."%') 
                GROUP BY 1,2,3
                ORDER BY 1;";
*/
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
                                    <td>".$row['numorden']."</td>
                                    <td>".$row['descripciontarea']."</td>
                                    <td>".$row['fechaini']."</td>
                                    <td>".$row['fechaobs']."</td>
                                    <td>".$row['ttiempo']."</td>
                                    <td><input type='checkbox' id='".$row['idempleado']."' name='".$row['idempleado']."' value='".$row['idempleado']."'></td>
                                </tr>";
                    $i=$i+1;
                }
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