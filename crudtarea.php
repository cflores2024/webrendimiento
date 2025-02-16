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

    $txttarea="";
    $txttiempo="";
    $idtarea="";
    $accion="";
   
    if (isset($_GET['idtarea']))
    {
       //SE RECUPERAN LOS DATOS DE LA TAREA
       $idtarea=$_GET["idtarea"];
       $accion=$_GET["accion"];
      
      if (isset($_GET['btn']))
      {
        switch ($_GET['btn'])
        {
          case "ActDatos"://SE ACTUALIZAN DATOS TAREA
                          $txttarea=$_GET['txttarea'];
                          $txttiempo=$_GET['txttiempo'];
                          //ACTUALIZO DATOS DEL SOCIO SELECCIONADO
                          $sql="UPDATE tareas SET descripciontarea=?,tiempotarea=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                WHERE (idtarea=?);";

                          $con=conectar();
                          $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                          mysqli_stmt_bind_param($sentencia,'ssssss',$txttarea,$txttiempo,$accion,$id,$fechaaccion,$idtarea);
                          $resp=mysqli_stmt_execute($sentencia);
                        
                          desconectar($con);
                          
                        if ($resp)  
                        {
                            $accion="OK";
                        }
                        else
                        {
                            $accion="ERROR";
                        }
                    
          break;
          case "EliDis":
                        //SE CHEQUEA QUE TAREA NO ESTE EN USO DENTRO DE ALGUNA ORDEN DE TRABAJO
                        $sql="SELECT COUNT(a.`idtarea`) AS id
                              FROM detalleorden a 
                              WHERE a.`accion`!='B' AND a.`idtarea`=". $idtarea .";";

                        $con=conectar();
                        
                        $contid=0;
                        $resp=false;

                        $result = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            $contid=$row["id"];
                        }

                        desconectar($con);   

                        if ($contid<=0)
                        {
                            //SE ELIMINAN TAREA
                            $accion="B";
                            $sql="UPDATE tareas SET accion=?,idempleadoaccion=?,fechaaccion=?
                                  WHERE (idtarea=?);";

                            $con=conectar();
                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                            mysqli_stmt_bind_param($sentencia,'ssss',$accion,$id,$fechaaccion,$idtarea);
                            $resp=mysqli_stmt_execute($sentencia);
                            desconectar($con);
            
                            if ($resp)  
                            {
                              $accion="OKELI";
                            }
                            else
                            {
                              $accion="ERROR";
                            }
                        }
                        else
                        {
                            $accion="ENUSO";
                        }
            break;
        }
      }
      
      //OBTENIENDO DATOS DEL GET
      if ($accion=="OKELI")
      {
          $sql = "SELECT a.`descripciontarea`,a.tiempotarea
                  FROM tareas a
                  WHERE a.idtarea=". $idtarea ." AND a.`accion`='B';";     
          $accion="OK";
      }
      else
      {
          $sql = "SELECT a.`descripciontarea`,a.tiempotarea
                  FROM tareas a
                  WHERE a.idtarea=". $idtarea ." AND a.`accion`!='B';";     
      }
      $con=conectar();

      $result = mysqli_query($con,$sql);
      while($row = mysqli_fetch_array($result))
      {
        $txttarea=$row['descripciontarea'];
        $txttiempo=$row['tiempotarea'];
      }

      desconectar($con);   
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

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Mantenimiento</span>
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
          <li class="breadcrumb-item"><a href="buscadortareas.php">Buscador Tareas/Tiempo</a></li>
          <li class="breadcrumb-item active">CRUD Tarea/Tiempo</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tarea</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Tarea</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h5 class="card-title">Detalle Tarea</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nombre</div>
                      <div class="col-lg-9 col-md-8"><? echo $txttarea; ?></div>
                    </div>
                    </br>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Tiempo</div>
                      <div class="col-lg-9 col-md-8"><? echo $txttiempo; ?></div>
                    </div>
                  </div>

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form action="" method="get">
                      <input type="hidden" id="idtarea" name="idtarea" value="<?php echo $idtarea; ?>">
                      <input type="hidden" id="accion" name="accion" value="<?php echo $accion; ?>">
                      <div class="row mb-3">
                        
                      <div class="row mb-3">
                        <label for="txttarea" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="txttarea" type="text" class="form-control" id="txttarea" placeholder="Ingrese nombre de la tarea" value='<?php echo $txttarea; ?>'>
                        </div>
                      </div>
                
                      <div class="row mb-3">
                        <label for="txttiempo" class="col-md-4 col-lg-3 col-form-label">Tiempo Tarea</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="txttiempo" type="time" class="form-control" id="txttiempo" placeholder="Ingrese tiempo estimado" value='<?php echo $txttiempo; ?>'>
                        </div>
                      </div>
                    
                      <div class="text-center">
                        <?php
                        
                          if (isset($_GET['btn']))
                          {
                            switch($_GET['btn'])
                            {
                              case "ActDatos":
                                              if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                                              elseif ($accion=="ERROR") 
                                                {
                                                  echo "<p>Error en la acción!!!!</p>"; 
                                                  echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                                                }
                              break;
                              case "EliDis":
                                            if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                                            elseif ($accion=="ENUSO") 
                                              {
                                                echo "<p>La tarea que intenta borrar esta en uso, disvincule y pruebe de nuevo!!!!</p>"; 
                                              }
                                              else //"ERROR" 
                                              {
                                                echo "<p>Error en la acción!!!!</p>"; 
                                                echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                                              }
                              break;
                              default:
                                            echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                            }
                          }
                          else 
                          {
                            if ($accion=="B") echo "<button id='btn' name='btn' value='EliDis' type='submit' class='btn btn-primary'>Eliminar Tarea</button>";
                            else echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                          }
                          
                        ?>
                      </div>
                    </form>
                    <!-- End Profile Edit Form -->

                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
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

  <!--script src="assets/vendor/jquery321/jquery.min.js"></script-->
  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="assets/js/cambiaravatar.js"></script>
</body>

</html>
