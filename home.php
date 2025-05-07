<!--// CHEQUEO DATOS LOGIN -->
<?php
  //include "/configuracion/conexion.php";
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  //$mesesabreviados = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  //$mesescompleto = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  $ffin=date("Y-m-d H:i:s");
  $ffineti=date("d-m-Y"); 
  $fini=date("Y-m-d H:i:s",strtotime($ffin . "-5 days"));
  $finieti=date("d-m-Y",strtotime($ffin . "-5 days"));
  $finimes=date("Y-m-d H:i:s",strtotime($ffin . "-5 month"));
  $finimeseti=date("d-m-Y",strtotime($ffin . "- 5 month"));
  $anioActual = date('Y'); // Obtiene el número del mes actual

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
    $fechahoy=date("Y-m-d");
    $fechaayer=date("Y-m-d", strtotime($fechahoy. "-1 day")); 
    $fecha7diasantes=date("Y-m-d", strtotime($fechahoy. "-7 day")); 
    $anioC=date("y");
    $anioL=date("Y");
    $mes=date("m")*1;
    $mesviejo=date("m", strtotime($fechahoy . "- 3 month"))*1;
    
    $lsdias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $posdia=date('w');
    $nombdia=$lsdias[$posdia];
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
      <!-- FIN TOTAL DE ORDENES X MES -->
    
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
                
                  $sql = "SELECT COUNT(TIMESTAMPDIFF(MINUTE,a.`fechaentrega`,CURDATE())) AS demoradaact,
                                (SELECT COUNT(TIMESTAMPDIFF(MINUTE,b.`fechaentrega`,CURDATE()))
                                FROM numeroorden b
                                WHERE b.`accion`!='B' AND (TIMESTAMPDIFF(MINUTE,b.`fechaentrega`,CURDATE())>0) AND MONTH(b.`fecha`)=". $mesant .") AS demoraant
                          FROM numeroorden a
                          WHERE a.`accion`!='B' AND (TIMESTAMPDIFF(MINUTE,a.`fechaentrega`,CURDATE())>0) AND MONTH(a.`fecha`)=". $mesact .";";

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
      <!-- FIN ORDENES DEMORAS-->
    
      <!-- ORDENES TERMINADAS-->    
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
      <!-- FIN ORDENES TERMINADAS-->    
    
      <!-- ORDENES EN CURSO-->     
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
      <!-- FIN ORDENES EN CURSO-->
    </section>

    <section class="section dashboard">
      <div class="row">

      <!-- DESIGNAR ORDENES EN CURSO-->
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
                    <h6>
                    <?php
                        $promant=0;
                        $promact=0;
                        $hora="";

                        $sql = "SELECT SEC_TO_TIME(AVG(TIMESTAMPDIFF(MINUTE,b.`fecha`,a.`fechaautoriza`))) AS hora,AVG(TIMESTAMPDIFF(MINUTE,b.`fecha`,a.`fechaautoriza`)) AS promact,
                                  (SELECT AVG(TIMESTAMPDIFF(MINUTE,bb.`fecha`,aa.`fechaautoriza`))
                                  FROM autorizaraccorden aa INNER JOIN numeroorden bb ON (aa.`numorden`=bb.`numorden` AND bb.`accion`!='B')
                                  WHERE aa.`accion`!='B' AND aa.`estado`='A' AND MONTH(bb.`fecha`)=".$mesant.") AS promant
                                FROM autorizaraccorden a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                WHERE a.`accion`!='B' AND a.`estado`='A' AND MONTH(b.`fecha`)=".$mesact.";";

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
                              $promant=$row['promant'];
                              $promact=$row['promact'];
                              $hora=explode('.',$row['hora']);
                          }
                        }

                        desconectar($con);

                        echo $hora[0] ." hs";
                      ?>
                      </h6>
                    <span class="text-danger small pt-1 fw-bold">
                    <?php
                      //Analizo porcentaje
                      $porctarea=($promant*$promact*0)/100;

                      if ($promact<$promant) echo "-".$porctarea."%";
                      else echo "+".$porctarea."%";
                    ?>    
                    </span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('L',1) ." ". $anioL; ?></span>

                  </div>
                </div>

              </div>
            </div>
          <!-- End Customers Card -->  

        </div>
      <!-- FIN DESIGNAR ORDENES EN CURSO-->

      <!-- TIEMPO MUERTO -->
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
                    <h6>
                    <?php
                        $promant=0;
                        $promact=0;
                        $hora="";

                        $sql = "SELECT SEC_TO_TIME(AVG(TIMESTAMPDIFF(MINUTE,a.`fecha`,a.`fechaaccion`))) AS hora,
                                      AVG(TIMESTAMPDIFF(MINUTE,a.`fecha`,a.`fechaaccion`)) AS promact,
                                      (SELECT AVG(TIMESTAMPDIFF(MINUTE,bb.`fecha`,bb.`fechaaccion`))
                                      FROM numeroorden bb
                                      WHERE bb.`accion`!='B' AND bb.`estado`='D' AND MONTH(bb.`fecha`)=".$mesant.") AS promant
                                FROM numeroorden a
                                WHERE a.`accion`!='B' AND a.`estado`='D' AND MONTH(a.`fecha`)=".$mesact.";";

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
                              $promant=$row['promant'];
                              $promact=$row['promact'];
                              $hora=explode('.',$row['hora']);
                          }
                        }

                        desconectar($con);

                        echo $hora[0] ." hs";
                      ?>
                      </h6>
                    <span class="text-danger small pt-1 fw-bold">
                    <?php
                      //Analizo porcentaje
                      $porctarea=($promant*$promact)/100;

                      if ($promact<$promant) echo "-".$porctarea."%";
                      else echo "+".$porctarea."%";
                    ?>      
                    </span> <span class="text-muted small pt-2 ps-1"><?php echo obtenermes('L',1) ." ". $anioL; ?></span>

                  </div>
                </div>

              </div>
            </div>
            <!-- End Customers Card -->  
          </div>
        </div>
      <!-- FIN TIEMPO MUERTO -->
    </section>
<!--=========================================== FIN DE TARJETAS ===============================================-->


<!--=========================================== INICIO GRAFICAS ===============================================-->

    <section class="section dashboard">
      <div class="row">
      
        <!-- TIEMPO DE ATENCION DE ORDENES -->
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
                  WHERE a.`accion`!='B' AND a.`estado`='F' AND a.fecha BETWEEN '".$fini."' AND '".$ffin."'
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
                  <h5 class='card-title'>Tiempo Promedio de Atención de Ordenes <p>".$finieti." al ".$ffineti."</p></h5>
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
        <!-- FIN DE TIEMPO DE ATENCION DE ORDENES -->

        <!-- Tiempo Asignación Tarea Administrador -->
          <div class="col-lg-6">
            <?php
                  
                  $sql = "SELECT CASE MONTH(DATE(a.`fecha`))
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
                          WHERE a.`accion`!='B' AND b.`estado`='A' AND a.fecha BETWEEN '".$finimes."' AND '".$ffin."'
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
                            <h5 class='card-title'>Tiempo Promedio Asignación Tarea Supervisor <p>".$finimeseti." al ".$ffineti."</p></h5>
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
        <!-- Fin Tiempo Asignación Tarea Administrador -->
 
        <!-- Total Ordenes Demoradas x Mes -->
        <div class="col-lg-6">
          <?php
                  
            $sql = "SELECT CASE MONTH(DATE(a.`fecha`))
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
                          (SELECT COUNT(xx.numorden)
                          FROM numeroorden xx
                          WHERE xx.`accion`!='B' AND MONTH(DATE(xx.fecha))=MONTH(DATE(a.`fecha`))) AS totalorden, 
                        COUNT(a.`numorden`) AS cantdemoradas
                  FROM numeroorden a
                  WHERE a.`accion`!='B' AND a.`estado`='F' AND DATE(a.`fechaentrega`)<DATE(a.`fechaaccion`) AND a.fecha BETWEEN '".$finimes."' AND '".$ffin."'
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
              while($row = mysqli_fetch_array($result))
              {
                $datos=strlen($datos)<=0? $row['cantdemoradas']: $datos.",".$row['cantdemoradas'];
                $mes=strlen($mes)<=0? "'".$row['mesnomb']." (".$row['totalorden'].")'": $mes.",'".$row['mesnomb']." (".$row['totalorden'].")'";
              }

              desconectar($con);
            }
          
          
            echo "<div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>Total Ordenes Demoradas <p>".$finimeseti." al ".$ffineti."</p></h5>

                      <div id='donutChart'></div>

                      <script>
                        document.addEventListener('DOMContentLoaded', () => {
                          new ApexCharts(document.querySelector('#donutChart'), {
                            series: [".$datos."],
                            chart: {
                              height: 350,
                              type: 'donut',
                              toolbar: {
                                show: true
                              }
                            },
                            labels: [".$mes."],
                          }).render();
                        });
                      </script>

                    </div>
                  </div>";
          ?>
        </div>
        <!-- Fin Total Ordenes Demoradas xx Mes -->
         
        <!-- Cantidad Ordenes Atendidas x Mes -->
        <div class="col-lg-6">
          <?php    
              $sql = "SELECT CASE MONTH(DATE(a.`fecha`))
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
        
                            COUNT(a.`numorden`) AS totalordenes
                      FROM numeroorden a
                      WHERE a.`accion`!='B' AND a.`estado`='F' AND a.fecha BETWEEN '".$finimes."' AND '".$ffin."'
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
                $datos=strlen($datos)<=0? $row['totalordenes']: $datos.",".$row['totalordenes'];
                $mes=strlen($mes)<=0? "'".$row['mesnomb']."'": $mes.",'".$row['mesnomb']."'";
                $colores=strlen($colores)<=0? "'#13d8aa'": $colores.",'#13d8aa'";
              }

              desconectar($con);
            }
                    
            echo "<div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>Cantidad Ordenes Atendidas <p>".$finimeseti." al ".$ffineti."</p></h5>

                        <div id='barChart46'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart46'), {
                              series: [{
                                        name: 'Ordenes',
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
                                            return val + '';
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
                  </div>";
          ?>
        </div>  
        <!-- Fin Cantidad Ordenes Atendidas x Mes -->

        <!-- Tareas Realizadas -->
        <div class="col-lg-6">
          <?php    
              $sql = "SELECT b.`descripciontarea`,SUBSTRING(b.`descripciontarea`, 1, 20) AS recorte,COUNT(a.idtarea) AS cantidad
                      FROM afectadostareas a INNER JOIN tareas b ON (a.`idtarea`=b.`idtarea` AND b.`accion`!='B')
                      WHERE a.`estado`='F'
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
                        <h5 class='card-title'>Tareas Realizadas</h5>

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
        <!--div class="col-lg-6"-->
          <?php    
             /* $sql = "SELECT MONTH(DATE(a.`fechaobs`)) AS mes, a.`idempleado`,CONCAT(b.`apellido`,', ',b.`nombre`) AS emple , CASE MONTH(DATE(a.`fechaobs`))
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
                              COUNT(a.numorden) AS cant
                      FROM afectadostareas a INNER JOIN personas b ON (a.`idempleado`=b.`idpersona` AND b.`accion`!='B')
                      WHERE a.`estado`='F' AND a.fechaobs BETWEEN '".$finimes."' AND '".$ffin."'
                      GROUP BY 1,2
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
              $idmecanico="";
              $mecanico="";
              $cant="";
              $idmes="";
              $mes="";
              $lsmeses="";
              $elementos="";
              
              while($row = mysqli_fetch_array($result))
              {
                $idmes=$row['mes'];
                $idmecanico=$row['idempleado'];
                $cant=$row['cant'];
                $mes=$row['mesnomb'];
                $mecanico=$row['emple'];
              }

              desconectar($con);
            }
                    
            echo "<div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>Comparativas Mecanicos x Tareas</h5>

                        <div id='barChart49'></div>
                        <script>
                          document.addEventListener('DOMContentLoaded', () => {
                            new ApexCharts(document.querySelector('#barChart49'), {
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
                                        categories: ['Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio'],
                                        labels: {
                                          formatter: function (val) {
                                            return val + ''
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
                                            return val + ''
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
                  </div>";
                  */
          ?>
        <!--/div-->
        <!-- Fin Comparativas Mecanicos x Tareas -->

        <!-- Total Revisitas x Mes -->
        <div class="col-lg-6">
          <?php    
              $sql = "SELECT a.numchasis, 
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
                      WHERE a.`accion`!='B' AND a.estado!='S' AND a.fecha BETWEEN '".$finimes."' AND '".$ffin."'
                      GROUP BY 1
                      ORDER BY 2,3;";

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
                      <h5 class='card-title'>Total Revisitas <p>".$finimeseti." al ".$ffineti."</p></h5>

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
        <!-- Fin Total Revisitas x Mes -->

        <!-- Tiempo Ocupación x Mecanicos -->
        <div class="col-lg-6">
          <?php    
            /*
            $sql = "SELECT b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS emple ,COUNT(b.`idtarea`) AS cant
                                FROM autorizaraccorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                                        INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                                WHERE a.`estado`='A' AND b.`estado`='F' AND DATE(a.fechaautoriza) BETWEEN '".$finimes."' AND '".$ffin."'
                                GROUP BY 1
                                ORDER BY 1;";
          */ 
            $fecha = date("Y-m-d");
            $anio = date('Y', strtotime($fecha)); 
            $mes = date('m', strtotime($fecha));

            $sql="SELECT b.`idpersona`,CONCAT(d.`apellido`,', ',d.`nombre`) AS emple,ROUND(SUM(TIMESTAMPDIFF(MINUTE,b.`fechaautoriza`,c.`fechaobs`))/60,0) AS horas
                  FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                    INNER JOIN afectadostareas c ON (b.`numorden`=c.`numorden` AND b.`idpersona`=c.`idempleado`)
                                    INNER JOIN personas d ON (d.`idpersona`=b.`idpersona` AND d.`accion`!='B')
                  WHERE a.`accion`!='B' AND a.`estado`='F' AND MONTH(b.`fechaautoriza`)=".$mes." 
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
              $datos="";
              $mecanico="";
              $colores="";
              global $mesActual; // Obtiene el número del mes actual
              //$anioActual = date('Y'); // Obtiene el número del mes actual
              
              while($row = mysqli_fetch_array($result))
              {
                $datos=strlen($datos)<=0? $row['horas']: $datos.",".$row['horas'];
                $mecanico=strlen($mecanico)<=0? "'".$row['emple']."'": $mecanico.",'".$row['emple']."'";
                $color = substr(md5(time()), 0, 6);
                $colores=strlen($colores)<=0? "'".randomColor()."'" : $colores.",'".randomColor()."'";
              }

              desconectar($con);
            }
                
            //echo " ". $anioC ." ". obtenermes('L',0);
            
            echo "<div class='card'>
              <div class='card-body'>
                <h5 class='card-title'>Horas Trabajadas Mecanico - ". obtenermes('L',0) ." ". $anioL ."</h5>

                <div id='barChart51'></div>
                <script>
                  document.addEventListener('DOMContentLoaded', () => {
                    new ApexCharts(document.querySelector('#barChart51'), {
                      series: [{
                              data: [".$datos."]
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
                            colors: [".$colores."],
                            dataLabels: {
                              enabled: true,
                              textAnchor: 'start',
                              style: {
                                colors: ['#fff']
                              },
                              formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
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
                              categories: [".$mecanico."],
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
            </div>";

            function randomColor(){
              $str = "#";
              for($i = 0 ; $i < 6 ; $i++){
              $randNum = rand(0, 15);
              switch ($randNum) {
              case 10: $randNum = "A"; 
              break;
              case 11: $randNum = "B"; 
              break;
              case 12: $randNum = "C"; 
              break;
              case 13: $randNum = "D"; 
              break;
              case 14: $randNum = "E"; 
              break;
              case 15: $randNum = "F"; 
              break; 
              }
              $str .= $randNum;
              }
              return $str;
             }
          ?>
        </div>
        <!-- Fin Tiempo Ocupación x Mecanicos -->

        <!-- Total Tiempo Muerto x Mecanicos -->
        <div class="col-lg-6">
          <?php   
          
              $ultimoDiaMes = date('t', strtotime($fecha));
              $contadorDiasSemana = 0;

              $sql = "SELECT b.`idpersona`,CONCAT(d.`apellido`,', ',d.`nombre`) AS emple,ROUND(SUM(TIMESTAMPDIFF(MINUTE,b.`fechaautoriza`,c.`fechaobs`))/60,0) AS horas
                      FROM numeroorden a INNER JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                        INNER JOIN afectadostareas c ON (b.`numorden`=c.`numorden` AND b.`idpersona`=c.`idempleado`)
                                        INNER JOIN personas d ON (d.`idpersona`=b.`idpersona` AND d.`accion`!='B')
                      WHERE a.`accion`!='B' AND a.`estado`='F' AND MONTH(b.`fechaautoriza`)=".$mes." 
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
              for ($dia = 1; $dia <= $ultimoDiaMes; $dia++) {
                  $fechaActual = "$anio-$mes-$dia";
                  $diaSemana = date('N', strtotime($fechaActual));
                  if ($diaSemana < 6) { // 6 representa el viernes, por lo que los días menores a 6 son de lunes a viernes
                      $contadorDiasSemana++;
                  }
              }
            
              $jornada = ($contadorDiasSemana*570)/60; //570 EQUIVA A 9 HORAS 30 MIN JORNADA DE UN MECANICO
            
              //echo "dias=".$contadorDiasSemana."-min=".$jornada;
              
              $datos="";
              $mecanico="";
              $colores="";
              
              while($row = mysqli_fetch_array($result))
              {
                $datos=strlen($datos)<=0? ($jornada-$row['horas']): $datos.",". ($jornada-$row['horas']);
                $mecanico=strlen($mecanico)<=0? "'".$row['emple']."'": $mecanico.",'".$row['emple']."'";
                $color = substr(md5(time()), 0, 6);
                $colores=strlen($colores)<=0? "'".randomColor()."'" : $colores.",'".randomColor()."'";
              }

              desconectar($con);
            }

            //echo "Datos=".$datos."-mes".$mes;
                    
            echo "<div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>Tiempo Muerto Mecanicos - ". obtenermes('L',0) ." ". $anioL ."</h5>

                      <div id='barChart52'></div>
                      <script>
                        document.addEventListener('DOMContentLoaded', () => {
                          new ApexCharts(document.querySelector('#barChart52'), {
                            series: [{
                                    data: [".$datos."]
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
                                  colors: [".$colores."],
                                  dataLabels: {
                                    enabled: true,
                                    textAnchor: 'start',
                                    style: {
                                      colors: ['#fff']
                                    },
                                    formatter: function (val, opt) {
                                      return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
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
                                    categories: [".$mecanico."],
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
                  </div>";
                  
          ?>
        </div>
        <!-- Fin Total Tiempo Muerto x Mecanicos -->

        <!-- Total Ordenes Finalizadas x Mecanico -->
        <div class="col-lg-12">
            <?php    
              $sql = "SELECT CASE MONTH(DATE(a.`fecha`))
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
                                ELSE 'ERROR'END AS mesnomb,b.`idempleado`,CONCAT(c.`apellido`,', ',c.`nombre`) AS emple,COUNT(a.`numorden`) AS cant
                      FROM numeroorden a INNER JOIN afectadostareas b ON (a.`numorden`=b.`numorden`)
                                        INNER JOIN personas c ON (c.`idpersona`=b.`idempleado` AND c.`accion`!='B')
                      WHERE a.`accion`!='B' AND a.`estado`='F' -- AND MONTH(a.`fecha`)=".$mes." 
                      GROUP BY 1,2
                      ORDER BY 2,1;";

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
              $idmecanico="";
              $mecanico="";
              
              while($row = mysqli_fetch_array($result))
              {
                if (strlen($idmecanico)>0)
                {
                  if ($idmecanico==$row['idempleado'])
                  {
                    $datos=$datos.",".$row['cant'];
                    $mes=$mes.",".$row['mesnomb'];
                  }
                }
                else
                {
                  $idmecanico=$row['idempleado'];
                  $mecanico=$row['emple'];
                  $datos=$row['cant'];
                  $mes=$row['mesnomb'];
                }
              }

              desconectar($con);
            }
                    
            echo "<div class='card'>
                    <div class='card-body'>
                      <h5 class='card-title'>Total Ordenes Finalizadas x Mecanico</h5>

                      <div id='barChart53'></div>
                      <script>
                        document.addEventListener('DOMContentLoaded', () => {
                          new ApexCharts(document.querySelector('#barChart53'), {
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
                                          return '$ ' + val + ' Ordenes'
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