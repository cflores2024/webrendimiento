<!--// CHEQUEO DATOS LOGIN -->
<?php

$id=0;
$apenomb="";
$tipousu="";
$foto="";
$usu=$_GET['username'];
$pass=$_GET['password'];

  if (isset($_GET['username']))
  {
      include "/configuracion/conexion.php";

      $sql = "SELECT a.`idpersona`,CONCAT(a.`apellido`,', ',a.`nombre`) AS usuario,b.`tipopersona`,a.`urlfoto`,a.`nombrecortousu`
              FROM personas a INNER JOIN tipopersona b ON (a.`idtipopersona`=b.`idtipopersona`)
              WHERE a.`accion`!='B' AND a.`emailusuario`='". $usu ."' AND a.`pass`='". $pass ."';";
      
      $con=conectar();
      
      $result = mysqli_query($con,$sql);

      while($row = mysqli_fetch_array($result))
      {
          $id=$row['idpersona'];
          $apenomb=$row['usuario'];
          $tipousu=$row['tipopersona'];
          $foto=$row['urlfoto'];
          $nombrecorto=$row['nombrecortousu'];
      }
      
      if ($id>0)
      {
        session_start();
        
        $_SESSION['id']=$id;
        $_SESSION['apenomb']=$apenomb;
        $_SESSION['tipo']=$tipousu;
        $_SESSION['foto']=$foto;
        $_SESSION['nombrecorto']=$nombrecorto;
      }

      desconectar($con);

     // echo $id;
     //REDIRIJO A PAG DEL MENU PRINCIPAL SI EXISTE USUARIO INGRESADO
     if ($id>0)
     {
      header('Location: home.php');
      exit;
     }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - Gestión de mantenimiento</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
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
  <script>
    //FUNCION QUE NO DEJA QUE SE PUEDA VOLVER HACIA LA PAG ANTERIOR
    function deshabilitaRetroceso()
    {
      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash="";}
  }
  </script>

</head>

<body onload="deshabilitaRetroceso()">

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Mantenimiento</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login Usuario</h5>
                    <p class="text-center small">Ingrese sus datos de usuario & password</p>
                  </div>

                  <form class="row g-3 needs-validation" action="index.php" method="get" novalidate>

                    <div class="col-12">
                      <label for="txtusu" class="form-label">Usuario</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="txtusu" value="<?php echo $usu; ?>" required>
                        <div class="invalid-feedback">Por favor ingrese su nombre de usuario!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="txtpass" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="txtpass" value="<?php echo $pass; ?>" required>
                      <div class="invalid-feedback">Por favor ingrese su password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Recuerdame en este equipo</label>
                      </div>
                    </div>

<?php
                  if (($id<=0)&&(strlen($usu)>0))
                  {
?>
                    <div class="col-12">
                      <label class="form-check-label" for="rememberMe" style="color:#FF0000";>No existe usuario ingresado en base!!!</label>
                    </div>
<?php
                  }
?>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" onclick="loginusuario()">Login</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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