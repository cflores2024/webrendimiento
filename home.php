<?php 
  session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['nombreapp']; ?></title>
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

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script>
    
    function filtrar() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        //alert ('LLEVANDO FECHAS FINI '+fini+' Y LA FFIN '+ffin);
        window.location.href="home.php?txtfini="+fini+"&txtffin="+ffin;
      }
    }

    function limpiar() 
    {
      window.location.href="home.php";
    }

    function deshabilitaRetroceso()
    {
      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash="";}
    }
  </script>
</head>

<body onload="deshabilitaRetroceso()">
<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
 
  function obtenermes($opcion,$mesdeseado)
  {
    $resp="";
    $mesActual = date('n'); // Obtiene el número del mes actual
    $mesesabreviados = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $mesescompleto = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
   
    if ($mesdeseado==1) $mesActual=$mesActual-1; //PERMITE OBTENER EL MES ANTERIOR AL ACTUAL
     
    if ($opcion=="C")
    {//NOMBRE CORTO DEL MES  
      $resp=$mesesabreviados[$mesActual - 1]; // Resta 1
    }
    else
    {//NOMBRE LARGO DEL MES
      $resp=$mesescompleto[$mesActual - 1]; // Resta 1
    }
    
    //$resp=$mesActual;

    return $resp;
  }

  if (isset($_SESSION['id']))
  { 
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
 
    if ((isset($_GET['txtfini']))&&(isset($_GET['txtffin'])))
    {  
      $txtfini=$_GET['txtfini'];
      $txtffin=$_GET['txtffin'];
    }
    else
    {
      //$txtfini=date("Y-m-d",strtotime($ffin . "-5 days"));
      $txtfini=$txtffin=date("Y-m-d");
    }

    $ffin=$txtffin;// date("Y-m-d H:i:s");
    $ffineti=$txtffin; //date("Y-m-d")
    $fini=$txtfini;// date("Y-m-d H:i:s",strtotime($ffin . "-5 days"));
    $finieti=$txtfini;// date("d-m-Y",strtotime($ffin . "-5 days"));
    $finimes=$fini;//date("Y-m-d H:i:s",strtotime($ffin . "-5 month"));
    $finimeseti=$fini;//date("d-m-Y",strtotime($ffin . "- 5 month"));
    $anioActual = date("Y",strtotime($ffin)); //date('Y'); // Obtiene el número del año actual
    $mesact=date("n",strtotime($ffin)); //date("n");

    $fechahoy=$txtfini;//date("Y-m-d");
    $fechaayer=date("Y-m-d", strtotime($fechahoy. "-1 day")); 
    $fecha7diasantes=date("Y-m-d", strtotime($fechahoy. "-7 day")); 
    $anioC=date("y",strtotime($ffin)); //date("y");
    $anioL=$anioActual;// date("Y");
    $mes=date("m",strtotime($ffin))*1;//date("m")*1;
    $mesviejo=date("m", strtotime($fechahoy . "- 3 month"))*1;
    
    $lsdias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $posdia=date('w');
    $nombdia=$lsdias[$posdia];
  }
  else
  {
    echo "<script> window.location.href='index.html'</script>";
  }   
?>


  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
        <!--img src="assets/img/logo.png" alt=""-->
        <span class="d-none d-lg-block"><?php echo $_SESSION['nombreapp']; ?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <strong>Sistema De Mantenimiento Técnico</strong>
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
      <h1>Panel metricas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Metricas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

       <!-- FILTROS POR FECHAS -->
        <div class="col-lg-12">
          <?php    
            echo "<div class='card'>
                    <div class='card-body'>
                      &nbsp;
                      <div class='accordion' id='accordionExample'>
                        <div class='accordion-item'>
                          <h2 class='accordion-header' id='headingTwo'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo' aria-expanded='false' aria-controls='collapseTwo'>
                              Buscador
                            </button>
                          </h2>
                          <div id='collapseTwo' class='accordion-collapse collapse' aria-labelledby='headingTwo' data-bs-parent='#accordionExample'>
                            <div class='accordion-body'>
                              <form class='row g-3'>
                                <div class='col-md-6'>
                                  <label for='txtfini' class='form-label'>Fecha Inicio</label>
                                  <input type='date' class='form-control' id='txtfini' value='".$txtfini."'>
                                </div>
                                <div class='col-md-6'>
                                  <label for='txtffin' class='form-label'>Fecha Fin</label>
                                  <input type='date' class='form-control' id='txtffin' value='".$txtffin."'>
                                </div>   
                                <div class='text-center'>
                                  <button type='button' class='btn btn-secondary' onclick='limpiar()'>Limpiar</button>
                                  <button type='button' class='btn btn-primary' onclick='filtrar()'>Filtrar</button>
                                </div>           
                              </form>  
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                ";
          ?>
        </div>
      <!-- FIN FILTROS POR FECHAS -->
    
      <!-- TOTAL DE ORDENES -->
        <div class="col-lg-3">
          <div class="card info-card sales-card">
              <?php
                $cantact=0;
                $sql = "SELECT a.`numorden`,COUNT(a.`numorden`) AS act
                         FROM numeroorden a INNER JOIN afectadostareas b ON (a.numorden=b.numorden)
                         WHERE a.`accion`!='B' AND a.estado!='S' AND DATE(a.`fecha`) BETWEEN '".$txtfini."' AND '".$txtffin."'
                         GROUP BY 1;";

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

                  while($row = mysqli_fetch_array($result))
                  {
                      $cantact=$cantact+1;
                  }
                }

                desconectar($con);
              ?>

            <div class="card-body">
              <h5 class="card-title"><a href="homexfiltros.php?op=TO">Total Ordenes</a></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-car-front"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- FIN TOTAL DE ORDENES X MES -->
    
      <!-- ORDENES DEMORAS-->
        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title"><a href="homexfiltros.php?op=DE">Demoradas</a></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-clock"></i>
                </div>
                <div class="ps-3">
                <?php
                
                  $sql = "SELECT COUNT(a.`numorden`) AS demoradaact
                          FROM numeroorden a
                          WHERE a.`accion`!='B' AND a.`estado`!='F' AND DATE(a.`fentrega`)<DATE(a.`fechaaccion`) AND DATE(a.`fecha`) BETWEEN '".$finimes."' AND '".$ffin."';";
                 
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
                    while($row = mysqli_fetch_array($result))
                    {
                        $cantact=$row['demoradaact'];
                    }
                  }

                  desconectar($con);
                ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                 
                </div>
              </div>
            </div>

            </div>

        </div>
      <!-- FIN ORDENES DEMORAS-->
    
      <!-- ORDENES TERMINADAS-->    
        <div class="col-lg-3">

          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title"><a href="homexfiltros.php?op=TE">Terminadas</a></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>
                <div class="ps-3">

                  <?php
                
                    $cantact=0;

                    $sql = "SELECT COUNT(a.`numorden`) AS act
                            FROM numeroorden a
                            WHERE a.`accion`!='B' AND a.estado='F' AND a.`fentrega` BETWEEN '".$txtfini."' AND '".$txtffin."';";

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
                      while($row = mysqli_fetch_array($result))
                      {
                          $cantact=$row['act'];
                      }
                    }

                    desconectar($con);
                  ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- FIN ORDENES TERMINADAS-->    
    
      <!-- ORDENES EN CURSO-->     
        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title"><a href="homexfiltros.php?op=EC">En curso</a> <span>| Hoy</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-headset"></i>
                </div>
                <div class="ps-3">
                <?php
                
                $cantact=100;

                $sql = "SELECT COUNT(a.`numorden`) AS act
                        FROM numeroorden a
                        WHERE a.`accion`!='B' AND a.estado='P' AND DATE(a.`fentrega`) BETWEEN '".$txtfini."' AND '".$txtffin."';";

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
                  while($row = mysqli_fetch_array($result))
                  {
                      $cantact=$row['act'];
                  }
                }

                desconectar($con);
              ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                </div>
              </div>
            </div>

            </div>

          </div> 
        </div>
      <!-- FIN ORDENES EN CURSO-->
    </section>

    <section class="section dashboard">
      <div class="row">

        <!-- TOTAL HORAS/MINUTOS TRABAJADOS POR LOS MECANICOS -->
          <div class="col-lg-6">
            <div class="card info-card customers-card">
              <?php
                $ttiempo=0;
    
                $sql="SELECT c.idtarea,CASE WHEN c.`idtarea` IS NULL THEN 0 ELSE (CASE WHEN c.`fechaobs` IS NULL THEN TIMESTAMPDIFF(HOUR,b.`fechaautoriza`,NOW()) ELSE TIMESTAMPDIFF(HOUR,b.`fechaautoriza`,c.`fechaobs`) END) END ttiempo,
                            (SELECT CASE WHEN aa.`ffin` IS NULL THEN 
                                                          TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),NOW()) 
                                                  ELSE 
                                                          TIMESTAMPDIFF(HOUR,MIN(aa.`fini`),MAX(aa.`ffin`)) 
                                                  END
                                          FROM tareassuspendidas aa 
                                          WHERE aa.`numorden`=c.`numorden` AND aa.idtarea=c.`idtarea`) tsuspendida
                      FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden`)
                              LEFT JOIN afectadostareas c ON (c.`numorden`=a.`numorden` AND c.`idempleado`=b.`idpersona`)
                              LEFT JOIN tareassuspendidas d ON (d.numorden=a.numorden AND d.idtarea=c.idtarea AND d.idempleadofini=c.idempleado) 
                      WHERE a.`accion`!='B' AND a.estado!='S' AND DATE(a.`fecha`) BETWEEN '".$txtfini."' AND '".$txtffin."'
                      GROUP BY c.idtarea;";

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
                  while($row = mysqli_fetch_array($result))
                  {
                      $ttiempo=$ttiempo+($row['ttiempo']-$row['tsuspendida']);
                  }
                }

                desconectar($con);

                //echo $ttiempo;
              ?>

              <div class="card-body">
                <h5 class="card-title"><a href="homexfiltros.php?op=TI">Tiempo invertido</a></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>
                      <?php 
                        // Separar la parte entera (horas) y la parte decimal (minutos)
                        $horas = floor($ttiempo);
                        $minutos = round(($ttiempo - $horas) * 60);

                        // Formatear las horas y minutos en formato HH:MM
                        $formato_hhmm = sprintf("%02d:%02d", $horas, $minutos);

                        echo $formato_hhmm; // Salida: 254:14
                      ?>
                    </h6>
                    <h5>Horas Trabajadas Mecanicos</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- FIN TOTAL ORDENES SIN SER ASIGNADAS PARA TRABAJAR -->

        <!-- CANTIDAD DE PERSONAS SIN ACTIVIDAD -->
          <div class="col-lg-6">
            <div class="card info-card customers-card">
              <?php
                $cantsin=0;
                
                $sql = "SELECT COUNT(xx.`idpersona`) AS cantact
                        FROM personas xx
                        WHERE xx.`accion`!='B' AND xx.`idtipopersona`=4 AND xx.`idpersona` NOT IN (SELECT a.`idempleado`
                                                                                                  FROM afectadostareas a
                                                                                                  WHERE (DATE(a.`fechaini`) BETWEEN '".$txtfini."' AND '".$txtffin."')
                                                                                                  GROUP BY 1
                                                                                                  ORDER BY 1);";

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
                  while($row = mysqli_fetch_array($result))
                  {
                      $cantsin=$row['cantact'];
                  }
                }

                desconectar($con);
                
              ?>
              <div class="card-body">
                <h5 class="card-title"><a href="homexfiltros.php?op=EO">Empleados Ociosos</a></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cup-straw"></i>              
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $cantsin; ?></h6>
                    <h5>Empleados Sin Tareas</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- FIN CANTIDAD DE PERSONAS SIN ACTIVIDAD -->
      
      </div>
    </section>
<!--=========================================== FIN DE TARJETAS ===============================================-->


<!--=========================================== INICIO GRAFICAS ===============================================-->

    <section class="section dashboard">
      <div class="row">
      
        <!-- TIEMPO PROMEDIO DE ATENCION DE ORDENES -->
        <div class="col-lg-6">
          <?php
          
            $sql = "SELECT DATE(a.`fecha`) AS fecha,
                          CASE 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Monday' THEN 'Lunes' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Tuesday' THEN 'Martes' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Wednesday' THEN 'Miercoles' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Thursday' THEN 'Jueves' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Friday' THEN 'Viernes' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Saturday' THEN 'Sabado' 
                              WHEN DATE_FORMAT(DATE(a.`fecha`), '%W')='Sunday' THEN 'Domingo' 
                              ELSE 'ERROR' 
                          END AS diasnomb, 
                      ROUND(AVG(TIMESTAMPDIFF(MINUTE,a.`fecha`,b.`fechaautoriza`)/60),0) AS hora
                    FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden`)
                    WHERE a.`accion`!='B' AND a.`estado`='F' AND DATE(a.`fecha`) BETWEEN '".$fini."' AND '".$ffin."'
                    GROUP BY 1,2
                    ORDER BY 1;";

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
                $datos="";
                $dias="";
                $colores="";
                while($row = mysqli_fetch_array($result))
                {
                  $datos=strlen($datos)<=0? $row['hora']: $datos.",".$row['hora'];
                  $dias=strlen($dias)<=0? "'".$row['diasnomb']."'": $dias.",'".$row['diasnomb']."'";
                  $colores=strlen($colores)<=0? "'#33b2df'": $colores.",'#33b2df'";
                }

                desconectar($con);
            }

         // echo $datos."=".$dias."=".$colores;
            echo "<div class='card'>
                  <div class='card-body'>
                    <h5 class='card-title'><a href='homexfiltros.php?op=AO'>Promedio Atención Ordenes Por Dias</a></h5>
                    <div id='barChart'></div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                        new ApexCharts(document.querySelector('#barChart'), {
                            series: [{
                                    name: 'Atención',
                                    data: [".$datos."]
                                    }],
                                    chart: {
                                    height: 350,
                                    type: 'bar',
                                    },
                                    plotOptions: {
                                    bar: {
                                        borderRadius: 0,
                                        dataLabels: {
                                        position: 'center', // top, center, bottom
                                        },
                                    }
                                    },
                                    dataLabels: {
                                    enabled: true,
                                    formatter: function (val) {
                                        return val + 'hs';
                                    },
                                    offsetY: -20,
                                    style: {
                                        fontSize: '12px',
                                        colors: ['#304758']
                                    }
                                    },
                                    
                                    xaxis: {
                                    categories: [".$dias."],
                                    position: 'top',
                                    axisBorder: {
                                        show: false
                                    },
                                    axisTicks: {
                                        show: false
                                    },
                                    crosshairs: {
                                        fill: {
                                        type: 'gradient',
                                        gradient: {
                                            colorFrom: '#D8E3F0',
                                            colorTo: '#BED1E6',
                                            stops: [0, 100],
                                            opacityFrom: 0.4,
                                            opacityTo: 0.5,
                                        }
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                    }
                                    },
                                    colors: [".$colores."],
                                    yaxis: {
                                    axisBorder: {
                                        show: false
                                    },
                                    axisTicks: {
                                        show: false,
                                    },
                                    labels: {
                                        show: false,
                                        formatter: function (val) {
                                        return val + 'hs';
                                        }
                                    }
                                    
                                    },
                                    title: {
                                    text: 'Tiempo de Atención',
                                    floating: true,
                                    offsetY: 330,
                                    align: 'center',
                                    style: {
                                        color: '#444'
                                    }
                                    }
                            }).render();
                        });
                    </script>
                  </div>
                </div>";     
          ?>
        </div>
        <!-- FIN TIEMPO PROMEDIO DE ATENCION DE ORDENES -->
        
        <!-- TIEMPO PROMEDIO AUTORIZA EL SUPERVISOR A LA ORDEN -->
          <div class="col-lg-6">
            <?php
                  
                  $sql = "SELECT MONTH(DATE(a.`fecha`)) AS mes,CASE MONTH(DATE(a.`fecha`))
                                        WHEN 1 THEN 'Enero'
                                        WHEN 2 THEN 'Febrero'
                                        WHEN 3 THEN 'Marzo'
                                        WHEN 4 THEN 'Abril'
                                        WHEN 5 THEN 'Mayo'
                                        WHEN 6 THEN 'Junio'
                                        WHEN 7 THEN 'Julio'
                                        WHEN 8 THEN 'Agosto'
                                        WHEN 9 THEN 'Septiembre'
                                        WHEN 10 THEN 'Octubre'
                                        WHEN 11 THEN 'Noviembre'
                                        WHEN 12 THEN 'Diciembre'
                                ELSE 'ERROR'END AS mesnomb,
                                ROUND(AVG(TIMESTAMPDIFF(MINUTE,a.`fecha`,b.`fechaautoriza`)/60),0) AS hora
                          FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden`)
                          WHERE a.`accion`!='B' AND b.`estado`='A' AND DATE(a.`fecha`) BETWEEN '".$finimes."' AND '".$ffin."'
                          GROUP BY 1
                          ORDER BY 1 ASC;";

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
                    $datos="";
                    $mes="";
                    $colores="";
                    while($row = mysqli_fetch_array($result))
                    {
                      $datos=strlen($datos)<=0? $row['hora']: $datos.",".$row['hora'];
                      $mes=strlen($mes)<=0? "'".$row['mesnomb']."'": $mes.",'".$row['mesnomb']."'";
                      $colores=strlen($colores)<=0? "'#d4526e'": $colores.",'#d4526e'";
                    }

                    desconectar($con);
                  }
                
                
                echo "<div class='card'>
                          <div class='card-body'>
                            <h5 class='card-title'>Promedio Asignación Tarea Supervisor Por Mes</h5>
                            <div id='barChart45'></div>
                              <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                  new ApexCharts(document.querySelector('#barChart45'), {
                                    series: [{
                                              name: 'Asignación',
                                              data: [".$datos."]
                                            }],
                                              chart: {
                                              height: 350,
                                              type: 'bar',
                                            },
                                            plotOptions: {
                                              bar: {
                                                borderRadius: 0,
                                                dataLabels: {
                                                  position: 'center', // top, center, bottom
                                                },
                                              }
                                            },
                                            dataLabels: {
                                              enabled: true,
                                              formatter: function (val) {
                                                return val + 'hs';
                                              },
                                              offsetY: -20,
                                              style: {
                                                fontSize: '12px',
                                                colors: ['#304758']
                                              }
                                            },
                                            
                                            xaxis: {
                                              categories: [".$mes."],
                                              position: 'top',
                                              axisBorder: {
                                                show: false
                                              },
                                              axisTicks: {
                                                show: false
                                              },
                                              crosshairs: {
                                                fill: {
                                                  type: 'gradient',
                                                  gradient: {
                                                    colorFrom: '#D8E3F0',
                                                    colorTo: '#BED1E6',
                                                    stops: [0, 100],
                                                    opacityFrom: 0.4,
                                                    opacityTo: 0.5,
                                                  }
                                                }
                                              },
                                              tooltip: {
                                                enabled: true,
                                              }
                                            },
                                            colors: [".$colores."],
                                            yaxis: {
                                              axisBorder: {
                                                show: false
                                              },
                                              axisTicks: {
                                                show: false,
                                              },
                                              labels: {
                                                show: false,
                                                formatter: function (val) {
                                                  return val + 'hs';
                                                }
                                              }
                                            },
                                            title: {
                                              text: 'Tiempo Asignación Tarea',
                                              floating: true,
                                              offsetY: 330,
                                              align: 'center',
                                              style: {
                                                color: '#444'
                                              }
                                            }
                                    }).render();
                                  });
                                </script>
                          </div>
                      </div>";
            ?>
          </div>
        <!-- FIN TIEMPO PROMEDIO AUTORIZA EL SUPERVISOR A LA ORDEN -->
 
        <!-- TAREAS REALIZADAS -->
          <div class="col-lg-6">
            <?php    
                $sql = "SELECT b.`descripciontarea`,SUBSTRING(b.`descripciontarea`, 1, 20) AS recorte,COUNT(a.idtarea) AS cantidad
                        FROM afectadostareas a INNER JOIN tareas b ON (a.`idtarea`=b.`idtarea` AND b.`accion`!='B')
                                              INNER JOIN numeroorden c ON (a.`numorden`=c.`numorden` AND c.`accion`!='B')
                        WHERE a.`estado`='F' AND DATE(c.`fecha`) BETWEEN '".$finimes."' AND '".$ffin."' 
                        GROUP BY 1;";

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
                $datos="";
                $categorias="";
                $colores="";
                
                while($row = mysqli_fetch_array($result))
                {
                  $datos=strlen($datos)<=0? $row['cantidad']: $datos.",".$row['cantidad'];
                  $categorias=strlen($categorias)<=0? "'".$row['recorte']."'": $categorias.",'".$row['recorte']."'";
                  $colores=strlen($colores)<=0? "'#A5978B'": $colores.",'#A5978B'";
                }

                desconectar($con);
              }
                      
              echo "<div class='card'>
                        <div class='card-body'>
                          <h5 class='card-title'><a href='homexfiltros.php?op=TR'>Tareas Realizadas</a></h5>

                          <div id='barChart47'></div>
                          <script>
                            document.addEventListener('DOMContentLoaded', () => {
                              new ApexCharts(document.querySelector('#barChart47'), {
                                series: [{
                                          name: 'Servicios',
                                          data: [".$datos."]
                                        }],
                                          
                                        chart: {
                                          height: 350,
                                          type: 'bar',
                                        },
                                        plotOptions: {
                                          bar: {
                                            borderRadius: 0,
                                            columnWidth: '50%',
                                          }
                                        },
                                        dataLabels: {
                                          enabled: false
                                        },
                                        stroke: {
                                          width: 0
                                        },
                                        grid: {
                                          row: {
                                            colors: ['#fff', '#f2f2f2']
                                          }
                                        },
                                        xaxis: {
                                          labels: {
                                            rotate: -45
                                          },
                                          categories: [".$categorias."],
                                          tickPlacement: 'on'
                                        },
                                        colors: [".$colores."],
                                        yaxis: {
                                          title: {
                                            text: 'Servicios',
                                          },
                                        },
                                        fill: {
                                          type: 'gradient',
                                          gradient: {
                                            shade: 'light',
                                            type: 'horizontal',
                                            shadeIntensity: 0.25,
                                            gradientToColors: undefined,
                                            inverseColors: true,
                                            opacityFrom: 0.85,
                                            opacityTo: 0.85,
                                            stops: [50, 0, 100]
                                          },
                                        }
                                }).render();
                              });
                            </script>

                        </div>
                      </div>";
            ?>
          </div>
        <!-- FIN TAREAS REALIZADAS -->
      
        <!-- TOTAL DE REVISITAS -->
          <div class="col-lg-6">
            <?php    
                $sql = "SELECT MONTH(DATE(a.`fecha`)) AS mes,
                                CASE MONTH(DATE(a.`fecha`))
                                  WHEN 1 THEN 'Enero'
                                  WHEN 2 THEN 'Febrero'
                                  WHEN 3 THEN 'Marzo'
                                  WHEN 4 THEN 'Abril'
                                  WHEN 5 THEN 'Mayo'
                                  WHEN 6 THEN 'Junio'
                                  WHEN 7 THEN 'Julio'
                                  WHEN 8 THEN 'Agosto'
                                  WHEN 9 THEN 'Septiembre'
                                  WHEN 10 THEN 'Octubre'
                                  WHEN 11 THEN 'Noviembre'
                                  WHEN 12 THEN 'Diciembre'
                                ELSE 'ERROR'END AS mesnomb,
                              COUNT(a.numchasis) AS cant
                        FROM numeroorden a
                        WHERE a.`accion`!='B' AND a.estado!='S' AND DATE(a.`fecha`) BETWEEN '".$finimes."' AND '".$ffin."'
                        GROUP BY 1
                        ORDER BY 1,3;";

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
                $datos="";
                $meses="";
                $colores="";
                
                while($row = mysqli_fetch_array($result))
                {
                  if ($row['cant']>1)
                  {
                    $datos=strlen($datos)<=0? $row['cant']: $datos.",".$row['cant'];
                    $meses=strlen($meses)<=0? "'".$row['mesnomb']."'": $meses.",'".$row['mesnomb']."'";
                    $colores=strlen($colores)<=0? "'#c388d6'": $colores.",'#c388d6'";
                  }
                }

                desconectar($con);
              }
                      
              echo "<div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'>Total Revisitas</h5>

                        <div id='barChart50'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart50'), {
                              series: [{
                                        name: 'Revisitas',
                                        data: [".$datos."]
                                      }],
                                        chart: {
                                        height: 350,
                                        type: 'bar',
                                      },
                                      plotOptions: {
                                        bar: {
                                          borderRadius: 0,
                                          dataLabels: {
                                            position: 'center', // top, center, bottom
                                          },
                                        }
                                      },
                                      dataLabels: {
                                        enabled: true,
                                        formatter: function (val) {
                                          return val + '';
                                        },
                                        offsetY: -20,
                                        style: {
                                          fontSize: '12px',
                                          colors: ['#304758']
                                        }
                                      },
                                      
                                      xaxis: {
                                        categories: [".$meses."],
                                        position: 'top',
                                        axisBorder: {
                                          show: false
                                        },
                                        axisTicks: {
                                          show: false
                                        },
                                        crosshairs: {
                                          fill: {
                                            type: 'gradient',
                                            gradient: {
                                              colorFrom: '#D8E3F0',
                                              colorTo: '#BED1E6',
                                              stops: [0, 100],
                                              opacityFrom: 0.4,
                                              opacityTo: 0.5,
                                            }
                                          }
                                        },
                                        tooltip: {
                                          enabled: true,
                                        }
                                      },
                                      colors: [".$colores."],
                                      yaxis: {
                                        axisBorder: {
                                          show: false
                                        },
                                        axisTicks: {
                                          show: false,
                                        },
                                        labels: {
                                          show: false,
                                          formatter: function (val) {
                                            return val + '';
                                          }
                                        }
                                      },
                                      title: {
                                        text: 'Cantidad Revisitas',
                                        floating: true,
                                        offsetY: 330,
                                        align: 'center',
                                        style: {
                                          color: '#444'
                                        }
                                      }
                              }).render();
                            });
                          </script>

                      </div>
                    </div>";
            ?>
          </div>
        <!-- FIN TOTAL DE REVISITAS -->
        
        <!-- TOTAL SERVICIOS POR MODELO -->
          <div class="col-lg-6">
            <?php   
              $datos="";
              $modelos="";
              $colores="";
              $bandera="";

              $sql = "SELECT b.`modelomarca`, COUNT(a.`numorden`) AS cant
                      FROM numeroorden a INNER JOIN modelos b ON (a.codmodelo=b.codmodelo)
                      WHERE a.`accion`!='B' AND a.estado!='S' AND DATE(a.`fecha`) BETWEEN '".$txtfini."' AND '".$txtffin."'
                      GROUP BY 1
                      ORDER BY 1;";

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
                  if ($row['cant']>0)
                  {
                    $datos=strlen($datos)<=0? $row['cant']: $datos.",".$row['cant'];
                    $modelos=strlen($modelos)<=0? "'".$row['modelomarca']."'": $modelos.",'".$row['modelomarca']."'";
                    $colores=strlen($colores)<=0? "'#c388d6'": $colores.",'#c388d6'";
                  }
                }

                desconectar($con);
              }
                      
              echo "
                    <div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'><a href='homexfiltros.php?op=TS'>Total Services x Modelo</a></h5>

                        <div id='barChart48'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart48'), {
                              series: [{
                                        name: 'Servicios',
                                        data: [".$datos."]
                                      }],
                                        
                                      chart: {
                                        height: 350,
                                        type: 'bar',
                                      },
                                      plotOptions: {
                                        bar: {
                                          borderRadius: 0,
                                          columnWidth: '50%',
                                        }
                                      },
                                      dataLabels: {
                                        enabled: false
                                      },
                                      stroke: {
                                        width: 0
                                      },
                                      grid: {
                                        row: {
                                          colors: ['#fff', '#f2f2f2']
                                        }
                                      },
                                      xaxis: {
                                        labels: {
                                          rotate: -45
                                        },
                                        categories: [".$modelos."],
                                        tickPlacement: 'on'
                                      },
                                      colors: [".$colores."],
                                      yaxis: {
                                        title: {
                                          text: 'Servicios',
                                        },
                                      },
                                      fill: {
                                        type: 'gradient',
                                        gradient: {
                                          shade: 'light',
                                          type: 'horizontal',
                                          shadeIntensity: 0.25,
                                          gradientToColors: undefined,
                                          inverseColors: true,
                                          opacityFrom: 0.85,
                                          opacityTo: 0.85,
                                          stops: [50, 0, 100]
                                        },
                                      }
                              }).render();
                            });
                          </script>
          
                      </div>
                    </div>";
            ?>
          </div>
        <!-- FIN TOTAL SERVICIOS POR MODELO -->

        <!-- ORIGEN DESDE DONDE NOS CONOCEN -->
          <div class="col-lg-6">
            <?php
              $datos="";
              $origen="";
              $colores="";

              $sql="SELECT b.`publicacion`,COUNT(a.`numorden`) AS cant
                    FROM numeroorden a INNER JOIN publicaciones b ON (a.`idpublicidad`=b.`idpublicacion`)
                    WHERE a.`accion`!='B' AND DATE(a.fecha) BETWEEN '".$fini."' AND '".$ffin."'
                    GROUP BY 1
                    ORDER BY 1;";

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
                    $datos=strlen($datos)<=0? $row['cant']: $datos.",".$row['cant'];
                    $origen=strlen($origen)<=0? "'".$row['publicacion']."'": $origen.",'".$row['publicacion']."'";
                    $colores=strlen($colores)<=0? "'#33b2df'": $colores.",'#33b2df'";
                  }

                  desconectar($con);
              }

              //echo $datos."=".$origen."=".$colores;

              echo "<div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'><a href='homexfiltros.php?op=DC'>Desde Donde Nos Conoce</a></h5>

                        <div id='barChart49'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart49'), {
                              series: [{
                                        name: 'Fuentes',
                                        data: [".$datos."]
                                      }],
                                        
                                      chart: {
                                        height: 350,
                                        type: 'bar',
                                      },
                                      plotOptions: {
                                        bar: {
                                          borderRadius: 0,
                                          columnWidth: '50%',
                                        }
                                      },
                                      dataLabels: {
                                        enabled: false
                                      },
                                      stroke: {
                                        width: 0
                                      },
                                      grid: {
                                        row: {
                                          colors: ['#fff', '#f2f2f2']
                                        }
                                      },
                                      xaxis: {
                                        labels: {
                                          rotate: -45
                                        },
                                        categories: [".$origen."],
                                        tickPlacement: 'on'
                                      },
                                      colors: [".$colores."],
                                      yaxis: {
                                        title: {
                                          text: 'Fuentes',
                                        },
                                      },
                                      fill: {
                                        type: 'gradient',
                                        gradient: {
                                          shade: 'light',
                                          type: 'horizontal',
                                          shadeIntensity: 0.25,
                                          gradientToColors: undefined,
                                          inverseColors: true,
                                          opacityFrom: 0.85,
                                          opacityTo: 0.85,
                                          stops: [50, 0, 100]
                                        },
                                      }
                              }).render();
                            });
                        </script>
                      </div>
                    </div>";
            ?>
          </div>
        <!-- FIN ORIGEN DESDE DONDE NOS CONOCEN -->

        <!-- TOTAL ORDENES FINALIZADAS POR MECANICOS -->
          <div class="col-lg-12">
            <?php    
              $sql = "SELECT MONTH(a.fentrega) AS mes,b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS emple,COUNT(b.`idtarea`) AS cant
                      FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                  INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                      WHERE a.`accion`!='B' AND b.`estado`='F' AND a.fentrega BETWEEN '".$fini."' AND '".$ffin."'
                      GROUP BY 1,2,3
                      ORDER BY 1,2;";

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
                $cant=0;
                $mes="";
                $mecanico="";
                $item="";
                
                while($row = mysqli_fetch_array($result))
                {
                    $mecanico=$row['emple'];
                    $cant=$row['cant'];
                    $mes=obtenermes('L',0);

                    $item=strlen($item)<=0? "{
                                              name: '".$mecanico."',
                                              data: [".$cant."]
                                            }":$item.",{
                                                        name: '".$mecanico."',
                                                        data: [".$cant."]
                                                      }";
                }              
              
                desconectar($con);
              }
                      
              echo "<div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'><a href='homexfiltros.php?op=FM'>Cantidad Tareas Finalizadas x Mecanico</a></h5>

                        <div id='barChart53'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart53'), {
                              series: [".$item."],
                                        chart: {
                                        type: 'bar',
                                        height: 350
                                      },
                                      plotOptions: {
                                        bar: {
                                          horizontal: false,
                                          columnWidth: '55%',
                                          borderRadius: 5,
                                          borderRadiusApplication: 'end'
                                        },
                                      },
                                      dataLabels: {
                                        enabled: false
                                      },
                                      stroke: {
                                        show: true,
                                        width: 2,
                                        colors: ['transparent']
                                      },
                                      xaxis: {
                                        categories: ['".$mes."'],
                                      },
                                      yaxis: {
                                        title: {
                                          text: 'Total Tareas'
                                        }
                                      },
                                      fill: {
                                        opacity: 1
                                      },
                                      tooltip: {
                                        y: {
                                          formatter: function (val) {
                                            return val + ' Tareas'
                                          }
                                        }
                                      }
                              }).render();
                            });
                          </script>

                      </div>
                    </div>";
            ?>
          </div>
        <!-- FIN TOTAL ORDENES FINALIZADAS POR MECANICOS -->
       
      </div>
    </section>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  
  
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>