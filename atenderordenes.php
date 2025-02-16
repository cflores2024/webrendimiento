<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "/configuracion/conexion.php";

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
  POR OTRO LADO LAS TAREAS PUEDEN TENER LOS SIGUIENTES ESTADOS
  * D => DISPONIBLES PARA SU ATENCION
  * P => EN PROCESO SE ESTA ATENDIENDO
  * F => TAREA TERMINADA
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

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
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
              <span><? echo $tipousu; ?></span>
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
      <h1>Atender Ordenes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="buscadortareas.php">Gestión ordenes</a></li>
          <li class="breadcrumb-item active">Ordenes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Toma de Ordenes de Tareas</h5>
              <p>Permite que un empleado pueda tomar algunas de las tareas disponibles.</p>
              <!-- Table with stripped rows -->
              <?php

                  $sql = "SELECT a.`numeroorden`,a.`idtarea`,b.`patente`,c.`descripciontarea`,a.`observacion`,d.`idempleado`,a.`estado`,(SELECT xx.`urlfoto` FROM personas xx WHERE xx.accion!='B' AND xx.`idpersona`=d.idempleado) AS foto
                          FROM detalleorden a INNER JOIN numeroorden b ON (a.`numeroorden`=b.`numorden` AND b.`accion`!='B')
                                              INNER JOIN tareas c ON (a.`idtarea`=c.`idtarea` AND c.`accion`!='B')
                                              LEFT JOIN afectadostareas d ON (a.`numeroorden`=d.`numorden` AND a.`idtarea`=d.`idtarea`) 
                          WHERE a.`estado`!='S' AND a.`accion`!='B'
                          GROUP BY a.`numeroorden`,a.`idtarea`,b.`patente`,c.`descripciontarea`,a.`observacion`,d.`idempleado`,a.`estado`
                          ORDER BY a.`numeroorden`,a.`idtarea`;";

                  $con=conectar();

                  $result = mysqli_query($con,$sql);
              ?>
    
               <!-- Table with stripped rows -->
               <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">N° Orden</th>
                        <th scope="col">Patente</th>
                        <th scope="col">Tarea</th>
                        <th scope="col">Afectados</th>
                        <th scope="col">Estado</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php
                        $lsfotos="";
                        $orden="";
                        $idtarea="";
                        $filas="";

                        while($row = mysqli_fetch_array($result))
                        {
                           if (($orden==$row['numeroorden'])&&($idtarea==$row['idtarea']))
                           {
                                if (strlen($row['foto'])>0)
                                {
                                    $lsfotos=$lsfotos."<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30'>";
                                }
                                else
                                {
                                    $lsfotos=$lsfotos."&nbsp;";
                                }
                           }
                           else
                           {
                                if (strlen($orden)>0)
                                {
                                    $filas=$filas."
                                                    <tr>
                                                        <th scope='row'><a href='#'>#".$orden."</a></th>
                                                        <td>".$matricula."</td>
                                                        <td>".$tarea."</td>
                                                        <td>".$lsfotos."</td>";
                                    
                                    switch($estado)
                                    {
                                        case "D":
                                                $filas=$filas."
                                                                <td><span class='badge bg-info text-dark'>En Espera</span></td>
                                                                <td>
                                                                    <a href='#'>
                                                                        <img src='assets/img/usu_add.png' alt='Sumarse a tarea' srcset=''>
                                                                    </a>
                                                                </td>
                                                                <td> 
                                                                    &nbsp;
                                                                </td>
                                                                <td> 
                                                                    &nbsp;
                                                                </td></tr>";
                                            break;
                                        case "P":
                                                $filas=$filas."
                                                                <td><span class='badge bg-warning'>En proceso</span></td>
                                                                <td>
                                                                    <a href='#'>
                                                                    <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' srcset=''>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href='#'>
                                                                    <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' srcset=''>
                                                                    </a>
                                                                </td>
                                                                <td> 
                                                                    &nbsp;
                                                                </td></tr>";
                                            break;
                                        case "F":
                                                $filas=$filas."
                                                                <td><span class='badge bg-success'>Finalizado</span></td>
                                                                <td>
                                                                    &nbsp;
                                                                </td>
                                                                <td> 
                                                                    &nbsp;
                                                                </td>
                                                                <td>
                                                                    <a href='#'>
                                                                        <img src='assets/img/tarea_historia.png' alt='Historial auto' srcset=''>
                                                                    </a>
                                                                </td></tr>";
                                        break;
                                    }
                                }

                                $orden=$row['numeroorden'];
                                $idtarea=$row['idtarea'];
                                $matricula=$row['patente'];
                                $tarea=$row['descripciontarea'];
                                $estado=$row['estado'];
                                
                                if (strlen($row['foto'])>0)
                                {
                                  $lsfotos="<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30'>";
                                }
                                else
                                {
                                  $lsfotos="&nbsp;";
                                }
                            }   
                        }

                        $filas=$filas."
                                        <tr>
                                            <th scope='row'><a href='#'>#".$orden."</a></th>
                                            <td>".$matricula."</td>
                                            <td>".$tarea."</td>
                                            <td>".$lsfotos."</td>";
                        
                        switch($estado)
                        {
                            case "D":
                                    $filas=$filas."
                                                    <td><span class='badge bg-info text-dark'>En Espera</span></td>
                                                    <td>
                                                        <a>
                                                            <img src='assets/img/usu_add.png' alt='Sumarse a tarea' srcset=''>
                                                        </a>
                                                    </td>
                                                    <td> 
                                                        &nbsp;
                                                    </td>
                                                    <td> 
                                                        &nbsp;
                                                    </td></tr>";
                                break;
                            case "P":
                                    $filas=$filas."
                                                    <td><span class='badge bg-warning'>En proceso</span></td>
                                                    <td>
                                                        <a>
                                                        <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' srcset=''>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a>
                                                        <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' srcset=''>
                                                        </a>
                                                    </td>
                                                    <td> 
                                                        &nbsp;
                                                    </td></tr>";
                                break;
                            case "F":
                                    $filas=$filas."
                                                    <td><span class='badge bg-success'>Finalizado</span></td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td> 
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        <a>
                                                            <img src='assets/img/tarea_historia.png' alt='Historial auto' srcset=''>
                                                        </a>
                                                    </td></tr>";
                            break;
                        }
    
                        desconectar($con);

                        echo $filas;
                    ?>

                        <!--tr>
                            <th scope="row"><a href="#">#2457</a></th>
                            <td>ADS4575</td>
                            <td>Frenos</td>
                            <td>
                                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                    <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                                    <img src="assets/img/team-2.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                                </a>
                            </td>
                            <td><span class="badge bg-info text-dark">En Espera</span></td>
                            <td>
                                <a>
                                    <img src="assets/img/usu_add.png" alt="Sumarse a tarea" srcset="">
                                </a>
                            </td>
                            <td> 
                                &nbsp;
                            </td>
                            <td>
                                <a>
                                    <img src="assets/img/tarea_historia.png" alt="Historial auto" srcset="">
                                </a>
                            </td>
                        </tr>
                      <tr>
                        <th scope="row"><a href="#">#2457</a></th>
                        <td>ADS434</td>
                        <td>Aceite</td>
                        <td>
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                              <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                              <img src="assets/img/team-2.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                              <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                            </a>
                        </td>
                        <td><span class="badge bg-success">Finalizado</span></td>
                        <td>
                            &nbsp;
                        </td>
                        <td> 
                            &nbsp;
                        </td>
                        <td>
                            <a>
                                <img src="assets/img/tarea_historia.png" alt="Historial auto" srcset="">
                            </a>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2147</a></th>
                        <td>ADS4745</td>
                        <td>Filtro</td>
                        <td>
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                              <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                              <img src="assets/img/team-3.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                              <img src="assets/img/team-4.jpg" alt="Profile" class="rounded-circle" width="30" height="30">
                            </a>
                        </td>
                        <td><span class="badge bg-warning">En proceso</span></td>
                        <td>
                            <a>
                              <img src="assets/img/usu_dele.png" alt="Desvincularse de tarea" srcset="">
                            </a>
                        </td>
                        <td>
                            <a>
                              <img src="assets/img/atender_tarea.png" alt="Continuar con tarea" srcset="">
                            </a>
                        </td>
                        <td> 
                            &nbsp;
                        </td>
                      </tr-->
                 
                      
                    </tbody>
              </table>
              <!-- End Table with stripped rows -->
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
