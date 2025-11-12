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
    function compararmecanicos()
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
      let datosid="";
      // Obtenemos los checkbox que estan checked de una tabla especifica, en este caso tel que tiene el id="tableOne"
      document.querySelectorAll('#tablemec input[type=checkbox]').forEach(function(checkElement) {
          if (checkElement.checked == true) datosid=datosid+"-"+checkElement.value;
      });

      alert (datosid);
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsinforme").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infocomparamecanicos.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num+'&datosid='+datosid, false);
        xmlhttp.send();
      }
    }

    function limpiar() 
    {
      const fechaInput = document.getElementById('txtfini');
      const hoy = new Date();
      
      //alert(hoy);

      fechaInput.valueAsDate = hoy;
      //document.getElementById("txtfini").valueAsDate = hoy;
      document.getElementById("txtffin").value=factual;
      document.getElementById("txttitulo").value="";
      document.getElementById("txtnumorden").value="";
      document.getElementById("lsinforme").innerHTML ="<br><div style='text-align: center;'>Complete los filtros y luego presione el botón de buscar</div></br>";
    }

    function infototalordenes() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
      let emp=document.getElementById("txtempleado").value;
          
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infototalordenes.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num+'&emp='+emp, false);
        xmlhttp.send();
      }
    }

    function infoordenesdemoradas() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infodemoradas.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num, false);
        xmlhttp.send();
      }
    }

    function infoordenesterminadas() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('INFOTERMINADAS-DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoterminadas.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num, false);
        xmlhttp.send();
      }
    }

    function infoordenesenproceso() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoenproceso.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num, false);
        xmlhttp.send();
      }
    }

    function infohistorialmecanico() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
      let emp=document.getElementById("txtempleado").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('HISTORIAL DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infohistorialmecanico.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num+'&emp='+emp, false);
        xmlhttp.send();
      }
    }

    function deshabilitaRetroceso()
    {
      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash="";}
    }

    function infohorastrabajadasmecanico() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
      let emp=document.getElementById("txtempleado").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infohorastrabajadasmecanico.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num+'&emp='+emp, false);
        xmlhttp.send();
      }
    }

    function infoempleadosociosos() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let emp=document.getElementById("txtempleado").value;
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsinforme").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoempleadosociosos.php?fini='+fini+'&ffin='+ffin+'&emp='+emp, false);
        xmlhttp.send();
      }
    }

    function infotareasrealizadas() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
           // alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsinforme").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infotareasrealizadas.php?fini='+fini+'&ffin='+ffin, false);
        xmlhttp.send();
      }
    }

    function infoserviciosrealizados() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
           // alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsinforme").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoserviciosrealizados.php?fini='+fini+'&ffin='+ffin, false);
        xmlhttp.send();
      }
    }
    
    function infodondenosconocen() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
           // alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsinforme").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infodondenosconocen.php?fini='+fini+'&ffin='+ffin, false);
        xmlhttp.send();
      }
    }

    function inforevisitachasis() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
      let emp=document.getElementById("txtempleado").value;

      //alert ('JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            let datos=this.responseText;

            //alert (datos);
          
            document.getElementById("lsinforme").innerHTML =datos;
          }
        };
        xmlhttp.open('GET', 'reportes/inforevisitas.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num+'&emp='+emp, false);
        xmlhttp.send();
      }
    }

    function historial(num) 
    {
      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero chasis='+num);
            document.getElementById("lsinforme").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', './historialorden.php?num='+num+"&ver=R", false);
        xmlhttp.send();
      }
    }

    function vertabla(num)
    {
      //alert("Se muestra historial de la orden " + num);

      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
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

    function infoatencionordenes() 
    {
      let fini=document.getElementById("txtfini").value;
      let ffin=document.getElementById("txtffin").value;
      let titulo=document.getElementById("txttitulo").value;
      let num=document.getElementById("txtnumorden").value;
     
      if ((fini<=0)&&(ffin<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS FINI '+fini+' Y LA FFIN '+ffin);
      
            document.getElementById("lsdetalle").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoatencionordenes.php?fini='+fini+'&ffin='+ffin+'&titulo='+titulo+'&num='+num, false);
        xmlhttp.send();
      }
    }

    function vercontenidotarea(num,id,idtareahizo) 
    {
      //alert ('ATENDERTAREA=>se atiende la tarea numero orden='+num+' - idmecanico='+id);
      
      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('ATENDERTAREA=>se atiende la tarea numero orden='+num+' - idmecanico='+id+' - Respuesta='+this.responseText);
            
            document.getElementById("lsdetalle").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'atendertareas.php?num='+num+'&id='+id+'&mostrar=N&idtareah='+idtareahizo, false);
        xmlhttp.send();
      }
    }

    function acciondivdetallemeca()
    {
      var x = document.getElementById("lsdetameca");

      if (x.style.display === "none") 
      {
        //alert ("Mostrar detalle mecanico");
        x.style.display = "block";
      } 
      else 
      {
        //alert ("Ocultar detalle mecanico");
        x.style.display = "none";
      }
    }

    function ampliardetallemecanico(orden)
    {
      if (orden<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('DESDE JS SE RECIBIERON LOS DATOS ORDEN '+orden);
            //document.getElementById("lsdetameca").innerHTML ='DESDE JS SE RECIBIERON LOS DATOS ORDEN '+orden;
            document.getElementById("lsdetameca").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'reportes/infoampliardetallemecanico.php?orden='+orden, false);
        xmlhttp.send();    
      }
    }

  </script>
</head>

<body>
<?php
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
    <!-- End Header -->

  <!-- ======= Sidebar y Buscador ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class='nav-item'>
        <a class='nav-link ' href='home.php'>
          <i class='bi bi-reception-4'></i>
          <span>Metricas</span>
        </a>
      </li>

      <li class="nav-heading">Buscador</li>

      <form action="">
        <li class="nav-item">
          <label for="txtfini">Fecha inicio</label>
          <div class="col-sm-10">
              <input name="txtfini" type="date" class="form-control" id="txtfini" value="<?php echo date("Y-m-d");  ?>">
          </div>
        </li>

        <li class="nav-item">
          <label for="txtffin">Fecha fin</label>
          <div class="col-sm-10">
              <input name="txtffin" type="date" class="form-control" id="txtffin" value="<?php echo date("Y-m-d");  ?>">
        </li>

        <li class="nav-item">
          <label for="txtempleado">Empleados</label>
          <div class="col-sm-10">
              <input name="txtempleado" type="text" class="form-control" id="txtempleado" value="">
          </div>
        </li>
  
        <li class="nav-item">
          <label for="txtnumorden">N° Orden</label>
          <div class="col-sm-10">
              <input name="txtnumorden" type="text" class="form-control" id="txtnumorden" value="">
          </div>
        </li>

        <li class="nav-item">
          <label for="txttitulo">Titulo Orden o tarea</label>
          <div class="col-sm-10">
              <input name="txttitulo" type="text" class="form-control" id="txttitulo" value="">
          </div>
        </li>
                                
        <li class="nav-item">
          &nbsp;&nbsp;&nbsp;
          <input type="button" id="btnLimpiar" class="btn btn-primary" value="Limpiar" onclick="limpiar()">
          &nbsp;&nbsp;
          <?php
            $titulo="";

              switch($_GET['op'])
              {
                case "TO"://TOTAL DE ORDENES
                          $titulo="Total de ordenes";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infototalordenes()'>";
                break;
                case "DE"://ORDENES DEMORADAS
                          $titulo="Total de ordenes demoradas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoordenesdemoradas()'>";
                break;
                case "TE"://ORDENES TERMINADAS/FINALIZADAS
                          $titulo="Total de ordenes finalizadas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoordenesterminadas()'>";
                break;
                case "EC"://ORDENES EN PROCESOS
                          $titulo="Ordenes en proceso";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoordenesenproceso()'>";
                break;
                case "FM"://ORDENES TERMINADAS POR MECANICOS
                          $titulo="Cantidad de ordenes terminadas por mecanicos";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infohistorialmecanico()'>";
                break;
                case "TI"://HORAS TRABAJADAS POR MECANICOS
                          $titulo="Horas trabajadas de mecanicos por tareas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infohorastrabajadasmecanico()'>";
                break;
                case "EO"://EMPLEADOS OCIOSOS O QUE NO HICIERON NADA DE NADA
                          $titulo="Empleados sin tareas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoempleadosociosos()'>";
                break;
                case "AO"://ATENCIO DE ORDENES
                          $titulo="Tiempo de atencion de ordenes";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoatencionordenes()'>";
                break;
                case "TR"://TAREAS REALIZADAS
                          $titulo="Listado de tareas realizadas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infotareasrealizadas()'>";
                break;
                case "TS"://TOTAL SERVICIOS POR MODELOS REALIZADOS
                          $titulo="Listado de servicios realizados";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infoserviciosrealizados()'>";
                break;
                case "DC"://CANTIDAD TOTAL REFERIDOS O DESDE DONDE NOS CONOCEN
                          $titulo="Publidad vs Cantidad de personas";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='infodondenosconocen()'>";
                break;
                case "RE"://TOTAL DE REVISITAS QUE TUVO UN CHASIS POR PARTE DE MECANICOS
                          $titulo="Revisitas vs Empleados";
                          echo "<input type='button' id='btnBuscar' class='btn btn-primary' value='Buscar' onclick='inforevisitachasis()'>";
                break;
              }      
          ?>
          
        </li>
       
      </form>

    </ul>

  </aside>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?php echo $titulo; ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <?php
            if (($tipousu=="Administración")||($tipousu=="Gerente")) echo "<a href='home.php'>Home</a>";
            else 
            {  
              echo "<a href='atenderordenes.php?ver=P'>Home</a>";
              //echo "<a href='avancestareas.php'>Home</a>";
            }
          ?>
          </li>
          <li class="breadcrumb-item active">
          <?php
            $titulo="";

              switch($_GET['op'])
              {
                case "TO"://TOTAL DE ORDENES
                          echo "<a href='#' onclick='infototalordenes()'>Metricas avanzadas</a> ";
                break;
                case "DE"://ORDENES DEMORADAS
                          echo "<a href='#' onclick='infoordenesdemoradas()'>Metricas avanzadas</a> ";
                break;
                case "TE"://ORDENES TERMINADAS/FINALIZADAS
                          echo "<a href='#' onclick='infoordenesterminadas()'>Metricas avanzadas</a> ";
                break;
                case "EC"://ORDENES EN PROCESOS
                          echo "<a href='#' onclick='infoordenesenproceso()'>Metricas avanzadas</a> ";
                break;
                case "FM"://ORDENES TERMINADAS POR MECANICOS
                          echo "<a href='#' onclick='infohistorialmecanico()'>Metricas avanzadas</a> ";
                break;
                case "TI"://HORAS TRABAJADAS POR MECANICOS
                          echo "<a href='#' onclick='infohorastrabajadasmecanico()'>Metricas avanzadas</a> ";
                break;
                case "EO"://EMPLEADOS OCIOSOS O QUE NO HICIERON NADA DE NADA
                          echo "<a href='#' onclick='infoempleadosociosos()'>Metricas avanzadas</a> ";
                break;
                case "AO"://ATENCIO DE ORDENES
                          echo "<a href='#' onclick='infoatencionordenes()'>Metricas avanzadas</a> ";
                break;
              }      
          ?>
          </li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <span id="lsdetalle">
      <section class="section faq">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <span id="lsinforme">
                  <br>
                    <div style="text-align: center;">Complete los filtros y luego presione el botón de buscar</div>
                  </br>
                </span>
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