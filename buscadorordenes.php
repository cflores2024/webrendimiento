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

  <script>
    function disponible(num)
    {
      var desc=document.getElementById("txttitulo" + num).value;
      var dias=document.getElementById("txtdias" + num).value;
      
      if ((desc.length === 0)&&(dias<= 0)) 
      {
        alert ("Se debe de indicar un nombre de orden o falta indicar cantidad de dias que toma terminar la orden");
      }
      else
      {
        //alert("Se cambia estado orden " + num + " a disponible y con el titulo "+ desc +", dias que llevara la tarea "+ dias);
        organizartareas(num,'D',desc,dias);
      }
    }

    function nodisponible(num)
    {
      //alert("Sa cambia estado orden " + num + " a no disponible!!!");

      organizartareas(num,'S','',0);
    }

    function vertabla(num)
    {
      if (num="") {
        //alert("Se requiere que ingrese un múmero de orden!!!");
        document.getElementById("lblproceso").innerHTML="Se requiere que ingrese un número de orden";
        document.getElementById("lsinfo").innerHTML="";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num);
            document.getElementById("lblproceso").innerHTML="";
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

    function verorden() 
    {
      var num=document.getElementById('txtnumorden').value;
     
      if (num=="") {
        document.getElementById("lblproceso").innerHTML="Se requiere que ingrese un número de orden";
        document.getElementById("lsinfo").innerHTML="";
        return;
      } else {
        document.getElementById("lblproceso").innerHTML="Procesando...";
        document.getElementById("lsinfo").innerHTML="";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num);
            document.getElementById("lblproceso").innerHTML="";

            document.getElementById("lsinfo").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'detalleorden.php?num='+num+'&mecanico=0', true);
        xmlhttp.send();
      }
    }

    function verhistorial() 
    {
      var num=document.getElementById('txtnumpatente').value;
    
      if (num=="") {
        document.getElementById("lblproceso").innerHTML="Se requiere que ingrese un número de chasis";
        document.getElementById("lsinfo").innerHTML="";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero patente='+num);
            document.getElementById("lblproceso").innerHTML="";
            document.getElementById("lsinfo").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'historialorden.php?num='+num+'&ver=N', false);
        xmlhttp.send();
      }
    }

    function organizartareas(orden,estado,titulo,dias) 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert("Se envia la orden numero=>"+orden+" y se lo pasa al estado de =>"+estado+", con el titulo "+titulo+", dias que dura la tarea "+dias);
        
            document.getElementById("lblproceso").innerHTML="";
            document.getElementById("lsinfo").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'organizarorden.php?orden='+orden+'&estado='+estado+'&titulo='+titulo+'&dias='+dias+'&mecanico=0', false);
        xmlhttp.send();  
    }

    function eliminarorden()
    {
      const checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
      let lsdatos="";

      for (let i = 0; i < checkboxes.length; i++) {
        //console.log(checkboxes[i].value);
        if (lsdatos.length<=0) lsdatos=checkboxes[i].value;
        else lsdatos=lsdatos+";"+checkboxes[i].value;
      }
      
      if (lsdatos.length<=0) {
        return;
      } else {
        
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          
            let resp=this.responseText;
 
            //alert("devuelve la funcion=>"+resp);
         
            if (resp=="0") 
            {//SE REALIZA LA ACTUALIZACION DE LAS ORDENES NO ELIMINADAS
              organizartareas(0,'','',0);
            }
            else
            {
              alert("ERROR EN LA ELIMINACION DE LAS ORDENES SELECCIONADAS=> "+resp);
            }
          }
        };
        
        xmlhttp.open('GET', 'eliminarordentrabajo.php?lsdatos='+lsdatos, false);
        xmlhttp.send();
      }
    }

  </script>
</head>

<body>
<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  
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
      <h1>Ordenes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <?php
            if (($tipousu=="Administración")||($tipousu=="Gerente")) echo "<a href='home.php'>Home</a>";
            else echo "<a href='avancestareas.php'>Home</a>";
          ?>
          </li>
          <li class="breadcrumb-item"><a href="buscadorordenes.php">Buscador ordenes</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Buscador Ordenes de Trabajos</h5>
                      <p>Permite realizar todas las operaciones correspondiete a Leer una ORDEN DE TRABAJO.</p>
                        <div class="text-center">  
                          <!-- General Form Elements -->
                            <form action="">
                              <div class="row mb-3">
                                <label for="txtorden" class="col-sm-2 col-form-label">N° Chasis</label>
                                <div class="col-sm-10">
                                    <input name="txtnumpatente" type="text" class="form-control" id="txtnumpatente" value="">
                                </div>
                              </div>
                              <div class="row mb-3">
                                <label for="txtorden" class="col-sm-2 col-form-label">N° Orden</label>
                                <div class="col-sm-10">
                                    <input name="txtnumorden" type="text" class="form-control" id="txtnumorden" value="">
                                </div>
                              </div>
                                                      
                              <div class="row mb-3">
                                  <div class="col-sm-10">
                                      <input type="button" id="btnBusOrden" class="btn btn-primary" value="Importar Orden" onclick="verorden()">
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="button" id="btnGestionar" class="btn btn-primary" value="Gestionar Ordenes" onclick="organizartareas(0,'','',0)">
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="button" id="btnHistorial" class="btn btn-primary" value="Ver Historial Chasis" onclick="verhistorial()">
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="button" id="btnEliminar" class="btn btn-primary" value="Eliminar Ordenes" onclick="eliminarorden()">
                                  </div>
                              </div>

                              <span id="lblproceso"></span>
                            </form>
                           
                          <!-- End General Form Elements -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <span id="lsinfo"></span>

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
