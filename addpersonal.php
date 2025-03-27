<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  $txtapellido=$txtnombre=$txtnombcorto=$txtnumsocio="";
  $txtdni=$txtfnac=$txtdire="";
  $txttel=$txtemail="";
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
    $idsocio="0";
    $accion="...";
    
    //SE RECUPERAN LOS DATOS DEL NUEVO SOCIO
    if (isset($_GET['txtnumsocio']))
    {
      //OBTENIENDO DATOS DEL GET
      $apto="S";
      $txtapellido=$_GET["txtapellido"];
      $txtnombre=$_GET["txtnombre"];
      $txtnombcorto=$_GET["txtnombcorto"];
      $txtnumsocio=$_GET["txtnumsocio"];
      $txtdni=$_GET["txtdni"];
      $txtfnac=$_GET["txtfnac"];
      $txtdire=$_GET["txtdire"];
      $txttel=$_GET["txttel"];
      $txtemail=$_GET["txtemail"];
      $accion="N";
      $fechaaccion=date("Y-m-d H:i:s"); 
      $idtipoper="";
      $idarea="4";
      $txtfini=date('Y-m-d'); 
      $txtffin=date('Y-m-d', strtotime(' + 1 months'));


      //ALTA DEL NUEVO SOCIO
     /* switch ($_GET['lsdisciplinas'])
      {
        case "Administrador":
          $idtipoper="2";
          break;
        case "Mecanico":
          $idtipoper="3";
          break;
        case "Gerencia":
          $idtipoper="4";
          break;
      }*/
      foreach($_GET['lsdisciplinas'] as $idtipoper)
      {
        $sql="INSERT INTO personas (apellido,nombre,nombrecortousu,dni,nrosocio,domicilio,fnacimiento,idtipopersona,emailusuario,tel,idoficina,aptoingreso,finiapto,ffinapto,accion,idempleadoaccion,fechaaccion)
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        $con=conectar();
        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'sssssssssssssssss',$txtapellido,$txtnombre,$txtnombcorto,$txtdni,$txtnumsocio,$txtdire,$txtfnac,$idtipoper,$txtemail,$txttel,$idarea,$apto,$txtfini,$txtffin,$accion,$id,$fechaaccion);
        $respsoc=mysqli_stmt_execute($sentencia);
               
        desconectar($con);
        
        if ($respsoc)  
        {
          //RECUPERO ID DEL NUEVO SOCIO
          
          $sql = "SELECT a.`idpersona` FROM personas a WHERE `accion`!='B' AND a.dni='".$txtdni."';";
          $respact="";

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
              $idsocio=$row['idpersona'];
            }
          }

          desconectar($con);
      
          //ALTA EN LAS DISCIPLINAS DONDE SE INSCRIBE
          /*foreach($_GET['lsdisciplinas'] as $i)
          {*/
            $sql="INSERT INTO personasvsdisciplinas (idpersona,iddisciplina,accion,idempleadoaccion,fechaaccion)
                  VALUES (?,?,?,?,?);";

            $con=conectar();
            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
            mysqli_stmt_bind_param($sentencia,'sssss',$idsocio,$idtipoper,$accion,$id,$fechaaccion);
            $respact=mysqli_stmt_execute($sentencia);
            desconectar($con);
        // }
              
          if ($respact)  
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

  <title>Gestión de mantenimiento</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
            <img src="assets/img/<?php echo $foto; ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $nombrecorto; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $apenomb; ?></h6>
              <span><?php echo $tipousu; ?>r</span>
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
      <h1>Personal</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="buscadorpersonal.php">Buscador personal</a></li>
          <li class="breadcrumb-item active">Nuevo Personal</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nuevo Perfil</h5>
          
                  <!-- Profile Edit Form -->
                  <form action="" method="get">
                    <div class="row mb-3">
                      <label for="txtapellido" class="col-md-4 col-lg-3 col-form-label">Apellido</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtapellido" type="text" class="form-control" id="txtapellido" placeholder="Ingrese apellido" <?php if (strlen($txtapellido)>0) echo "value=".$txtapellido; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtnombre" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnombre" type="text" class="form-control" id="txtnombre" placeholder="Ingrese nombres" <?php if (strlen($txtnombre)>0) echo "value=".$txtnombre; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtnombcorto" class="col-md-4 col-lg-3 col-form-label">Nombre Corto</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnombcorto" type="text" class="form-control" id="txtnombcorto" minlength="4" maxlength="15" placeholder="Ingrese un nombre corto" <?php if (strlen($txtnombcorto)>0) echo "value=".$txtnombcorto; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtnumsocio" class="col-md-4 col-lg-3 col-form-label">Identificación</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnumsocio" type="text" class="form-control" id="txtnumsocio" placeholder="Ingrese número identificación" <?php if (strlen($txtnumsocio)>0) echo "value=".$txtnumsocio; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtdni" class="col-md-4 col-lg-3 col-form-label">N° Documento</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtdni" type="text" class="form-control" id="txtdni" placeholder="Ingrese número dni" <?php if (strlen($txtdni)>0) echo "value=".$txtdni; else echo ""; ?> required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtfnac" class="col-md-4 col-lg-3 col-form-label">Fecha Nac.</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtfnac" type="date" class="form-control" id="txtfnac" <?php if (strlen($txtfnac)>0) echo "value=".$txtfnac; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtdire" class="col-md-4 col-lg-3 col-form-label">Domicilio</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtdire" type="text" class="form-control" id="txtdire" placeholder="Ingrese domicilio" <?php if (strlen($txtdire)>0) echo "value=".$txtdire; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txttel" class="col-md-4 col-lg-3 col-form-label">Teléfono</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txttel" type="tel" class="form-control" id="txttel" placeholder="381-5210-592" pattern="[0-9]{3}-[0-9]{4}-[0-9]{3}" <?php if (strlen($txttel)>0) echo "value=".$txttel; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtemail" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtemail" type="email" class="form-control" id="txtemail" placeholder="Ingrese email" <?php if (strlen($txtemail)>0) echo "value=".$txtemail; else echo ""; ?>>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtdisciplina" class="col-md-4 col-lg-3 col-form-label">Seleccione disciplinas</label>
                      <div class="col-md-8 col-lg-9">
                        <?php

                          $sql = "SELECT a.`iddisciplina`,a.`disciplina`
                                  FROM disciplinas a
                                  WHERE a.`accion`!='B'
                                  ORDER BY a.`disciplina`;";

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
                              $id=$row['iddisciplina'];
                              $discip=$row['disciplina'];
                              $encontrado=false;

                              if (isset($_GET['lsdisciplinas']))
                              {
                                foreach($_GET['lsdisciplinas'] as $i)
                                {
                                  if ($id==$i) $encontrado=true;
                                }
                              }
                              
                              if ($encontrado==true)
                              {
                                echo "
                                      <input type='checkbox' id='op' name='lsdisciplinas[]' value='".$row['iddisciplina']."' checked>
                                      <label for='op'>".$row['disciplina']."</label><br>
                                    ";
                              }
                              else
                              {
                                echo "
                                      <input type='checkbox' id='op' name='lsdisciplinas[]' value='".$row['iddisciplina']."'>
                                      <label for='op'>".$row['disciplina']."</label><br>
                                    ";
                              }
                            }
                          }
                          
                          desconectar($con);
                        ?>
                      </div>
                    </div>

                    <div class="text-center">
                      <?php 
                        if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                        elseif ($accion=="ERROR") echo "Error en la acción!!!!"; 
                            else echo  "<button type='submit' class='btn btn-primary'>Guardar Cambios</button>";
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
