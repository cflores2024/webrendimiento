<?php
include "configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

if (isset($_GET["ver"]))
{  
    $ver=$_GET["ver"];

    $encabezado="<!-- Table with stripped rows -->
                <table class='table table-borderless datatable'>
                      <thead>
                        <tr>
                          <th scope='col'>Orden</th>
                          <th scope='col'>Titulo Orden</th>
                          <th scope='col' data-type='date' data-format='MM/DD/YYYY'>Fecha inicio</th>
                          <!--th scope='col'>Tiempo</th-->
                          <th scope='col'>Avance %</th>
                          <th scope='col'>Afectados</th>
                          <th scope='col'>Estado</th>
                          <th scope='col'>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>";
/*
  $con=conectar();

    $sql="-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
          SELECT a.`numorden`,b.idpersonadisp AS idempleado,b.`tituloorden`,0 AS tiempo,b.fecha,
          (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
          (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
          'Orden disponible para su tratamiento' AS descripciontarea,
          'I' AS estado,
          0 AS demorada,
          b.numchasis,
          (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=b.numchasis AND tt.numorden!=a.`numorden`) AS historial
          FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
          GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.idpersonadisp,b.numchasis
          UNION
          -- ORDENES DISPONIBLES
          SELECT xx2.`numorden`,xx2.`idpersonadisp` AS idempleado,xx2.`tituloorden`,
          0 AS tiempo,
          xx2.fecha,
          zz1.urlfoto AS foto, 
          CONCAT(zz1.`apellido`,', ',zz1.`nombre`) empleado,
          'Orden disponible para su tratamiento' AS descripciontarea,
          'D' AS estado,
          0 AS demorada,
          xx2.numchasis,
          (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=xx2.numchasis AND tt.numorden!=xx2.`numorden`) AS historial          
          FROM numeroorden xx2 INNER JOIN personas zz1 ON (xx2.idpersonadisp=zz1.`idpersona` AND zz1.`accion`!='B')
          WHERE xx2.accion!='B' AND xx2.estado='D' AND xx2.`numorden` NOT IN  
          (
          SELECT aa.`numorden`
          FROM autorizaraccorden aa
          WHERE aa.`accion`!='B' AND aa.`estado` IN ('P','A')
          )
          UNION
          -- ORDENES PENDIENTES
          SELECT xx2.`numorden`,yy.idpersona AS idempleado,xx2.`tituloorden`,
          TIMESTAMPDIFF(MINUTE, xx2.`fecha`,xx2.fentrega) AS tiempo,
          xx2.fecha,
          yy.`urlfoto` AS foto, 
          CONCAT(yy.apellido,',',yy.nombre) AS empleado,
          'Orden pendiente para su tratamiento' AS `descripciontarea`,
          'P' AS estado,
          DATEDIFF(xx2.`fentrega`,CURDATE())*-1 AS demorada,
          xx2.numchasis,
          (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=xx2.numchasis AND tt.numorden!=xx2.`numorden`) AS historial
          FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
              INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
          WHERE xx2.accion!='B' AND zz.estado='P'
          UNION
          -- ORDENES AUTORIZAS
          SELECT xx2.`numorden`,yy.idpersona AS idempleado,xx2.`tituloorden`,
          TIMESTAMPDIFF(MINUTE, xx2.`fecha`,xx2.fentrega) AS tiempo,
          xx2.fecha,
          yy.`urlfoto` AS foto, 
          CONCAT(yy.apellido,',',yy.nombre) AS empleado,
          (SELECT t.`descripciontarea` 
           FROM tareas t 
           WHERE t.`accion`!='B' AND t.`idtarea`=aa.idtarea
           GROUP BY 1) AS `descripciontarea`,
          -- aa.idtarea as realizatarea,
          xx2.`estado`,
          CASE WHEN xx2.estado='F' THEN 0 ELSE DATEDIFF(xx2.`fentrega`,CURDATE())*-1 END demorada,
          xx2.numchasis,
          (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=xx2.numchasis AND tt.numorden!=xx2.`numorden`) AS historial
          FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
              INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
              LEFT JOIN afectadostareas	aa ON (aa.numorden=xx2.numorden AND aa.idempleado=yy.idpersona)
          WHERE xx2.accion!='B' AND zz.estado='A'
          ORDER BY 1,2;";
 
  //echo $sql;

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
    $lsfotos="";
    $orden="";
    $titulo="";
    $fecha="";
    $tiempo="";
    $fila="";
    $estadoorden="";
    $color="";
    $numchasis="";
    $canttareas=0;
    $demorada=0;
  
    while($row = mysqli_fetch_array($result))
    {
      if ($orden==$row['numorden'])
      {
          if (strlen($row['foto'])>0)
          {
            if ($row['estado']=="P") //EN PROGRESO
            {
               $lsfotos=$lsfotos."<a href='#'><img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle activo' width='35' height='35' title='".$row['empleado'].": ".$row['descripciontarea']."'></a>";
            }
            else
            {
               $lsfotos=$lsfotos."<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='25' height='25' title='".$row['empleado'].": ".$row['descripciontarea']."'>";
            }
          }
          else
          {
              $lsfotos=$lsfotos."&nbsp;";
          }
      
          $fecha=$row['fecha'];
          $tiempo=$row['tiempo'];
          $estadoorden=$row['estado'];
          $demorada=$row['demorada'];
      }
      else
      {
          if (strlen($orden)>0)
          {
              $fila="
                      <tr>
                          <th scope='row'><a href='#' onclick='vercontenidotarea(\"$orden\",\"$id\")'>#".$orden."</a></th>
                          <td>".$titulo."</td>
                          <td>".$fecha."</td>
                          <!--td>".$tiempo." min</td-->";
              
              //ANALIZO PORCENTAJE DE AVANCE DE LA ORDEN
              $canttareas=AvanceOrden($orden);

              $fila=$fila." <td>
                              <div class='progress'>
                                <div class='progress-bar' role='progressbar' style='width: ".$canttareas."%' aria-valuenow='".$canttareas."' aria-valuemin='0' aria-valuemax='".$totaltareas."'>".$canttareas."%</div>
                              </div>
                            </td>";
           
              $fila=$fila."<td>".$lsfotos."</td>";
              
              if ($demorada>0) $estadoorden="M"; //ORDEN DEMORADA

              switch ($estadoorden)
              {
                case "P": //ORDEN EN PROCESO - VERDE
                        $color="<span class='badge bg-success'>En proceso</span>";
                break;
                case "F": //ORDEN FINALIZADA - AZUL
                        $color="<span class='badge bg-primary'>Finalizada</span>";
                break;
                case "D": //ORDEN DISPONIBLE A SER TRATADA - AMARILLO
                        $color="<span class='badge bg-warning'>Disponible</span>";
                break;
                default: //ORDEN DEMORADA - ROJO
                        $color="<span class='badge bg-danger'>Atrazado</span>";
                break;
              }

              $fila=$fila ."<td>".$color."</td>";
              
              if ($estadoorden=="F") 
              {
                $fila=$fila."<td><a href='#'>
                                  <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 2' onclick='verhistorial(\"$numchasis\")'>
                                </a></td></tr>";
              }
              else 
              {
                if ($tienehisto<=0) $fila=$fila."<td>&nbsp</td></tr>";
                else $fila=$fila."<td><a href='#'>
                                  <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 2' onclick='verhistorial(\"$numchasis\")'>
                                </a></td></tr>";                       
              }
          }

          if (strlen($orden)>0) 
          {
            
            echo $fila;

            $fila="";
          }
          
          $orden=$row['numorden'];
          $titulo=$row['tituloorden'];
          $fecha=$row['fecha'];
          $tiempo=$row['tiempo'];
          $estadoorden=$row['estado'];
          $tienehisto=$row['historial'];
          $numchasis=$row['numchasis'];
          $demorada=$row['demorada'];
                          
          if (strlen($row['foto'])>0)
          {
            if ($estadoorden=="P") //EN PROGRESO
            {
              $lsfotos="<a href='#'><img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle activo' width='35' height='35' title='".$row['empleado'].": ".$row['descripciontarea']."'></a>";
            }
            else
            {
              $lsfotos="<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='25' height='25' title='".$row['empleado'].": ".$row['descripciontarea']."'>";
            }
          }
          else
          {
            $lsfotos="&nbsp;";
          }
      }   
    }

    if (strlen($orden)>0)
    {
      $fila="
              <tr>
                  <th scope='row'><a href='#' onclick='vercontenidotarea(\"$orden\",\"$id\")'>#".$orden."</a></th>
                  <td>".$titulo."</td>
                  <td>".$fecha."</td>
                  <!--td>".$tiempo." min</td-->";

      //ANALIZO PORCENTAJE DE AVANCE DE LA ORDEN
      $canttareas=AvanceOrden($orden);
      
                $fila=$fila." <td>
                                <div class='progress'>
                                  <div class='progress-bar' role='progressbar' style='width: ".$canttareas."%' aria-valuenow='".$canttareas."' aria-valuemin='0' aria-valuemax='".$totaltareas."'>".$canttareas."%</div>
                                </div>
                              </td>";
      
      $fila=$fila."<td>".$lsfotos."</td>";

      switch ($estadoorden)
      {
        case "P": //ORDEN EN PROCESO - VERDE
                $color="<span class='badge bg-success'>En proceso</span>";
        break;
        case "F": //ORDEN FINALIZADA - AZUL
                $color="<span class='badge bg-primary'>Finalizada</span>";
        break;
        case "D": //ORDEN DISPONIBLE A SER TRATADA - AMARILLO
                $color="<span class='badge bg-warning'>Disponible</span>";
        break;
        default: //ORDEN DEMORADA - ROJO
                $color="<span class='badge bg-danger'>Atrazado</span>";
        break;
      }

      $fila=$fila ."<td>".$color."</td>";     

      if ($estadoorden=="F") 
      {
        $fila=$fila."<td><a href='#'>
                          <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 2' onclick='verhistorial(\"$numchasis\")'>
                        </a></td></tr>";
      }
      else 
      {
        if ($tienehisto<=0) $fila=$fila."<td>&nbsp</td></tr>";
        else $fila=$fila."<td><a href='#'>
                          <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 2' onclick='verhistorial(\"$numchasis\")'>
                        </a></td></tr>";                       
      }
    }
    else 
    {
      $fila="<tr><td colspan='6' style='text-align: center;'>Sin información a mostrar</td></tr>";   
    }
  }

  desconectar($con);
*/
   $fila="<tr><td colspan='6' style='text-align: center;'>Sin información a mostrar</td></tr>";

            $pie="</tbody>
                </table>
                <!-- End Table with stripped rows -->";

    switch ($ver)
    {
        case "P":
                    $info="SE MUESTRA LA TABLA DE ORDENES EN PROCESO";
            break;
        case "D":
                    //$info="SE MUESTRA LA TABLA DE ORDENES DISPONIBLES";
                    $info=$encabezado."".$fila."".$pie;
            break;
        case "F":
                    $info="SE MUESTRA LA TABLA DE ORDENES FINALIZADAS";
            break;
    }
}
else
{
    $info="Error. No se recibio correctamente el número de orden!!!";
}

echo $info;
?>