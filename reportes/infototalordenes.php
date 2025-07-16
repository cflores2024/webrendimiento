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
                        <th scope='col'>F. Esti. Entrega</th>
                        <th scope='col'>F. Real Entrega</th>
                        <th scope='col'>Consumido (hh)</th>
                        <th scope='col'>Suspendida (hh)</th>
                        <th scope='col'>Tiempo Productivo (hh)</th>
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
        $filameca="";
        $i=1;
  
        //CONSULTA QUE TRAE LISTADO DE ORDENES Y SITUACIONES EN LAS QUE SE ENCUENTRAN
       
            $sql="SELECT a.`numorden`,a.`tituloorden`,
                        CASE WHEN a.`estado`='S' THEN 'No Disponible'
                            WHEN a.`estado`='D' THEN 'Disponible'
                            WHEN a.`estado`='F' THEN 'Finalizada'
                            WHEN a.`estado`='P' THEN 'En Proceso'
                            ELSE 'Error' END estado,
                        a.`fecha` AS frecepcion,
                        a.`fentrega` AS festimadaentrega,
                        CASE WHEN a.`estado`='F' THEN a.`fechaaccion` 
                        ELSE a.`estado` END frealentrega,
                        CASE WHEN a.`estado`='F' THEN TIMESTAMPDIFF(HOUR,a.`fecha`,a.`fechaaccion`) 
                        ELSE TIMESTAMPDIFF(HOUR,a.`fecha`,NOW()) END tiempo,
                        (SELECT CASE WHEN aa.`ffin` IS NULL THEN TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),NOW()) ELSE TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),MAX(aa.`ffin`)) END
                        FROM tareassuspendidas aa 
                        WHERE aa.`numorden`=a.`numorden`) tsuspendida
                FROM numeroorden a
                WHERE a.`accion`!='B' AND a.estado!='S' AND (DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%')
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
                    $ttotal=$row["tiempo"]-$row["tsuspendida"];
                    
                    $entrega="";
                    
                    if ($row["frealentrega"]=="P") $entrega="";
                    else $entrega=$row["frealentrega"];

                    $fila=$fila."<tr>
                                    <th scope='row'>".$i."</th>
                                    <td><a href='#' onclick='vercontenidotarea(".$row['numorden'].",".$idusuario.")'>#".$row['numorden']."</a></td>
                                    <td>".$row["tituloorden"]."</td>
                                    <td>".$row["estado"]."</td>
                                    <td>".$row["frecepcion"]."</td>
                                    <td>".$row["festimadaentrega"]."</td>
                                    <td>". $entrega ."</td>
                                    <td>".$row["tiempo"]." hs</td>
                                    <td>".$row["tsuspendida"]." hs</td>
                                    <td>".$ttotal." hs</td>
                                </tr>";
                    $i=$i+1;
                }
            }

            desconectar($con);   
        
            $tablageneral="";

            if ($fila!="") $tablageneral= $encabezado."".$fila."".$pie;
            else $tablageneral= $encabezado."<tr><td style='text-align: center;' colspan='10'>Sin datos para mostrar</td></tr>".$pie;

        //FIN CONSULTA QUE TRAE LISTADO DE ORDENES Y SITUACIONES EN LAS QUE SE ENCUENTRAN

        //TABLA QUE MUESTRA TOTALES GENERALES AGRUPADOS POR MECANICOS DE LA ANTERIOR TABLA
            $encabezadomeca="
                            <table class='table table-hover' id='miTabla'>
                                <thead>
                                <tr>
                                    <th scope='col'>&nbsp;</th>
                                    <th scope='col'>Mecanico</th>
                                    <th scope='col'>Total Ordenes</th>
                                    <th scope='col'>Total Tareas</th>
                                    <th scope='col'>Total Tiempo Tarea (hh:mm)</th>
                                    <th scope='col'>Total Suspendida Tarea (hh:mm)</th>
                                    <th scope='col'>Total Tiempo Productivo (hh:mm)</th>
                                </tr>
                                </thead>
                                <tbody>";

            $piemeca="</tbody>
                    </table>";

            $sql="SELECT b.`idempleado`,c.`urlfoto`,CONCAT(c.`apellido`,', ',c.`nombre`) AS mecanico,COUNT(a.`numorden`) AS tordenes,
                        COUNT(b.`idtarea`) AS ttareas,SUM(ROUND(TIMESTAMPDIFF(MINUTE,b.`fechaini`,b.`fechaobs`)/60,2)) AS ttiempo,
                        (SELECT CASE WHEN aa.`ffin` IS NULL THEN 
                                        ROUND(TIMESTAMPDIFF(MINUTE,MIN(aa.`fini`),NOW())/60,2) 
                                ELSE 
                                        ROUND(TIMESTAMPDIFF(MINUTE,MIN(aa.`fini`),MAX(aa.`ffin`))/60,2)
                                END
                        FROM tareassuspendidas aa 
                        WHERE aa.`numorden`=a.`numorden` AND aa.idtarea=b.`idtarea`) tsuspendida
                    FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                                INNER JOIN tareas d ON (b.`idtarea`=d.`idtarea` AND d.`accion`!='B')
                    WHERE a.`accion`!='B' AND b.`estado`='F' AND (DATE(a.fentrega) BETWEEN '".$fini."' AND '".$ffin."') AND 
                        (a.`numorden` LIKE '%".$num."%') AND (d.`descripciontarea` LIKE '%".$titulo."%') 
                        AND (CONCAT(c.`apellido`,',',c.`nombre`) LIKE '%".$emp."%')
                    GROUP BY 1,2
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
                    if (strlen($row["idempleado"])>0)
                    {
                        $tiempo=$row['ttiempo']-$row['tsuspendida'];
                        $filameca=$filameca."<tr class='fila' style='text-align: center;'>
                                                <th scope='row'>".$row['mecanico']."</th>
                                                <td>
                                                    <img src='assets/img/".$row['urlfoto']."' alt='Profile'  width='48' height='64'>
                                                </td>
                                                <td>".$row['tordenes']."</td>
                                                <td>".$row['ttareas']."</td>
                                                <td>".$row['ttiempo']."</td>
                                                <td>".$row['tsuspendida']."</td>
                                                <td>".$tiempo."</td>
                                            </tr>";
                    }
                }
            }

            desconectar($con);   
            
            $tablameca="";

            if ($filameca!="") $tablameca=$encabezadomeca."".$filameca."".$piemeca;
            else $tablameca=$encabezadomeca."<tr><td style='text-align: center;' colspan='7'>Sin datos para mostrar</td></tr>".$piemeca;

        //FIN TABLA QUE MUESTRA TOTALES GENERALES DE LA ANTERIOR TABLA

        $tablas="<div class='card'>
                    &nbsp;
                    <div class='card-body'>
                        <!-- Vertical Pills Tabs -->
                        <div class='d-flex align-items-start'>
                            <div class='nav flex-column nav-pills me-3' id='v-pills-tab' role='tablist' aria-orientation='vertical'>
                            <button class='nav-link active' id='v-pills-home-tab' data-bs-toggle='pill' data-bs-target='#v-pills-home' type='button' role='tab' aria-controls='v-pills-home' aria-selected='true'>General</button>
                            <button class='nav-link' id='v-pills-profile-tab' data-bs-toggle='pill' data-bs-target='#v-pills-profile' type='button' role='tab' aria-controls='v-pills-profile' aria-selected='false'>Por Mecanico</button>
                            </div>
                            <div class='tab-content' id='v-pills-tabContent'>
                            <div class='tab-pane fade show active' id='v-pills-home' role='tabpanel' aria-labelledby='v-pills-home-tab'>
                                ".$tablageneral."
                            </div>
                            <div class='tab-pane fade' id='v-pills-profile' role='tabpanel' aria-labelledby='v-pills-profile-tab'>
                                ".$tablameca."
                            </div>
                            </div>
                        </div>
                        <!-- End Vertical Pills Tabs -->
                    </div>
                </div>";

        echo $tablas;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='10'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
   
?>