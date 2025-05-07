<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];      
  }
  else
  {
    header('Location: index.php');
    exit;
  }   
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SMATE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <!--link href="https://fonts.gstatic.com" rel="preconnect"-->
  <link href="assets/font/Open_Sans.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script>
    function deshabilitaRetroceso()
    {
      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash="";}
    }

    function verorden(num) {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num);
            document.getElementById("lsinfo").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'detalleorden.php?num='+num, false);
        xmlhttp.send();
      }
    }

    function verhistorial(num) {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero chasis='+num);
            document.getElementById("lsinfo").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'historialorden.php?num='+num+'&ver=N', false);
        xmlhttp.send();
      }
    }

    function vertabla(num)
    {
      //alert("Se muestra historial de la orden " + num);

      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num);
            document.getElementById("tbldetalleorden").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'vertablatareas.php?num='+num, false);
        xmlhttp.send();
      }
    }
  </script>

  <style>
    .activo {
      outline: 3px solid green;
      box-shadow:0 0 15px green;
    }
  </style>
</head>

<body onload="deshabilitaRetroceso()">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
        <!--img src="assets/img/logo.png" alt=""-->
        <span class="d-none d-lg-block">SAM</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <strong>Gestión</strong>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/<?php echo $foto; ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $nombrecorto; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $apenomb; ?></h6>
              <span><?php echo $tipousu; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="crudpersonal.php?idpersona=<?php echo $id; ?>&accion=M">
                <i class="bi bi-person"></i>
                <span>Mi Perfil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="ayuda.php">
                <i class="bi bi-question-circle"></i>
                <span>Ayuda?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="index.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Session</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include_once ("menu.php"); ?>
  <!-- End Sidebar-->
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Estados de Ordenes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active"><a href="avancestareas.php">Avances en ordenes</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <span id="lsinfo">
      <section class="section">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Estado Tratamiento Ordenes</h5>
                <p>Se muestran todas las ordenes y sus respectivos estados en el tiempo</p>

                <!-- Table with stripped rows -->
                <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">Orden</th>
                          <th scope="col">Titulo Orden</th>
                          <th scope="col" data-type="date" data-format="MM/DD/YYYY">Fecha inicio</th>
                          <!--th scope="col">Tiempo</th-->
                          <th scope="col">Avance %</th>
                          <th scope="col">Afectados</th>
                          <th scope="col">Estado</th>
                          <th scope="col">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
<?php

  $con=conectar();

    $sql="-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
          SELECT a.`numorden`,b.idpersonadisp AS idempleado,b.`tituloorden`,0 AS tiempo,b.fecha,
          (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
          (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
          'Orden disponible para su tratamiento' AS descripciontarea,
          'I' AS estado,
          0 AS demorada
          FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
          GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.fechaentrega
          UNION
          -- ORDENES DISPONIBLES
          SELECT xx2.`numorden`,xx2.`idpersonadisp` AS idempleado,xx2.`tituloorden`,
          0 AS tiempo,
          xx2.fecha,
          zz1.urlfoto AS foto, 
          CONCAT(zz1.`apellido`,', ',zz1.`nombre`) empleado,
          'Orden disponible para su tratamiento' AS descripciontarea,
          'D' AS estado,
          0 AS demorada          
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
          TIMESTAMPDIFF(MINUTE, xx2.`fecha`,xx2.fechaentrega) AS tiempo,
          xx2.fecha,
          yy.`urlfoto` AS foto, 
          CONCAT(yy.apellido,',',yy.nombre) AS empleado,
          'Orden pendiente para su tratamiento' AS `descripciontarea`,
          'P' AS estado,
          DATEDIFF(xx2.`fechaentrega`,CURDATE())*-1 AS demorada

          FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
              INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
          WHERE xx2.accion!='B' AND zz.estado='P'
          UNION
          -- ORDENES AUTORIZAS
          SELECT xx2.`numorden`,yy.idpersona AS idempleado,xx2.`tituloorden`,
          TIMESTAMPDIFF(MINUTE, xx2.`fecha`,xx2.fechaentrega) AS tiempo,
          xx2.fecha,
          yy.`urlfoto` AS foto, 
          CONCAT(yy.apellido,',',yy.nombre) AS empleado,
          (SELECT t.`descripciontarea` 
           FROM tareas t 
           WHERE t.`accion`!='B' AND t.`idtarea`=aa.idtarea
           GROUP BY 1) AS `descripciontarea`,
          -- aa.idtarea as realizatarea,
          xx2.`estado`,
          CASE WHEN xx2.estado='F' then 0 else DATEDIFF(xx2.`fechaentrega`,curdate())*-1 end demorada
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
                          <th scope='row'><a href='#'>#".$orden."</a></th>
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
              
              if ($tienehisto<=0) $fila=$fila."<td>&nbsp</td></tr>";
              else $fila=$fila."<td><a href='#'>
                                  <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 1' onclick='verhistorial(\"$numchasis\")'>
                                </a></td></tr>";            
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
                  <th scope='row'><a href='#'>#".$orden."</a></th>
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

      if ($tienehisto<=0) $fila=$fila."<td>&nbsp</td></tr>";
      else $fila=$fila."<td><a href='#'>
                          <img src='assets/img/tarea_historia.png' data-bs-toggle='tooltip' data-bs-placement='top' title='Ver Historial Patente 2' onclick='verhistorial(\"$numchasis\")'>
                        </a></td></tr>";  

    }
    else 
    {
      //$fila="<tr><td colspan='7' style='text-align: center;'>Sin información a mostrar</td></tr>";   
      $fila="<tr><td colspan='6' style='text-align: center;'>Sin información a mostrar</td></tr>";   
    }
  }

  desconectar($con);

  echo $fila;
?>
                      </tbody>
                </table>
                <!-- End Table with stripped rows -->
              </div>
            </div>

          </div>
        </div>
      </section>
    </span>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

<?php
  $totaltareas=0;

  function AvanceOrden($num)
  {
    //SE DETERMINA LA CANTIDAD DE TAREAS QUE TIENE EN CURSO VS FINALIZADAS
    GLOBAL $totaltareas;
    $totalfin=0;

    $sql = "SELECT COUNT(a.`idtarea`) AS totaltareas,(SELECT COUNT(b.`idtarea`) 
                                                    FROM detalleorden b 
                                                    WHERE b.`accion`!='B' AND b.`estado`='F' AND b.`numeroorden`=a.numeroorden) AS totalfin
          FROM detalleorden a
          WHERE a.`accion`!='B' AND a.`numeroorden`=". $num;

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
          while($row = mysqli_fetch_array($result))
          {
                $totaltareas=$row['totaltareas'];
                $totalfin=$row['totalfin'];
          }

          desconectar($con);
    }

    if ($totalfin==$totaltareas) $totalfin=100;
    else $totalfin=$totalfin*10;

    return ($totalfin);
  }
?>