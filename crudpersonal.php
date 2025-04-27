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
    $fechaaccion=date("Y-m-d H:i:s"); 

    $txtfoto="";
    $txtapellido="";
    $txtnombre="";
    $txtnombcorto="";
    $txtnumsocio="";
    $txtdni="";
    $txtfnac="";
    $txtdire="";
    $txttel="";
    $txtemail="";
    $txtpass="";
    $txtapto="";
    $txtfini="";
    $txtffin="";
    $idsocio="";
    $accion="";
    $j=0;
    $lsiddisciplinas[]="";
    $lsact="";

    if (isset($_GET['idpersona']))
    {
       //SE RECUPERAN LOS DATOS DEL SOCIO
       $idsocio=$_GET["idpersona"];
       $accion=$_GET["accion"];
      
      //SE PRESIONO BOTONES DE ACTUALIZAR DATOS O PASSWORD
      if (isset($_GET['btn']))
      {
        //DETERMINAR ACCIÓN A REALIZAR SOBRE LOS DATOS DEL SOCIO SELECCIONADO
        switch ($_GET['btn'])
        {
          case "ActDatos"://SE ACTUALIZAN SOLAMENTE LOS DATOS DEL PERSONAL SIN LA FOTO Y SIN PASSWORD
                          $txtapellido=$_GET['txtapellido'];
                          $txtnombre=$_GET['txtnombre'];
                          $txtnombcorto=$_GET['txtnombcorto'];
                          $txtnumsocio=$_GET['txtnumsocio'];
                          $txtdni=$_GET['txtdni'];
                          $txtfnac=$_GET['txtfnac'];
                          $txtdire=$_GET['txtdire'];
                          $txttel=$_GET['txttel'];
                          $txtemail=$_GET['txtemail'];
                          //ACTUALIZO DATOS DEL PERSONAL SELECCIONADO
                          $sql="UPDATE personas SET apellido=?,nombre=?,nombrecortousu=?,dni=?,nrosocio=?,domicilio=?,fnacimiento=?,emailusuario=?,tel=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                WHERE (idpersona=?);";

                          $con=conectar();
                          $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                          mysqli_stmt_bind_param($sentencia,'sssssssssssss',$txtapellido,$txtnombre,$txtnombcorto,$txtdni,$txtnumsocio,$txtdire,$txtfnac,$txtemail,$txttel,$accion,$id,$fechaaccion,$idsocio);
                          $respsoc=mysqli_stmt_execute($sentencia);
                        
                          desconectar($con);
                          
                          if ($respsoc)  
                          {
                            $accion="OK";
                          }
                          else
                          {
                            $accion="ERROR2";
                          }
          break;    
          case "ActApto"://SE ACTUALIZA EL ESTADO DE INGRESO Y FECHA DE DURACCION COMO PERSONAL
                      $txtapto=$_GET['cbapto'];
                      $txtfini=$_GET['fini'];
                      $txtffin=$_GET['ffin'];
                      
                      $sql="UPDATE personas SET aptoingreso=?,finiapto=?,ffinapto=?,accion=?,idempleadoaccion=?,fechaaccion=?
                            WHERE (idpersona=?);";

                      $con=conectar();
                      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                      mysqli_stmt_bind_param($sentencia,'sssssss',$txtapto,$txtfini,$txtffin,$accion,$id,$fechaaccion,$idsocio);
                      $respact=mysqli_stmt_execute($sentencia);
                    
                      desconectar($con);
                      
                      if ($respact)  
                      {//ACTUALIZACION OK
                        $accion="OK";
                      }
                      else
                      {//ERROR EN LA EJECUCION DEL SQL
                        $accion="ERROR";
                      }
          break;
          case "ActPass"://SE ACTUALIZA EL PASSWORD DEL PERSONAL
                          $txtpass=$_GET['newpassword'];
                          $txtreppass=$_GET['renewpassword'];
                          
                          if ($txtpass==$txtreppass)
                          {
                            $sql="UPDATE personas SET pass=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                  WHERE (idpersona=?);";

                            $con=conectar();
                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                            mysqli_stmt_bind_param($sentencia,'sssss',$txtpass,$accion,$id,$fechaaccion,$idsocio);
                            $respact=mysqli_stmt_execute($sentencia);
                          
                            desconectar($con);
                          }
                          else
                          {
                            $accion="ERROR";
                          }

                          if ($respact)  
                          {//ACTUALIZACION PASS OK
                            $accion="OK";
                          }
                          elseif ($accion=="ERROR")
                              {//PASS SON DIFERENTES NO SON IGUALES
                                $accion="ERROR1";
                              }
                              else
                              {//PASS ERROR EN LA EJECUCION DEL SQL
                                $accion="ERROR2";
                              }
            break;
            case "EliSoc"://SE ELIMINAN PERSONA Y SU RESPECTIVAS ACTIVIDADES
                          $accion="B";
                          $sql="UPDATE personas SET accion=?,idempleadoaccion=?,fechaaccion=?
                                WHERE (idpersona=?);";

                          $con=conectar();
                          $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                          mysqli_stmt_bind_param($sentencia,'ssss',$accion,$id,$fechaaccion,$idsocio);
                          $respsoc=mysqli_stmt_execute($sentencia);
                        
                          desconectar($con);
         
                          if ($respsoc)  
                          {//ACTUALIZACION PASS OK
                            $sql="UPDATE personasvsdisciplinas SET accion=?,idempleadoaccion=?,fechaaccion=?
                                  WHERE (idpersona=?);";

                            $con=conectar();
                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                            mysqli_stmt_bind_param($sentencia,'ssss',$accion,$id,$fechaaccion,$idsocio);
                            $respact=mysqli_stmt_execute($sentencia);
                            desconectar($con);
                          }

                          if ($respact)  
                          {
                            $accion="OKELI";
                          }
                          else
                          {
                            $accion="ERROR2";
                          }
            break;
        }
      }
      
      //OBTENIENDO DATOS DEL GET
      if ($accion=="OKELI")
      {
          $sql = "SELECT a.`urlfoto`,a.`nombrecortousu`,a.`apellido`,a.`nombre`,a.`nrosocio`,a.`dni`,a.`fnacimiento`,a.`domicilio`,a.`tel`,a.`emailusuario`,a.`pass`,b.`iddisciplina`,c.`disciplina`,a.aptoingreso,a.finiapto,a.ffinapto
                  FROM personas a INNER JOIN personasvsdisciplinas b ON (a.`idpersona`=b.`idpersona` AND b.accion='B')
                                  INNER JOIN disciplinas c ON (b.`iddisciplina`=c.`iddisciplina` AND c.`accion`!='B')
                  WHERE a.idpersona=". $idsocio ." AND a.`accion`='B';";     
          $accion="OK";
      }
      else
      {
          $sql = "SELECT a.`urlfoto`,a.`nombrecortousu`,a.`apellido`,a.`nombre`,a.`nrosocio`,a.`dni`,a.`fnacimiento`,a.`domicilio`,a.`tel`,a.`emailusuario`,a.`pass`,b.`iddisciplina`,c.`disciplina`,a.aptoingreso,a.finiapto,a.ffinapto
                  FROM personas a INNER JOIN personasvsdisciplinas b ON (a.`idpersona`=b.`idpersona` AND b.accion!='B')
                                  INNER JOIN disciplinas c ON (b.`iddisciplina`=c.`iddisciplina` AND c.`accion`!='B')
                  WHERE a.idpersona=". $idsocio ." AND a.`accion`!='B';";     
      }
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
          $txtfoto=$row['urlfoto'];
          
          $txtnombcorto=$row["nombrecortousu"];
          $txtapellido=$row["apellido"];
          $txtnombre=$row["nombre"];
          $txtnumsocio=$row["nrosocio"];
          
          $txtdni=$row["dni"];
          $txtfnac=$row["fnacimiento"];
          $txtdire=$row["domicilio"];
          $txttel=$row["tel"];
          $txtemail=$row["emailusuario"];
          $txtpass=$row["pass"];
          $txtapto=$row["aptoingreso"];

          $txtfini=$row["finiapto"];
          $txtffin=$row["ffinapto"];
          
          if (strlen($txtfini)<=0)
          {
            $txtfini=date('Y-m-d'); 
            $txtffin=date('Y-m-d', strtotime(' + 1 months'));
          }
          
          $lsiddisciplinas[$j]=$row["iddisciplina"];
          
          if (strlen($lsact)<=0) $lsact=$row["disciplina"];
          else $lsact=$lsact ." / ". $row["disciplina"];
          
          $j=$j+1;
        }
      }
      desconectar($con);
      
      //echo $sql;
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
      <a href="index.html" class="logo d-flex align-items-center">
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
      <h1>Gestión Usuarios</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
 
          <?php if ($verop=="S") echo "<li class='breadcrumb-item'><a href='buscadorpersonal.php'>Buscador Personal</a></li>"; ?>
 
          <li class="breadcrumb-item active">CRUD Personal</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <span id="img1">
                <img src="assets/img/<?php echo $txtfoto; ?>" alt="Profile" class="rounded-circle">
              </span>
              <h2><?php echo $txtnombcorto; ?></h2>
              <h3>Personal</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Descripción</button>
                </li>
                
                <?php 
                  if ($verop=="S")
                  {
                ?>
                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                    </li>

                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Actualizar Clave</button>
                    </li>

                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-apto">Apto Ingreso</button>
                    </li>

                    <li class="nav-item">
                      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-carnet">Carnet</button>
                    </li>
                <?php
                  }
                ?>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Detalle Personal</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nombre</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtapellido .", ". $txtnombre; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nombre corto</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtnombcorto; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">N° Identificación</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtnumsocio; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">N° Documento</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtdni; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Disciplinas</div>
                    <div class="col-lg-9 col-md-8"><?php echo $lsact; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Fecha Nac.</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtfnac; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Domicilio</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtdire; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Telefono</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txttel; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $txtemail; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <form action="" method="get">
                    <input type="hidden" id="idpersona" name="idpersona" value="<?php echo $idsocio; ?>">
                    <input type="hidden" id="accion" name="accion" value="<?php echo $accion; ?>">
                    <input type="hidden" id="imgfoto" name="imgfoto" value="<?php echo $txtfoto; ?>">
                    <div class="row mb-3">
                      
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Imagen Perfil</label>
                        <div class="col-md-8 col-lg-9">
                          <span id="img2">
                            <img id="avatar" src="assets/img/<?php echo $txtfoto; ?>" alt="Profile" class="rounded-circle">
                          </span>
                          <div class="pt-2">
                            <input id="changeavatar" type="file" style = "display: none;">
                              <?php
                                if ($accion!="B")
                                {
                              ?>
                                  <button type="button" id="btncambiaravatar" class="btn btn-primary btn-sm" title="Subir una nueva imagen"><i class="bi bi-upload"></i></button>
                                  <button type="button" id="btneliminaravatar" class="btn btn-danger btn-sm" title="Borrar imagen"><i class="bi bi-trash"></i></button>
                              <?php
                                }
                              ?>
                          </div>
                        </div>

                    </div>

                    <div class="row mb-3">
                      <label for="txtapellido" class="col-md-4 col-lg-3 col-form-label">Apellido</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtapellido" type="text" class="form-control" id="txtapellido" placeholder="Ingrese apellido" value='<?php echo $txtapellido; ?>'>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtnombre" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnombre" type="text" class="form-control" id="txtnombre" placeholder="Ingrese nombres" value='<?php echo $txtnombre; ?>'>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtnombcorto" class="col-md-4 col-lg-3 col-form-label">Nombre Corto</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnombcorto" type="text" class="form-control" id="txtnombcorto" minlength="4" maxlength="15" placeholder="Ingrese un nombre corto para el empleado" value='<?php echo $txtnombcorto; ?>'>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtnumsocio" class="col-md-4 col-lg-3 col-form-label">Identificación</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtnumsocio" type="text" class="form-control" id="txtnumsocio" placeholder="Ingrese número identificación" value='<?php echo $txtnumsocio; ?>'>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtdni" class="col-md-4 col-lg-3 col-form-label">N° Documento</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtdni" type="text" class="form-control" id="txtdni" placeholder="Ingrese número dni" value='<?php echo $txtdni; ?>' required>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtfnac" class="col-md-4 col-lg-3 col-form-label">Fecha Nac.</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtfnac" type="date" class="form-control" id="txtfnac" value='<?php echo $txtfnac; ?>'>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txtdire" class="col-md-4 col-lg-3 col-form-label">Domicilio</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtdire" type="text" class="form-control" id="txtdire" value='<?php echo $txtdire; ?>' placeholder="Ingrese domicilio">
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="txttel" class="col-md-4 col-lg-3 col-form-label">Teléfono</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txttel" type="tel" class="form-control" id="txttel" placeholder="381-5210-592" pattern="[0-9]{3}-[0-9]{4}-[0-9]{3}" value='<?php echo $txttel; ?>'>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="txtemail" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="txtemail" type="email" class="form-control" id="txtemail" placeholder="Ingrese email" value='<?php echo $txtemail; ?>'>
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

                              foreach($lsiddisciplinas as $i)
                              {
                                if ($id==$i) $encontrado=true;
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
                      
                        if (isset($_GET['btn']))
                        {
                          switch($_GET['btn'])
                          {
                            case "ActDatos":
                                            if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                                            elseif ($accion=="ERROR2") 
                                              {
                                                echo "<p>Error en la acción!!!!</p>"; 
                                                echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                                              }
                            break;
                            case "EliSoc":
                                          if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                                          elseif ($accion=="ERROR2") 
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
                          if ($accion=="B") echo "<button id='btn' name='btn' value='EliSoc' type='submit' class='btn btn-primary'>Eliminar Persona</button>";
                          else echo "<button id='btn' name='btn' value='ActDatos' type='submit' class='btn btn-primary'>Actualizar Datos</button>";
                        }
                        
                      ?>
                    </div>
                  </form>
                  <!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade profile-change-password pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>
                    
                    <input type="hidden" id="idpersona" name="idpersona" value="<?php echo $idsocio; ?>">
                    <input type="hidden" id="accion" name="accion" value="<?php echo $accion; ?>">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Actual Clave</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword" <?php if (strlen($txtpass)>0) echo "value=".$txtpass; else echo ""; ?>>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nuevo Clave</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Reescribir Clave</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                    <?php
                    
                        if (isset($_GET['btn']))
                        {
                          if ($_GET['btn']=="ActPass")
                          {
                            if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                            elseif ($accion=="ERROR1") 
                                {
                                  echo "<p>Las contraseñas no son iguales. Controle!!!!</p>"; 
                  
                                  if ($accion!="B") echo  "<button id='btn' name='btn' value='ActPass' type='submit' class='btn btn-primary'>Actualizar Password</button>";
                                }
                                elseif ($accion=="ERROR2")
                                    {
                                      echo "<p>Error en la actualización de los datos!!!!</p>"; 
                                      if ($accion!="B") echo  "<button id='btn' name='btn' value='ActPass' type='submit' class='btn btn-primary'>Actualizar Password</button>";
                                    }
                                    elseif ($accion!="B") echo  "<button id='btn' name='btn' value='ActPass' type='submit' class='btn btn-primary'>Actualizar Password</button>";

                          }
                          elseif ($accion!="B") echo  "<button id='btn' name='btn' value='ActPass' type='submit' class='btn btn-primary'>Actualizar Password</button>";
                        }
                        elseif ($accion!="B") echo  "<button id='btn' name='btn' value='ActPass' type='submit' class='btn btn-primary'>Actualizar Password</button>";
     
                    ?>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

                <div class="tab-pane fade profile-change-apto pt-3" id="profile-change-apto">
                  <!-- ACTUALIZAR SITUACIÓN PERSONAL PARA EL INGRESO Y FECHA DE DURACIÓN DEL CARNET -->
                  <form>
                    
                    <input type="hidden" id="idpersona" name="idpersona" value="<?php echo $idsocio; ?>">
                    <input type="hidden" id="accion" name="accion" value="<?php echo $accion; ?>">
                    <div class="row mb-3">
                      <label for="cbapto" class="col-md-4 col-lg-3 col-form-label">Estado Ingreso</label>
                      <div class="col-md-8 col-lg-9">
                        <select id="cbapto" name="cbapto"  class="form-control">
                          <?php
                            if ($txtapto=="S")
                            {
                              echo "<option value='S' selected>AUTORIZADO</option>";
                              echo "<option value='N'>NO AUTORIZADO</option>";
                            }
                            else
                            {
                              echo "<option value='S'>AUTORIZADO</option>";
                              echo "<option value='N' selected>NO AUTORIZADO</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="fini" class="col-md-4 col-lg-3 col-form-label">Fecha Inicio</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fini" type="date" class="form-control" id="fini" value="<?php echo $txtfini; ?>" readonly>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="ffin" class="col-md-4 col-lg-3 col-form-label">Fecha Fin</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="ffin" type="date" class="form-control" id="ffin" value="<?php echo $txtffin; ?>" readonly>
                      </div>
                    </div>

                    <div class="text-center">
                    <?php
                    
                        if (isset($_GET['btn']))
                        {
                          if ($_GET['btn']=="ActApto")
                          {
                            if ($accion=="OK") echo "Acción realizada satisfacoriamente!!!!"; 
                            else echo "<p>Error en la actualización de los datos!!!!</p>"; 
                          }
                          elseif ($accion!="B") echo  "<button id='btn' name='btn' value='ActApto' type='submit' class='btn btn-primary'>Actualizar Estado/Fecha</button>";
                        }
                        elseif ($accion!="B") echo  "<button id='btn' name='btn' value='ActApto' type='submit' class='btn btn-primary'>Actualizar Estado/Fecha</button>";
     
                    ?>
                    </div>
                  </form><!-- End Change Estado/Fecha Form -->

                </div>

                <div class="tab-pane fade show profile-carnet" id="profile-carnet">
        
                    <!-- Card with an image on left -->
                  <div class="card mb-3">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <p>
                          <img src="assets/img/<?php echo $txtfoto; ?>" class="img-fluid rounded-start" alt="Profile">
                        </p>

                          <!-- GENERANDO CODIGO QR CON EL NUMERO DE IDENTIFICACION -->
                          <?php
                            //Agregamos la librería para genera códigos QR
                            require "phpqrcode/qrlib.php";    
                            
                            $dir = 'assets/img/avatar/';
	                          
                            //Declaramos la ruta y nombre del archivo a generar
                            $filename = $dir ."". $txtdni .".png";

                            //Parámetros de Configuración
                            $tamaño = 5; //Tamaño de Pixel
                            $level = 'Q'; //Tipo Precisión L = Baja - M = Mediana - Q = Alta - H= MáximaBaja
                            $framSize = 3; //Tamaño en blanco
                            $contenido = "http://localhost/webcomplejobelgrano/validaringreso.php?id=". $txtdni; //Texto
                            
                                  //Enviamos los parámetros a la Función para generar código QR 
                            QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
                            
                                  //Mostramos la imagen generada
                            echo "<img src='". $dir.basename($filename) ."' class='img-fluid rounded-start' alt='Profile'>";  
                          ?>
                          <!-- FIN DEL GENERADOR DE CODIGO -->
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title">Datos Empleado - Mantenimiento</h5>
                          <div class="row">
                            <div class="col-lg-4 col-md-5 label ">Apellidos:</div>
                            <input name="txtapellido" type="text" class="form-control" id="txtapellido" value='<?php echo $txtapellido; ?>' disabled>
                          </div>
                          
                          <div class="row">
                            <div class="col-lg-4 col-md-5 label ">Nombres:</div>
                            <input name="txtnombre" type="text" class="form-control" id="txtnombre" value='<?php echo $txtnombre; ?>' disabled>
                          </div>
                          
                          <div class="row">
                            <div class="col-lg-6 col-md-7 label ">Identificación:</div>
                            <input name="txtnumsocio" type="text" class="form-control" id="txtnumsocio" value='<?php echo $txtnumsocio; ?>' disabled>
                          </div>
                          
                          <div class="row">
                            <div class="col-lg-5 col-md-6 label">Teléfono:</div>
                            <input name="txttel" type="tel" class="form-control" id="txttel" value='<?php echo $txttel; ?>' disabled>
                          </div>

                          <div class="row">
                            <div class="col-lg-5 col-md-6 label">&nbsp;</div>

                              <?php
                    
                                if ($accion!="B")
                                {
                                  if ($txtapto=="S")
                                  {
                                    echo "<button type='button' class='btn btn-primary'>Generar Carnet</button>"; 
                                  }
                                  else
                                  {
                                    echo  "<button type='button' class='btn btn-primary' disabled='disabled'>Generar Carnet</button>";
                                  }
                                }
                           
                              ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- End Card with an image on left -->

                </div>
              </div><!-- End Bordered Tabs -->

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
