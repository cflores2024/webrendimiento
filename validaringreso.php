<?php

  include "/configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
    $fechaaccion=date("Y-m-d H:i:s"); 

    $txtfoto="";
    $txtnombre="";
    $txtnumsocio="";
    $txtapto="";
    $idsocio="";
    
    if (isset($_GET['id']))
    {
       //SE RECUPERAN LOS DATOS DEL SOCIO
       $txtdni=$_GET["id"];
      
      //OBTENIENDO DATOS DEL GET
      $sql = "SELECT a.idpersona,a.`urlfoto`,CONCAT(a.`apellido`,', ',a.`nombre`) AS apenomb,a.`nrosocio`,a.aptoingreso
              FROM personas a 
              WHERE a.dni=". $txtdni ." AND a.`accion`!='B';";     

      $con=conectar();

      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result))
      {
        $idsocio=$row['idpersona'];
        $txtfoto=$row['urlfoto'];
        
        $txtnombre=$row["apenomb"];
        $txtnumsocio=$row["nrosocio"];
    
        $txtapto=$row["aptoingreso"];
      }

      desconectar($con);  
      
      //REGISTRO MOVIMIENTO EN TABLA DE INGRESOS
      if (strlen($idsocio)>0)
      {
        //ALTA DE LA ASISTENCIA
        $sql="INSERT INTO asistencias (idpersona,aptoingreso,idempleado,fechaasistencia) VALUES (?,?,?,?);";

        $con=conectar();
        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'ssss',$idsocio,$txtapto,$id,$fechaaccion);
        $resp=mysqli_stmt_execute($sentencia);
      
        desconectar($con);
      
        if ($resp)  
        {

        }
      }
    }
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

  <title>Complejo Gral. Belgrano - Secretaría de deportes</title>
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

  <style>
   
    .container {
      text-align: center;
    }
    .person-image {
      width: 100%; /* Se ajusta al 100% del contenedor */
      max-width: 400px; /* Aumentamos el tamaño de la imagen */
      height: auto;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .status-message {
      font-size: 24px;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 5px;
      background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
      color: white;
      position: absolute;
      top: 50%; /* Centramos verticalmente */
      left: 50%; /* Centramos horizontalmente */
      transform: translate(-50%, -50%); /* Aseguramos que el texto esté perfectamente centrado */
      width: 80%; /* Reducir el tamaño para que no sobresalga de la imagen */
      text-align: center; /* Centra el texto horizontalmente */
    }
    .authorized {
      background-color: rgba(76, 175, 80, 0.7); /* Verde para autorizado */
    }
    .not-authorized {
      background-color: rgba(244, 67, 54, 0.7); /* Rojo para no autorizado */
    }
  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Complejo Belgrano</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <strong>Secretaria de Deporte</strong>
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
          <img src="assets/img/<? echo $foto; ?>" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><? echo $nombrecorto; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
            <h6><? echo $apenomb; ?></h6>
            <span><? echo $tipousu; ?>r</span>
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
      <h1>Socios</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="validaringreso.php">Validar Ingreso</a></li>
          <li class="breadcrumb-item active">Ingreso Complejo</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="container">
          <?php 
            if (strlen($txtapto)>0)
            {
              ?>
              <div class="row justify-content-center">
                <!-- Contenedor con la imagen de la persona -->
                <div class="col-12 col-md-4 position-relative text-center">
                  <img src="assets/img/<? echo $txtfoto; ?>" alt="Foto de Persona" class="person-image">
                  <!-- Mensaje de autorización encima de la imagen -->
                <?php
                  if ($txtapto=="S")
                  {
                    ?>
                    <div class="status-message authorized">
                      AUTORIZADO!!!
                    </div>
                    <?php
                  }
                  else
                  {
                    ?>
                    <div class="status-message not-authorized">
                      NO AUTORIZADO!!!
                    </div>
                    <?php
                  }
                ?>
                </div>
              </div>

              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h1><? echo $txtnombre; ?></h1>
                <h3>Número de Socio: <? echo $txtnumsocio; ?></h3>
              </div>
              <?php
            }
          ?>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Identificar persona</button>
          </div>  
        </div>
      </div>
    </section>

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

  <!--script src="assets/vendor/jquery321/jquery.min.js"></script-->
  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="assets/js/cambiaravatar.js"></script>
</body>

</html>
