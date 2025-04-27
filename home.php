<!--// CHEQUEO DATOS LOGIN -->
<?php
  //include "/configuracion/conexion.php";
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  function obtenermes($opcion,$mesdeseado)
  {
    $resp="";
    $mesActual = date('n'); // Obtiene el número del mes actual

    if ($mesdeseado==1) $mesActual=$mesActual-1; //PERMITE OBTENER EL MES ANTERIOR AL ACTUAL
      
    if ($opcion=="C")
    {//NOMBRE CORTO DEL MES  
      $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
      $resp=$meses[$mesActual - 1]; // Resta 1
    }
    else
    {//NOMBRE LARGO DEL MES
      $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
      $resp=$meses[$mesActual - 1]; // Resta 1
    }

    return $resp;
  }

  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
    $fechahoy=date("Y-m-d");
    $fechaayer=date("Y-m-d", strtotime($fechahoy. "-1 day")); 
    $anioC=date("y");
    $anioL=date("Y");
    $mes=date("M");


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

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script>
    function deshabilitaRetroceso()
    {
      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash="";}
    }
  </script>
</head>

<body onload="deshabilitaRetroceso()">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
        <!--img src="assets/img/logo.png" alt=""-->
        <span class="d-none d-lg-block">SMATE</span>
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
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Metricas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

    <!-- TOTAL DE ORDENES X MES -->
        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <!--div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>

                <li><a class="dropdown-item" href="#">Hoy</a></li>
                <li><a class="dropdown-item" href="#">Este Mes</a></li>
                <li><a class="dropdown-item" href="#">Este Año</a></li>
              </ul>
            </div-->
              <?php
                $mesact=date("n");
                $mesant=$mesact-1;

                $sql = "SELECT 
                            (SELECT COUNT(b.`numorden`) FROM numeroorden b WHERE b.`accion`!='B' AND MONTH(b.`fecha`)=". $mesant .") AS ant,
                            COUNT(a.`numorden`) AS act
                        FROM numeroorden a
                        WHERE a.`accion`!='B' AND MONTH(a.`fecha`)=". $mesact .";";

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
                      $cantant=$row['ant'];
                      $cantact=$row['act'];
                  }
                }

                desconectar($con);
              ?>

            <div class="card-body">
              <h5 class="card-title">Total Ordenes<span>| <?php echo obtenermes('C',0) ." ". $anioC; ?></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-car-front"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                  <span class="text-success small pt-1 fw-bold">
                  <?php
                    //Analizo porcentaje
                    $porctarea=($cantant*$cantact)/100;

                    if ($cantact<$cantant) echo "-".$porctarea."%";
                    else echo "+".$porctarea."%";
                  ?>
                  </span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('C',1) ." ". $anioL; ?></span>

                </div>
              </div>
            </div>

            </div>

          </div>

  <!-- ORDENES DEMORAS-->
        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <!--div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>

                <li><a class="dropdown-item" href="#">Hoy</a></li>
                <li><a class="dropdown-item" href="#">Este Mes</a></li>
                <li><a class="dropdown-item" href="#">Este Año</a></li>
              </ul>
            </div-->

            <div class="card-body">
              <h5 class="card-title">Demoradas <span>| <?php echo obtenermes('C',0) ." ". $anioC; ?> </span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-clock"></i>
                </div>
                <div class="ps-3">
                <?php
                
                  $sql = "SELECT COUNT(DATEDIFF(a.`fechaentrega`,CURDATE())*-1) AS demoradaact,
                            (SELECT COUNT(DATEDIFF(a.`fechaentrega`,CURDATE())*-1)
                            FROM numeroorden a
                            WHERE a.`accion`!='B' AND ((DATEDIFF(a.`fechaentrega`,CURDATE())*-1)>0) AND MONTH(a.`fecha`)=". $mesant .") AS demoraant
                          FROM numeroorden a
                          WHERE a.`accion`!='B' AND ((DATEDIFF(a.`fechaentrega`,CURDATE())*-1)>0) AND MONTH(a.`fecha`)=". $mesact .";";

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
                        $cantant=$row['demoraant'];
                        $cantact=$row['demoradaact'];
                    }
                  }

                  desconectar($con);
                ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                  <span class="text-success small pt-1 fw-bold">
                  <?php
                    //Analizo porcentaje
                    $porctarea=($cantant*$cantact)/100;

                    if ($cantact<$cantant) echo "-".$porctarea."%";
                    else echo "+".$porctarea."%";
                  ?>
                  </span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('C',1) ." ". $anioL; ?></span>

                </div>
              </div>
            </div>

            </div>

          </div>
       
        
        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <!--div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>

                <li><a class="dropdown-item" href="#">Hoy</a></li>
                <li><a class="dropdown-item" href="#">Este Mes</a></li>
                <li><a class="dropdown-item" href="#">Este Año</a></li>
              </ul>
            </div-->

            <div class="card-body">
              <h5 class="card-title">Terminadas <span>| <?php echo obtenermes('C',0) ." ". $anioC; ?></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>
                <div class="ps-3">

                <?php
                
                $cantant=0;
                $cantact=100;

                $sql = "SELECT 
                            (SELECT COUNT(b.`numorden`) FROM numeroorden b WHERE b.`accion`!='B' AND MONTH(b.`fecha`)=".$mesant." AND b.estado='F') AS ant,
                            COUNT(a.`numorden`) AS act
                        FROM numeroorden a
                        WHERE a.`accion`!='B' AND MONTH(a.`fecha`)=".$mesact." AND a.`estado`='F';";

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
                      $cantant=$row['ant'];
                      $cantact=$row['act'];
                  }
                }

                desconectar($con);
              ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                  <span class="text-success small pt-1 fw-bold">
                  <?php
                    //Analizo porcentaje
                    $porctarea=($cantant*$cantact)/100;

                    if ($cantact<$cantant) echo "-".$porctarea."%";
                    else echo "+".$porctarea."%";
                  ?>  
                  </span> 
                  <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('C',1) ." ". $anioL; ?></span>

                </div>
              </div>
            </div>

            </div>

          </div>
       

        <div class="col-lg-3">

          <div class="card info-card sales-card">

            <!--div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>

                <li><a class="dropdown-item" href="#">Hoy</a></li>
                <li><a class="dropdown-item" href="#">Este Mes</a></li>
                <li><a class="dropdown-item" href="#">Este Año</a></li>
              </ul>
            </div-->

            <div class="card-body">
              <h5 class="card-title">En curso <span>| Hoy</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-headset"></i>
                </div>
                <div class="ps-3">
                <?php
                
                $cantant=0;
                $cantact=100;

                $sql = "SELECT 
                            (SELECT COUNT(b.`numorden`) FROM numeroorden b WHERE b.`accion`!='B' AND MONTH(b.`fecha`)=".$mesant." AND b.estado='P') AS ant,
                            COUNT(a.`numorden`) AS act
                        FROM numeroorden a
                        WHERE a.`accion`!='B' AND MONTH(a.`fecha`)=".$mesact." AND a.`estado`='P';";

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
                      $cantant=$row['ant'];
                      $cantact=$row['act'];
                  }
                }

                desconectar($con);
              ?>

                  <h6><?php echo $cantact; ?></h6>
                  <h5>Ordenes</h5>
                  <span class="text-success small pt-1 fw-bold">
                  <?php
                    //Analizo porcentaje
                    $porctarea=($cantant*$cantact)/100;

                    if ($cantact<$cantant) echo "-".$porctarea."%";
                    else echo "+".$porctarea."%";
                  ?>  
                  </span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('C',1) ." ". $anioL; ?></span>

                </div>
              </div>
            </div>

            </div>

          </div>
        
      </div>
    </section>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-6">
        
          <!-- Customers Card -->
            <div class="card info-card customers-card">

              <!--div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div-->

              <div class="card-body">
                <h5 class="card-title">Designación Ordenes<span>| <?php echo obtenermes('L',0) ." ". $anioL; ?></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>40 Min</h6>
                    <span class="text-danger small pt-1 fw-bold">-25%</span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('L',1) ." ". $anioL; ?></span>

                  </div>
                </div>

              </div>
            </div>
          <!-- End Customers Card -->  

        </div>

        <div class="col-lg-6">
        
          <!-- Customers Card -->
            <div class="card info-card customers-card">

              <!--div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Hoy</a></li>
                  <li><a class="dropdown-item" href="#">Este Mes</a></li>
                  <li><a class="dropdown-item" href="#">Este Año</a></li>
                </ul>
              </div-->

              <div class="card-body">
                <h5 class="card-title">Tiempo Muerto <span>| <?php echo obtenermes('L',0) ." ". $anioL; ?></span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cup-straw"></i>
                  </div>
                  <div class="ps-3">
                    <h6>2:30 hs</h6>
                    <span class="text-danger small pt-1 fw-bold">+12%</span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('L',1) ." ". $anioL; ?></span>

                  </div>
                </div>

              </div>
            </div>
          <!-- End Customers Card -->  

        </div>

      </div>
    </section>
<!--=========================================== FIN DE TARJETAS ===============================================-->

<!--=========================================== INICIO GRAFICAS ===============================================-->
    <section class="section dashboard">
      <div class="row">
      
        <!-- Tiempo de Atención de Ordenes -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tiempo de Atención de Ordenes</h5>
                <div id="barChart"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart"), {
                      series: [{
                                name: 'Atención',
                                data: [2, 3, 4, 10, 4]
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
                                  return val + "hs";
                                },
                                offsetY: -20,
                                style: {
                                  fontSize: '12px',
                                  colors: ["#304758"]
                                }
                              },
                              
                              xaxis: {
                                categories: ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes"],
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
                              colors: ["#33b2df", "#33b2df", "#33b2df", "#33b2df", "#33b2df"],
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
                                    return val + "hs";
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
            </div>
        </div>
        <!-- Fin Tiempo de Atención de Ordenes -->

        <!-- Tiempo Asignación Tarea Administrador -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tiempo Asignación Tarea Administrador</h5>

                <div id="barChart45"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart45"), {
                      series: [{
                                name: 'Asignación',
                                data: [2, 3, 4]
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
                                  return val + "hs";
                                },
                                offsetY: -20,
                                style: {
                                  fontSize: '12px',
                                  colors: ["#304758"]
                                }
                              },
                              
                              xaxis: {
                                categories: ["Enero", "Febrero", "Marzo"],
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
                              colors: ["#d4526e", "#d4526e", "#d4526e", "#d4526e", "#d4526e", "#d4526e"],
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
                                    return val + "hs";
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
          </div>
        </div>
        <!-- Fin Tiempo Asignación Tarea Administrador -->
 
        <!-- Total Ordenes Demoradas x Mes -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Ordenes Demoradas x Mes</h5>

              <div id="donutChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#donutChart"), {
                    series: [44, 55, 13, 43, 22, 35],
                    chart: {
                      height: 350,
                      type: 'donut',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                  }).render();
                });
              </script>

            </div>
          </div>
        </div>
        <!-- Fin Total Ordenes Demoradas xx Mes -->

        <!-- Cantidad Ordenes Atendidas x Mes -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Cantidad Ordenes Atendidas x Mes</h5>

                <div id="barChart46"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart46"), {
                      series: [{
                                name: 'Ordenes',
                                data: [20, 30, 40]
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
                                  return val + "";
                                },
                                offsetY: -20,
                                style: {
                                  fontSize: '12px',
                                  colors: ["#304758"]
                                }
                              },
                              
                              xaxis: {
                                categories: ["Enero", "Febrero", "Marzo"],
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
                              colors: ["#13d8aa", "#13d8aa", "#13d8aa"],
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
                                    return val + "";
                                  }
                                }
                              },
                              title: {
                                text: 'Cantidad Ordenes Atendidas',
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
          </div>
        </div>
        <!-- Fin Cantidad Ordenes Atendidas x Mes -->

        <!-- Tareas Realizadas -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tareas Realizadas</h5>

                <div id="barChart47"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart47"), {
                      series: [{
                                name: 'Servicios',
                                data: [44, 55, 41, 67, 22, 43, 23, 46]
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
                                categories: ['Filtro', 'Aire', 'Aceite', 'Cierre Centralizado', 'Paragolpes', 'Luces delantera',
                                              'Bomba de agua', 'Luces traseras'
                                ],
                                tickPlacement: 'on'
                              },
                              colors: ["#A5978B", "#A5978B", "#A5978B", "#A5978B", "#A5978B", "#A5978B", "#A5978B", "#A5978B"],
                              yaxis: {
                                title: {
                                  text: 'Servicios',
                                },
                              },
                              fill: {
                                type: 'gradient',
                                gradient: {
                                  shade: 'light',
                                  type: "horizontal",
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
            </div>
        </div>
        <!-- Fin Tareas Realizadas -->

        <!-- Total Services x Modelo -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Services x Modelo</h5>

                <div id="barChart48"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart48"), {
                      series: [{
                                name: 'Servicios',
                                data: [12, 10, 5, 8]
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
                                categories: ['Fiat Argo', 'Fiat Cronos', 'Fiat Fullback', 'Fiat Toro'
                                ],
                                tickPlacement: 'on'
                              },
                              colors: ["#2b908f", "#2b908f", "#2b908f", "#2b908f"],
                              yaxis: {
                                title: {
                                  text: 'Servicios',
                                },
                              },
                              fill: {
                                type: 'gradient',
                                gradient: {
                                  shade: 'light',
                                  type: "horizontal",
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
            </div>
        </div>
        <!-- Fin Total Services x Modelo -->

        <!-- Comparativas Mecanicos x Tareas -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Comparativas Mecanicos x Tareas</h5>

                <div id="barChart49"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart49"), {
                      series: [{
                                name: 'Mecanico 1',
                                data: [10, 5, 4, 7, 2, 4]
                              }, {
                                name: 'Mecanico 2',
                                data: [3, 2, 3, 5, 3, 4]
                              }, {
                                name: 'Mecanico 3',
                                data: [2, 7, 1, 9, 5, 1]
                              }, {
                                name: 'Mecanico 4',
                                data: [9, 7, 5, 8, 6, 9]
                              }, {
                                name: 'Mecanico 5',
                                data: [2, 2, 9, 3, 5, 2]
                              }],
                                chart: {
                                type: 'bar',
                                height: 350,
                                stacked: true,
                              },
                              plotOptions: {
                                bar: {
                                  horizontal: true,
                                  dataLabels: {
                                    total: {
                                      enabled: true,
                                      offsetX: 0,
                                      style: {
                                        fontSize: '13px',
                                        fontWeight: 900
                                      }
                                    }
                                  }
                                },
                              },
                              stroke: {
                                width: 1,
                                colors: ['#fff']
                              },
                              title: {
                                text: ''
                              },
                              xaxis: {
                                categories: ['Enero', 'Febrero', 'Marzo'],
                                labels: {
                                  formatter: function (val) {
                                    return val + ""
                                  }
                                }
                              },
                              yaxis: {
                                title: {
                                  text: undefined
                                },
                              },
                              tooltip: {
                                y: {
                                  formatter: function (val) {
                                    return val + ""
                                  }
                                }
                              },
                              fill: {
                                opacity: 1
                              },
                              legend: {
                                position: 'top',
                                horizontalAlign: 'left',
                                offsetX: 40
                              }
                      }).render();
                    });
                  </script>
            </div>
          </div>
        </div>
        <!-- Fin Comparativas Mecanicos x Tareas -->

        <!-- Total Revisitas x Mes -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Revisitas x Mes</h5>

                <div id="barChart50"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart50"), {
                      series: [{
                                name: 'Revisitas',
                                data: [2, 7, 4]
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
                                  return val + "";
                                },
                                offsetY: -20,
                                style: {
                                  fontSize: '12px',
                                  colors: ["#304758"]
                                }
                              },
                              
                              xaxis: {
                                categories: ["Enero", "Febrero", "Marzo"],
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
                              colors: ["#c388d6", "#c388d6", "#c388d6"],
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
                                    return val + "";
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
            </div>
        </div>
        <!-- Fin Total Revisitas x Mes -->

        <!-- Tiempo Ocupación x Mecanicos -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Horas Trabajadas Mecanico - Marzo 2025</h5>

                <div id="barChart51"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart51"), {
                      series: [{
                              data: [30, 20, 40, 70, 50]
                            }],
                              chart: {
                              type: 'bar',
                              height: 380
                            },
                            plotOptions: {
                              bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                  position: 'bottom'
                                },
                              }
                            },
                            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B'
                            ],
                            dataLabels: {
                              enabled: true,
                              textAnchor: 'start',
                              style: {
                                colors: ['#fff']
                              },
                              formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                              },
                              offsetX: 0,
                              dropShadow: {
                                enabled: true
                              }
                            },
                            stroke: {
                              width: 1,
                              colors: ['#fff']
                            },
                            xaxis: {
                              categories: ['Mecanico 1', 'Mecanico 2', 'Mecanico 3', 'Mecanico 4', 'Mecanico 5'
                              ],
                            },
                            yaxis: {
                              labels: {
                                show: false
                              }
                            },
                            title: {
                                text: '',
                                align: 'center',
                                floating: true
                            },
                            subtitle: {
                                text: 'Horas Trabajadas',
                                align: 'center',
                            },
                            tooltip: {
                              theme: 'dark',
                              x: {
                                show: false
                              },
                              y: {
                                title: {
                                  formatter: function () {
                                    return ''
                                  }
                                }
                              }
                            }
                      }).render();
                    });
                  </script>
              </div>
            </div>
        </div>
        <!-- Fin Tiempo Ocupación x Mecanicos -->

        <!-- Total Tiempo Muerto x Mecanicos -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tiempo Muerto Mecanicos - Marzo 2025</h5>

                <div id="barChart52"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart52"), {
                      series: [{
                              data: [3, 2, 1, 2, 1]
                            }],
                              chart: {
                              type: 'bar',
                              height: 380
                            },
                            plotOptions: {
                              bar: {
                                barHeight: '100%',
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                  position: 'bottom'
                                },
                              }
                            },
                            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B'
                            ],
                            dataLabels: {
                              enabled: true,
                              textAnchor: 'start',
                              style: {
                                colors: ['#fff']
                              },
                              formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                              },
                              offsetX: 0,
                              dropShadow: {
                                enabled: true
                              }
                            },
                            stroke: {
                              width: 1,
                              colors: ['#fff']
                            },
                            xaxis: {
                              categories: ['Mecanico 1', 'Mecanico 2', 'Mecanico 3', 'Mecanico 4', 'Mecanico 5'
                              ],
                            },
                            yaxis: {
                              labels: {
                                show: false
                              }
                            },
                            title: {
                                text: '',
                                align: 'center',
                                floating: true
                            },
                            subtitle: {
                                text: 'Tiempo Muerto',
                                align: 'center',
                            },
                            tooltip: {
                              theme: 'dark',
                              x: {
                                show: false
                              },
                              y: {
                                title: {
                                  formatter: function () {
                                    return ''
                                  }
                                }
                              }
                            }
                      }).render();
                    });
                  </script>
              </div>
            </div>
        </div>
        <!-- Fin Total Tiempo Muerto x Mecanicos -->

        <!-- Total Ordenes Finalizadas x Mecanico -->
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Total Ordenes Finalizadas x Mecanico</h5>

                <div id="barChart53"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChart53"), {
                      series: [{
                                name: 'Mecanco 1',
                                data: [44, 55, 57]
                              }, {
                                name: 'Mecanico 2',
                                data: [76, 85, 10]
                              }, {
                                name: 'Mecanico 3',
                                data: [35, 41, 36]
                              }, {
                                name: 'Mecanico 4',
                                data: [16, 5, 11]
                              }, {
                                name: 'Mecanico 5',
                                data: [26, 8, 12]
                              }],
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
                                categories: ['Ene', 'Feb', 'Mar'],
                              },
                              yaxis: {
                                title: {
                                  text: 'Total Ordenes'
                                }
                              },
                              fill: {
                                opacity: 1
                              },
                              tooltip: {
                                y: {
                                  formatter: function (val) {
                                    return "$ " + val + " Ordenes"
                                  }
                                }
                              }
                      }).render();
                    });
                  </script>

              </div>
            </div>
        </div>
        <!-- Fin Total Ordenes Finalizadas x Mecanico -->
       
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