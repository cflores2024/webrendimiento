<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  $txtdisciplina=$txtobservacion=$txtcolor="";
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
    $iddisciplina="0";
    $accion="...";
    
    //SE RECUPERAN LOS DATOS DE LA NUEVA DISCIPLINA
    if (isset($_POST['txtdisciplina']))
    {
      //OBTENIENDO DATOS DEL POST
      $txtdisciplina=$_POST["txtdisciplina"];
      $txtobservacion=$_POST["txtobservacion"];
      $accion="N";
      $fechaaccion=date("Y-m-d H:i:s"); 
    
      //ALTA DEL NUEVO SOCIO
      $sql="INSERT INTO disciplinas (disciplina,observacion,accion,idempleadoaccion,fechaaccion)
            VALUES (?,?,?,?,?);";

      $con=conectar();
      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
      mysqli_stmt_bind_param($sentencia,'sssss',$txtdisciplina,$txtobservacion,$accion,$id,$fechaaccion);
      $resp=mysqli_stmt_execute($sentencia);
    
      desconectar($con);
    
      if ($resp)  
      {
        //RECUPERO ID DEL NUEVO SOCIO
        $sql = "SELECT a.`iddisciplina` FROM disciplinas a WHERE `accion`!='B' AND a.disciplina='".$txtdisciplina."';";
       
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
            $iddisciplina=$row['iddisciplina'];
          }

          desconectar($con);
          
          if ($resp)  
          {
            $accion="OK";
          }
          else
          {
            $accion="ERROR";
          }
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

</head>

<body>

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
      <h1>Especialidades</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="buscadordisciplinas.php">Buscador especialidades</a></li>
          <li class="breadcrumb-item active">Nueva Especialidad</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nueva Especialidad</h5>
                  <!-- Profile Edit Form -->
                  <form action="" method="POST" id="form_crear_cuenta_alumno">
                    <div class="row mb-3">
                      <label for="txtdisciplina" class="col-md-4 col-lg-3 col-form-label">Nombre Especialidad</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtdisciplina" type="text" class="form-control" id="txtdisciplina" placeholder="Ingrese especialidad" <?php if (strlen($txtdisciplina)>0) echo "value='". $txtdisciplina ."'"; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtobservacion" class="col-md-4 col-lg-3 col-form-label">Observación</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtobservacion" type="text" class="form-control" id="txtobservacion" placeholder="Ingrese observación disciplina" <?php if (strlen($txtobservacion)>0) echo "value='".$txtobservacion ."'" ?>>
                      </div>
                    </div>

                    <div class="text-center">
                      <?php 
                        
                        if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                        elseif ($accion=="ERROR") echo "Error en la acción!!!!"; 
                            else echo  "<button type='submit' class='btn btn-primary'>Guardar</button>";
                            
                      ?>
                    </div>
                  </form>
                  <!-- End Profile Edit Form -->

            </div>
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

</body>

</html>
