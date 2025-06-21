<?php
  session_start();

  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
  
  if (isset($_SESSION['id']))
  {  
    $idusuario=$_SESSION['id'];
   // $estado=$_GET['estado'];
    $numorden=$_GET['num'];
    $idempleado=$_GET['id'];
    
    //echo "SE TIENE QUE TRAE TODAS LAS TAREAS DE LA ORDEN=>".$numorden." REALIZADAS POR EL MECANICO=>".$idempleado;
    
    //TRAIGO TODAS LAS TAREAS QUE TIENE EL MECANICO EN LA ORDEN
   /* if ($estado=="F")
    {
        $sql="SELECT a.numorden,a.`tituloorden` AS descripcion,'Orden disponible para su tratamiento' AS observacion, a.`fecha` AS fini,
                CASE WHEN a.fecha IS NULL THEN '' ELSE a.fecha END ffin, 
                TIMESTAMPDIFF(MINUTE,a.fecha,a.fecha) AS tiempo,
                'F' AS estado
                FROM numeroorden a WHERE a.`numorden`=".$numorden."
                UNION
                SELECT b.idtarea,c.descripciontarea AS descripcion,b.observacion,b.fechaini AS fini,
                CASE WHEN b.fechaobs IS NULL THEN '' ELSE b.fechaobs END ffin,
                CASE WHEN b.fechaobs IS NULL THEN '-1' ELSE TIMESTAMPDIFF(MINUTE,b.fechaini,b.fechaobs) END tiempo,
                b.estado
                FROM afectadostareas b INNER JOIN tareas c ON (b.idtarea=c.idtarea AND c.accion!='B')
                WHERE b.numorden=".$numorden." AND b.idempleado=".$idempleado."
                ORDER BY 4;";
    }
    else
    {*/
        $sql="SELECT a.numorden,'' AS idtarea,a.`tituloorden` AS descripcion,'Orden disponible para su tratamiento' AS observacion, a.`fecha` AS fini,
                CASE WHEN a.fecha IS NULL THEN '' ELSE a.fecha END ffin, 
                TIMESTAMPDIFF(MINUTE,a.fecha,a.fecha) AS tiempo,
                'F' AS estado,
                '' AS suspendida
                FROM numeroorden a WHERE a.`numorden`=".$numorden."
                UNION
                SELECT b.numorden,b.idtarea,c.descripciontarea AS descripcion,b.observacion,b.fechaini AS fini,
                CASE WHEN b.fechaobs IS NULL THEN '' ELSE b.fechaobs END ffin,
                CASE WHEN b.fechaobs IS NULL THEN '-1' ELSE TIMESTAMPDIFF(MINUTE,b.fechaini,b.fechaobs) END tiempo,
                b.estado,
                CASE WHEN (SELECT aa.suspendida FROM tareassuspendidas aa WHERE aa.numorden=".$numorden." AND aa.idtarea=b.idtarea) IN ('S') THEN 'S' ELSE b.estado END suspendida
                FROM afectadostareas b INNER JOIN tareas c ON (b.idtarea=c.idtarea AND c.accion!='B')
                WHERE b.numorden=".$numorden." AND b.idempleado=".$idempleado."
                ORDER BY 5;";
   // }

    $con=conectar();

    $result = $con->query($sql);

    if (!$result) 
    {
      die('Invalid query: ' . $con->error);
    }

    if (!$result) 
    {
      die('Invalid query: ' . $mysqli->error);
    }
    else
    {
        $i=1;
        $fila="";
        while($row = mysqli_fetch_array($result))
        {
            $tmp="";
            if ($row['tiempo']<0) 
            {
              if ($row['suspendida']=="S") $tmp="Suspendida";
              else $tmp="En proceso";
            }
            else 
            {
              $tmp=$row['tiempo']." min";
            }

            if ($row['suspendida']=="S")
            {
                $fila=$fila."<tr class='table-warning'>
                            <th scope='row'>".$i."</th>
                            <td>".$row['descripcion']."</td>
                            <td>".$row['observacion']."</td>
                            <td>".$row['fini']."</td>
                            <td>".$row['ffin']."</td>
                            <td>".$tmp."</td>
                        </tr>";
            }
            else
            {
              if ($row['estado']=="P")
              {
                  $fila=$fila."<tr class='table-info'>
                              <th scope='row'>".$i."</th>
                              <td>".$row['descripcion']."</td>
                              <td>".$row['observacion']."</td>
                              <td>".$row['fini']."</td>
                              <td>".$row['ffin']."</td>
                              <td>".$tmp."</td>
                          </tr>";
              }
              else
              {
                  $fila=$fila."<tr>
                              <th scope='row'>".$i."</th>
                              <td>".$row['descripcion']."</td>
                              <td>".$row['observacion']."</td>
                              <td>".$row['fini']."</td>
                              <td>".$row['ffin']."</td>
                              <td>".$tmp."</td>
                          </tr>";
              }
            }
            $i=$i+1;        
        }
    
        $encabezado="<h5 class='card-title'>Tareas en las que participo el mecanico y sus tiempos</h5>
                    <!-- Table with hoverable rows -->
                    <table class='table table-hover'>
                    <thead>
                        <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Descripción</th>
                        <th scope='col'>Observación</th>
                        <th scope='col'>Fecha inicio</th>
                        <th scope='col'>Fecha fin</th>
                        <th scope='col'>Tiempo</th>
                        </tr>
                    </thead>
                    <tbody>";
        $pie="</tbody>
                </table>
                <!-- End Table with hoverable rows -->";
        
        echo $encabezado."".$fila."".$pie;
    }
        
  }
  else
  {
    echo "<script> window.location.href='index.html'</script>";
  }   
?>