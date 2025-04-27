<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];

    $idusuario=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $idempleado="";
    $empleado="";
    $lsfotos="";
    $orden="";
    $titulo="";
    $numchasis="";
    $fila="";
    $filasaprob="";
    $filaspend="";
    $bandera="";
    $estadoorden="";
    $color="";
    $fechasolic="";
   
    //ORDENES DE TRABAJOS EN ESTADO DE PROCESO Y ORDENES DISPONIBLES
    $sql = "-- ORDENES PENDIENTES
            SELECT xx2.`numorden`,xx2.`tituloorden`,xx2.`numchasis`,

            yy.idpersona, 

            yy.`urlfoto` AS foto, 

            CONCAT(yy.apellido,',',yy.nombre) AS apenom,

            xx2.`estado`,xx2.`fechaaccion`,

            'PE' AS situacionorden, 
            (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx2.`numchasis` AND tt.numorden!=xx2.`numorden`) historial 

            FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
                                  INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
            WHERE xx2.accion!='B' AND zz.estado='P';";

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
        if ($orden==$row['numorden'])
        {
            if (strlen($row['foto'])>0)
            {
                $lsfotos=$lsfotos."<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30' title='". $empleado ."'>";
            }
            else
            {
                $lsfotos=$lsfotos."&nbsp;";
            }

            if (($idempleado==$idusuario)&&(strlen($bandera)<=0)) $bandera="del";
        }
        else
        {
            if (strlen($orden)>0)
            {
                if ($idempleado==$idusuario) $bandera="del";

                $fila="
                        <tr>
                            <th scope='row'><a href='#'>#".$orden."</a></th>
                            <td>".$titulo."</td>
                            <td>".$lsfotos."</td>";
                
                switch ($estadoorden)
                {
                  case "D": //ORDEN DISPONIBLE - AMARILLO bg-warning
                          $color="<span class='badge bg-warning'>Disponible</span>";
                  break;
                  case "P": //ORDEN EN PROCESO - VERDE bg-success 
                          $color="<span class='badge bg-success'>En proceso</span>";
                  break;
                  default: //ORDEN DEMORADA - ROJO bg-danger 
                          $color="<span class='badge bg-danger'>Atrazado</span>";
                  break;
                }

                
                $fila=$fila."
                              <td>".$color."</td>
                              <td>".$fechasolic."</td>
                              <td>
                                  <a href='#'>
                                    <img src='assets/img/ingresa.png' alt='Autoriza acceso' onclick='autoriza(\"$orden\",\"$idempleado\")'>
                                  </a>
                              </td>
                              <td> 
                                  <a href='#'>
                                    <img src='assets/img/noingresa.png' alt='No autoriza acceso' onclick='noautoriza(\"$orden\",\"$idempleado\")'>
                                  </a>
                              </td>
                              <td>";
                              if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                              else $fila=$fila."<a href='#'>
                                                  <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick='historial(\"$numchasis\")'>
                                                </a></td></tr>";
                $bandera="";
                
            }

            if (strlen($orden)>0) 
            {
              //PENDIENTE AUTORIZAR
              if ($estado=="PE") 
              {
                $filaspend=$filaspend."".$fila;
              }

              //ORDENES AUTORIZADA
              if ($estado=="AU") 
              {
                $filasaprob=$filasaprob."".$fila;
              }

              $fila="";
            }
            
            $orden=$row['numorden'];
            $titulo=$row['tituloorden'];
            $numchasis=$row['numchasis'];
            $estado=$row['situacionorden'];
            $estadoorden=$row['estado'];
            $idempleado=$row['idpersona'];
            $empleado=$row['apenom'];
            $tienehisto=$row['historial'];
            $fechasolic=$row['fechaaccion'];
                            
            if (strlen($row['foto'])>0)
            {
                $lsfotos="<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30' title='". $empleado ."'>";
            }
            else
            {
                $lsfotos="&nbsp;";
            }
        }   
      }

      $fila="
              <tr>
                  <th scope='row'><a href='#'>#".$orden."</a></th>
                  <td>".$titulo."</td>
                  <td>".$lsfotos."</td>";
      
      switch ($estadoorden)
      {
        case "D": //ORDEN DISPONIBLE - AMARILLO bg-warning
                $color="<span class='badge bg-warning'>Disponible</span>";
        break;
        case "P": //ORDEN EN PROCESO - VERDE bg-success 
                $color="<span class='badge bg-success'>En proceso</span>";
        break;
        default: //ORDEN DEMORADA - ROJO bg-danger 
                $color="<span class='badge bg-danger'>Atrazado</span>";
        break;
      }

      switch($estado)
      {
        case "AU":
                  if ($bandera=="del")
                  {
                      $fila=$fila."
                                    <td>".$color."</td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>";
                                    if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                    else $fila=$fila."<a href='#'>
                                                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick='historial(\"$numchasis\")'>
                                                      </a></td></tr>";
                  }
                  else
                  {
                      $fila=$fila."
                                    <td>".$color."</td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>";
                                    if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                    else $fila=$fila."<a href='#'>
                                                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick='historial(\"$numchasis\")'>
                                                      </a></td></tr>";
                  }

                  $bandera="";
        break;
        case "PE":
                    $fila=$fila."
                                  <td>".$color."</td>
                                  <td>".$fechasolic."</td>
                                  <td>
                                      <a href='#'>
                                        <img src='assets/img/ingresa.png' alt='Autoriza acceso' onclick='autoriza(\"$orden\",\"$idempleado\")'>
                                      </a>
                                  </td>
                                  <td> 
                                      <a href='#'>
                                        <img src='assets/img/noingresa.png' alt='No autoriza acceso' onclick='noautoriza(\"$orden\",\"$idempleado\")'>
                                      </a>
                                  </td>
                                  <td>";
                                  if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                  else $fila=$fila."<a href='#'>
                                                      <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick='historial(\"$numchasis\")'>
                                                    </a></td></tr>";
        break;
      }
    }
    
    desconectar($con);

    if ($estado=="PE") 
    {
      $filaspend=$filaspend."".$fila;
    }

    if ($estado=="AU") 
    {
      $filasaprob=$filasaprob."".$fila;
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

    <!-- =======================================================
  POR OTRO LADO LAS TAREAS PUEDEN TENER LOS SIGUIENTES ESTADOS
  * D => DISPONIBLES PARA SU ATENCION
  * P => EN PROCESO SE ESTA ATENDIENDO
  * F => TAREA TERMINADA
  ======================================================== -->
  <script>
    function vermovimientostareasvsempledos() 
    {
      location.reload();
    }

    function autoriza(num,id) 
    {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('Estodos son los datos numero orden='+num+" y idempleado="+id);
            document.getElementById("lsinfo").innerHTML=this.responseText;

            if (document.getElementById("lsinfo").value==0) 
            {
              location.reload();
            }
          }
        };
        xmlhttp.open('GET', 'autoriza.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
    }

    function noautoriza(num,id) 
    {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('DESVINCULAR numero orden='+num+" y idempleado="+id);
            document.getElementById("lsinfo").innerHTML=this.responseText;

            if (document.getElementById("lsinfo").value==0) 
            {
              location.reload();
            }
          }
        };
        xmlhttp.open('GET', 'noautoriza.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
    }

    function historial(num) 
    {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero patente='+num);
            document.getElementById("lsdetalles").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'historialorden.php?num='+num+"&ver=N", false);
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
      <h1>Autorizar Acceso Ordenes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="autorizarpedido.php">Autorizar acceso</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    
    <span id="lsdetalles">
    
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ordenes de Trabajo Pendientes de Autorizar</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope='col'>N° Orden</th>
                    <th scope='col'>Titulo Orden</th>
                    <th scope='col'>Solicitante</th>
                    <th scope='col'>Estado</th>
                    <th scope='col'>Fecha Pedido</th>
                    <th scope='col'>&nbsp;</th>
                    <th scope='col'>&nbsp;</th>
                    <th scope='col'>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                echo $filaspend; 
                ?>
                  <!--tr>
                    <th scope='row'><a href='#'>#1234</a></th>
                    <td>Servis por 10.000 Kms</td>
                    <td><img src='./assets/img/team-2.jpg' alt='Profile' class='rounded-circle' width='30' height='30'></td>
                    <td><span class='badge bg-warning'>Disponible</span></td>
                    <td>10/02/2025 12:00:00</td>
                    <td>
                        <a href='#'>
                          <img src='assets/img/ingresar.png' alt='Autorizar Participación'>
                        </a>
                    </td>
                    <td> 
                        <a href='#'>
                          <img src='assets/img/noingresar.png' alt='No Autorizar Participación'>
                        </a>
                    </td>
                    <td>
                      <a href='#'>
                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente'>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope='row'><a href='#'>#12534</a></th>
                    <td>Servis por 20.000 Kms</td>
                    <td><img src='./assets/img/team-3.jpg' alt='Profile' class='rounded-circle' width='30' height='30'></td>
                    <td><span class='badge bg-warning'>Disponible</span></td>
                    <td>12/02/2025 12:12:00</td>
                    <td>
                        <a href='#'>
                          <img src='assets/img/ingresar.png' alt='Autorizar Participación'>
                        </a>
                    </td>
                    <td> 
                        <a href='#'>
                          <img src='assets/img/noingresar.png' alt='No Autorizar Participación'>
                        </a>
                    </td>
                    <td>
                      <a href='#'>
                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente'>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope='row'><a href='#'>#12334</a></th>
                    <td>Servis por 40.000 Kms</td>
                    <td><img src='./assets/img/team-4.jpg' alt='Profile' class='rounded-circle' width='30' height='30'></td>
                    <td><span class='badge bg-success'>En proceso</span></td>
                    <td>20/02/2025 13:12:00</td>
                    <td>
                        <a href='#'>
                          <img src='assets/img/ingresar.png' alt='Autorizar Participación'>
                        </a>
                    </td>
                    <td> 
                        <a href='#'>
                          <img src='assets/img/noingresar.png' alt='No Autorizar Participación'>
                        </a>
                    </td>
                    <td>&nbsp;</td>
                  </tr-->
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>

        </div>
      </div>
    </section>
    
    <!--section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title">Movimientos de Ordenes de Trabajos Autorizadas</h5>
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope='col'>N° Orden</th>
                    <th scope='col'>Titulo Orden</th>
                    <th scope='col'>Afectados</th>
                    <th scope='col'>Autorizado</th>
                    <th scope='col'>Inicio Pedido</th>
                    <th scope='col'>Fin Pedido</th>
                    <th scope='col'>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php //echo $filasap; ?>
                  <tr>
                    <th scope='row'><a href='#'>#1234</a></th>
                    <td>Servis por 10.000 Kms</td>
                    <td>
                      <img src='./assets/img/team-4.jpg' alt='Profile' class='rounded-circle' width='30' height='30'>
                    </td>
                    <td>Si</td>
                    <td>10/02/2025 12:00:00</td>
                    <td>10/02/2025 13:00:01</td>
                    <td>
                      <a href='#'>
                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente'>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th scope='row'><a href='#'>#14234</a></th>
                    <td>Servis por 20.000 Kms</td>
                    <td>
                      <img src='./assets/img/team-2.jpg' alt='Profile' class='rounded-circle' width='30' height='30'>
                    </td>
                    <td>No</td>
                    <td>10/02/2025 12:00:00</td>
                    <td>10/02/2025 13:00:01</td>
                    <td>
                      <a href='#'>
                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente'>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </section-->
    
    <input id="lsinfo" name="lsinfo" type="hidden" value="0" />
     
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
