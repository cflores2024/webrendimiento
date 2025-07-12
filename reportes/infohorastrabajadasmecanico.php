<?php
    include "../configuracion/conexion.php";

    $encabezado="<table class='table table-hover'>
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Orden</th>
                        <th scope='col'>Titulo</th>
                        <th scope='col'>F. Recepción</th>
                        <th scope='col'>Empleado</th>
                        <th scope='col'>Tarea</th>
                        <th scope='col'>Estado</th>
                        <th scope='col'>F. Inicio</th>
                        <th scope='col'>F. Fin</th>
                        <th scope='col'>T. Tarea</th>
                        <th scope='col'>T. Sup</th>
                        <th scope='col'>T. Total</th>
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
  
        $sql="SELECT a.`numorden`,a.`estado`,a.fecha,b.`idpersona`,
                    CASE WHEN c.`idtarea` IS NULL THEN '' ELSE (SELECT yy.descripciontarea FROM tareas yy WHERE yy.accion!='B' AND yy.idtarea=c.idtarea) END tarea,
                    CASE WHEN c.`idtarea` IS NULL THEN '' ELSE c.estado END estadotarea,
                    CASE WHEN c.`idtarea` IS NULL THEN '' ELSE c.`fechaini` END fini,
                    CASE WHEN c.`idtarea` IS NULL THEN '' ELSE (CASE WHEN c.`fechaobs` IS NULL THEN CONCAT(DATE(NOW()),' 18:59:00') ELSE c.fechaobs END) END ffin,
                    CASE WHEN c.`idtarea` IS NULL THEN 0 ELSE (CASE WHEN c.`fechaobs` IS NULL THEN ROUND(TIMESTAMPDIFF(MINUTE,b.`fechaautoriza`,CONCAT(DATE(NOW()),' 18:59:00'))/60,2) ELSE ROUND(TIMESTAMPDIFF(MINUTE,b.`fechaautoriza`,c.`fechaobs`)/60,2) END) END ttiempo,
                    a.tituloorden,
                    (SELECT CONCAT(xx.apellido,', ',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersona) AS apenomb,
                    CASE WHEN c.`idtarea` IS NULL THEN 0 ELSE (CASE WHEN d.fini IS NULL THEN 0 ELSE ROUND(TIMESTAMPDIFF(MINUTE,d.fini,d.ffin)/60,2) END) END tsuspendida
            FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden`)
                               LEFT JOIN afectadostareas c ON (c.`numorden`=a.`numorden` AND c.`idempleado`=b.`idpersona`)
                               LEFT JOIN tareassuspendidas d ON (d.numorden=a.numorden AND d.idtarea=c.idtarea AND d.idempleadofini=c.idempleado) 
            WHERE a.`accion`!='B' AND a.estado!='S' AND (DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."') AND (a.`numorden` LIKE '%".$num."%') AND (a.`tituloorden` LIKE '%".$titulo."%')
            ORDER BY 3,1;";

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
                $ttotal=$row["ttiempo"]-$row["tsuspendida"];

                $fila=$fila."<tr>
                                <th scope='row'>".$i."</th>
                                <td>".$row["numorden"]."</td>
                                <td>".$row["tituloorden"]."</td>
                                <td>".$row["fecha"]."</td>
                                <td>".$row["apenomb"]."</td>
                                <td>".$row["tarea"]."</td>
                                <td>".$row["estadotarea"]."</td>
                                <td>".$row["fini"]."</td>
                                <td>".$row["ffin"]."</td>
                                <td>".$row["ttiempo"]."</td>
                                <td>".$row["tsuspendida"]."</td>
                                <td>".$ttotal."</td>
                            </tr>";
                 $i=$i+1;
            }
        }

        desconectar($con);   
      
        if ($fila!="") echo $encabezado."".$fila."".$pie;
        else echo $encabezado."<tr><td style='text-align: center;' colspan='12'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='12'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
?>