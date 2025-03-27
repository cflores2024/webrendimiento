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

    $fechaasistencia=date("Y-m-d");            
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

  <title>Gestión de mantenimiento</title>
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
            //alert ('numero patente='+num);
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
                          <th scope="col">Titulo Orden</th>
                          <th scope="col" data-type="date" data-format="MM/DD/YYYY">Fecha inicio</th>
                          <th scope="col">Tiempo</th>
                          <th scope="col">Avance %</th>
                          <th scope="col">Afectados</th>
                          <th scope="col">Estado</th>
                          <th scope="col">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"><a href="#" onclick="verorden(1234)">Service por 40.000 Kms</a></th>
                          <td>04/02/2025</td>
                          <td>4 hs</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            </div>
                          </td>
                          <td>
                              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Sergio: Fija disponibilidad orden">
                                <img src="assets/img/team-2.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Carlos: Cambio Aceite">
                                <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Cesar: Cambio de una cubierta">
                              </a>
                          </td>
                          <td><span class="badge bg-success">Finalizado</span></td>
                          <td>
                            <a href='#'>
                              <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick="verhistorial('ABC123')">
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">Service por 10.000 Kms</a></th>
                          <td>04/02/2025</td>
                          <td>4 hs</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                            </div>
                          </td>
                          <td>
                              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Sergio: Fija disponibilidad orden">
                                <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle activo" width="35" height="35" title="Cesar: Cambio de una cubierta">  
                              </a>
                          </td>
                          <td><span class="badge bg-warning">En proceso</span></td>
                          <td>
                            <a href='#'>
                              <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick="verhistorial('ABC123')">
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">Service por 20.000 Kms</a></th>
                          <td>04/02/2025</td>
                          <td>1 hs</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                            </div>
                          </td>
                          <td>
                              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Sergio: Fija disponibilidad orden">
                                <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle activo" width="35" height="35" title="Cesar: Cambio de una cubierta">  
                              </a>
                          </td>
                          <td><span class="badge bg-warning">En proceso</span></td>
                          <td>
                            <a href='#'>
                              <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick="verhistorial('ABC123')">
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">Service por 50.000 Kms</a></th>
                          <td>04/02/2025</td>
                          <td>6 hs</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                            </div>
                          </td>
                          <td>
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" >
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Sergio: Fija disponibilidad orden">
                                <img src="assets/img/team-2.jpg" alt="Profile" class="rounded-circle activo" width="35" height="35" title="Tito: Cambio Aceite">
                                <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle activo" width="35" height="35" title="Cesar: Cambio de una cubierta">  
                            </a>
                          </td>
                          <td><span class="badge bg-danger">Demorado</span></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <th scope="row"><a href="#">Service por 50.000 Kms</a></th>
                          <td>03/02/2025</td>
                          <td>0 hs</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                          </td>
                          <td>
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" >
                              <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="25" height="25" title="Sergio: Fija disponibilidad orden">
                            </a>
                          </td>
                          <td><span class="badge bg-info text-dark">En Espera</span></td>
                          <td>&nbsp;</td>
                        </tr>
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