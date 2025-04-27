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
    $idempleado="0";
    $lsfotos="0";
    $orden="0";
    $titulo="0";
    $numchasis="0";
    $fila="0";
    $filasproydis="0";
    $filasap="0";
    $bandera="";
    $estadoorden="0";
    $color="0";
   
    //ORDENES DE TRABAJOS EN ESTADO DE PROCESO Y ORDENES DISPONIBLES
    $sql = "-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
            SELECT a.`numorden`,b.`tituloorden`,b.patente,
            b.idpersonadisp AS idempleado,
              (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
              (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
              'I' AS `estado`,b.fechaentrega,'I' AS situacionorden, 
              (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=b.`numchasis` AND tt.numorden!=b.`numorden`) historial,
                          b.numchasis  
            FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
            GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.`fechaaccion`,b.`estado`,b.numchasis
            UNION
            -- ORDENES EN PROCESOS
            SELECT xx1.`numorden`,xx1.`tituloorden`,xx1.patente,
            yy1.`idempleado`,
            zz1.urlfoto AS foto, CONCAT(zz1.`apellido`,', ',zz1.`nombre`) empleado,
              xx1.`estado`,xx1.`fechaaccion`,'PR' AS situacionorden, 
              (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx1.`numchasis` AND tt.numorden!=xx1.`numorden`) historial,
              xx1.numchasis  
            FROM numeroorden xx1 INNER JOIN afectadostareas yy1 ON (xx1.`numorden`=yy1.`numorden`)
                INNER JOIN personas zz1 ON (yy1.`idempleado`=zz1.`idpersona` AND zz1.`accion`!='B')
            WHERE xx1.`accion`!='B' AND xx1.`estado`='P' AND xx1.`numorden` NOT IN  
            (
            SELECT aa.`numorden`
            FROM autorizaraccorden aa 
            WHERE aa.`accion`!='B'
            )
            UNION
            -- ORDENES DISPONIBLES
            SELECT xx2.`numorden`,xx2.`tituloorden`,xx2.`patente`,

            xx2.`idpersonadisp` AS idempleado,
            zz1.urlfoto AS foto, 
            CONCAT(zz1.`apellido`,', ',zz1.`nombre`) empleado,

            xx2.`estado`,xx2.`fechaaccion`,

            'DI' AS situacionorden, 
            (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx2.`numchasis` AND tt.numorden!=xx2.`numorden`) historial,
            xx2.numchasis
            FROM numeroorden xx2 INNER JOIN personas zz1 ON (xx2.idpersonadisp=zz1.`idpersona` AND zz1.`accion`!='B')
            WHERE xx2.accion!='B' AND xx2.estado='D' AND xx2.`numorden` NOT IN  
            (
            SELECT aa.`numorden`
            FROM autorizaraccorden aa
            WHERE aa.`accion`!='B' AND aa.`estado` IN ('P','A')
            )
            UNION
            -- ORDENES PENDIENTES
            SELECT xx2.`numorden`,xx2.`tituloorden`,xx2.`patente`,

            yy.idpersona AS idempleado,

            yy.`urlfoto` AS foto, 

            CONCAT(yy.apellido,',',yy.nombre) AS empleado,

            xx2.`estado`,xx2.`fechaaccion`,

            'PE' AS situacionorden, 
            (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx2.`numchasis` AND tt.numorden!=xx2.`numorden`) historial,  
            xx2.numchasis
            FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
                  INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
            WHERE xx2.accion!='B' AND zz.estado='P'
            UNION
            -- ORDENES AUTORIZAS
            SELECT xx2.`numorden`,xx2.`tituloorden`,xx2.`patente`,

            yy.idpersona AS idempleado,

            yy.`urlfoto` AS foto, 

            CONCAT(yy.apellido,',',yy.nombre) AS empleado,

            xx2.`estado`,xx2.`fechaaccion`,

            CASE WHEN xx2.`estado`='F' THEN 'FI' ELSE 'AU' END AS situacionorden, 
            (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx2.`numchasis` AND tt.numorden!=xx2.`numorden`) historial,  
            xx2.numchasis
            FROM numeroorden xx2  INNER JOIN autorizaraccorden zz ON (xx2.numorden=zz.numorden AND xx2.accion!='B') 
                  INNER JOIN personas yy ON (zz.idpersona=yy.idpersona AND yy.accion!='B') 
            WHERE xx2.accion!='B' AND zz.estado='A' AND xx2.estado!='F'
            ORDER BY 1,4;";

//echo $sql;

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
        if ($orden==$row['numorden'])
        {
            if (strlen($row['foto'])>0)
            {
                $lsfotos=$lsfotos."<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30'>";
            }
            else
            {
                $lsfotos=$lsfotos."&nbsp;";
            }

            $idempleado=$row['idempleado'];
            $estado=$row['situacionorden'];
            $estadoorden=$row['estado'];
            if (($idempleado==$idusuario)&&(strlen($bandera)<=0)) $bandera="del";
        }
        else
        {
            if (strlen($orden)>0)
            {
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
                  case "F": //ORDEN FINALIZADA - AZUL
                          $color="<span class='badge bg-primary'>Finalizada</span>";
                  break;
                  default: //ORDEN DEMORADA - ROJO bg-danger 
                          $color="<span class='badge bg-danger'>Atrazado</span>";
                  break;
                }

                switch($estado)
                {
                  case "FI"://ORDEN FINALIZADA
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
                                                              <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                            </a></td></tr>";
                          $bandera="";
                  break;
                  case "DI": //ORDEN DISPONIBLE
                  case "PR"://ORDEN EN PROCESO
                  case "AU"://ORDEN AUTORIZADA POR SUPERVISOR AL MECANICO
                          if ($bandera=="del")
                          {//BORRA EMPLEADO ORDEN
                              $fila=$fila."
                                            <td>".$color."</td>
                                            <td>
                                                <a href='#'>
                                                    <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' onclick='desvincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                                </a>
                                            </td>
                                           <td>
                                                <a href='#'>
                                                  <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' onclick='atendertareas(\"$orden\",\"$idusuario\")'>
                                                </a>
                                            </td>
                                            <td>"; 
                                            
                                            if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                            else $fila=$fila."<a href='#'>
                                                                <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                              </a></td></tr>";
                          }
                          else
                          {//SE SUMA EMPLEADO ORDEN
                              $fila=$fila."
                                            <td>".$color."</td>
                                            <td>
                                                <a href='#'>
                                                    <img src='assets/img/usu_add.png' alt='Sumarse a tarea' onclick='vincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                                </a>
                                            </td>
                                            <td> 
                                                &nbsp;
                                            </td>
                                            <td>"; 

                                            if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                            else $fila=$fila."<a href='#'>
                                                                <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                              </a></td></tr>";
                          }

                          $bandera="";
                  break;
                  case "PE"://ORDEN PENDIENTE DE APROBACION POR PARTE DE RESPONSABLE
                            $fila=$fila."
                                          <td>".$color."</td>
                                          <td>
                                              <a href='#'>
                                                <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' onclick='desvincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                              </a>
                                          </td>
                                          <td> 
                                              &nbsp;
                                          </td>
                                          <td>";
                                          if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                          else $fila=$fila."<a href='#'>
                                                              <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                            </a></td></tr>";
                            $bandera="";
                    break;
                }
            }

            if (strlen($orden)>0) 
            {
              if (($estado=="DI")||($estado=="PR")||($estado=="AU")||($estado=="FI")) 
              {
                $filasproydis=$filasproydis."".$fila;
              }

              if ($estado=="PE") 
              {
                $filasap=$filasap."".$fila;
              }

              $fila="";
            }
            
            $orden=$row['numorden'];
            $titulo=$row['tituloorden'];
            $numchasis=$row['numchasis'];
            $estado=$row['situacionorden'];
            $estadoorden=$row['estado'];
            $idempleado=$row['idempleado'];
            $tienehisto=$row['historial'];
            $bandera="";
                      
            if (($idempleado==$idusuario)&&(strlen($bandera)<=0)) $bandera="del";

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

      if (strlen($orden)>0)
      {
        $fila="
                <tr>
                    <th scope='row'><a href='#'>#".$orden."</a></th>
                    <td>".$titulo."</td>
                    <td>".$lsfotos."</td>";
        
        switch ($estadoorden)
        {
          case "F": //ORDEN FINALIZADA - AZUL
                  $color="<span class='badge bg-primary'>Finalizada</span>";
          break;
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
          case "FI"://ORDEN FINALIZADA
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
                                                      <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                    </a></td></tr>";
                  $bandera="";
          break;
          case "DI": //ORDEN DISPONIBLE
          case "PR"://ORDEN EN PROCESO
          case "AU"://ORDEN AUTORIZADA POR SUPERVISOR AL MECANICO
                  if ($bandera=="del")
                  {//BORRA EMPLEADO ORDEN
                      $fila=$fila."
                                    <td>".$color."</td>
                                    <td>
                                        <a href='#'>
                                            <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' onclick='desvincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                        </a>
                                    </td>
                                   <td>
                                        <a href='#'>
                                          <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' onclick='atendertareas(\"$orden\",\"$idusuario\")'>
                                        </a>
                                    </td>
                                    <td>"; 
                                    
                                    if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                    else $fila=$fila."<a href='#'>
                                                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                      </a></td></tr>";
                  }
                  else
                  {//SE SUMA EMPLEADO ORDEN
                      $fila=$fila."
                                    <td>".$color."</td>
                                    <td>
                                        <a href='#'>
                                            <img src='assets/img/usu_add.png' alt='Sumarse a tarea' onclick='vincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                        </a>
                                    </td>
                                    <td> 
                                        &nbsp;
                                    </td>
                                    <td>"; 

                                    if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                    else $fila=$fila."<a href='#'>
                                                        <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                      </a></td></tr>";
                  }

                  $bandera="";
          break;
          case "PE"://ORDEN PENDIENTE DE APROBACION POR PARTE DE RESPONSABLE
                    $fila=$fila."
                                  <td>".$color."</td>
                                  <td>
                                      <a href='#'>
                                        <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' onclick='desvincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                      </a>
                                  </td>
                                  <td> 
                                      &nbsp;
                                  </td>
                                  <td>";
                                  if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                  else $fila=$fila."<a href='#'>
                                                      <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                    </a></td></tr>";
                    $bandera="";
            break;
        }
    
        desconectar($con);

        if (($estado=="DI")||($estado=="PR")||($estado=="AU")||($estado=="FI")) 
        {
          $filasproydis=$filasproydis."".$fila;
        }

        if ($estado=="PE") 
        {
          $filasap=$filasap."".$fila;
        }
      }
      else $fila="<tr><td colspan='7' style='text-align: center;'>Sin información a mostrar</td></tr>";
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
    function iniciar(num,idtarea,idmecanico) 
    {
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
           // alert("VALORES INICIALES=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            
            var resp=this.responseText;
 
            if (resp=="0") 
            {
              //alert ("El valor de respesta fue: "+resp);
          
              atendertareas(num,idmecanico);
            }
          }
        };
        xmlhttp.open('GET', 'gestionartareamecanico.php?estado=I&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico, false);
        xmlhttp.send();
      }
    }

    function aprocesar(num,idtarea,idmecanico) 
    {
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
           // alert("VALORES INICIALES=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            
            var resp=this.responseText;
 
            if (resp=="0") 
            {
              //alert ("El valor de respesta fue: "+resp);
          
              atendertareas(num,idmecanico);
            }
          }
        };
        xmlhttp.open('GET', 'gestionartareamecanico.php?estado=P&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico, false);
        xmlhttp.send();
      }
    }

    function finalizar(num,idtarea,idmecanico) 
    {
      var obs=document.getElementById("txtobservacion").value;// "Se finaliza por prueba de CESAR";

      if ((num<=0)&&(idtarea<=0)&&(idmecanico<=0)) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('VINCULAR orden ='+num+" y tarea ='+idtarea+" y idempleado="+idmecanico);
            var resp=this.responseText;
 
            if (resp=="0") 
            {
              //alert("FINALIZAR=>Orden:"+num+"-Tarea:"+idtarea+"-Mecanico:"+idmecanico+"-Observacion:"+obs);
 
              atendertareas(num,idmecanico);
            }
          }
        };
        xmlhttp.open('GET', 'gestionartareamecanico.php?estado=F&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico+'&obs='+obs, false);
        xmlhttp.send();
      }
    }

    function vermovimientostareasvsempledos() 
    {
      location.reload();
    }

    function vincularordentrabajo(num,id) 
    {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num+" y idempleado="+id);
            document.getElementById("lsinfo").innerHTML=this.responseText;
            //var bandera=this.responseText;

            if (document.getElementById("lsinfo").value==0) 
            {
              autoriza(num,id);
              //location.reload();
            }
          }
        };
        xmlhttp.open('GET', 'vincularusuarioordentrabajo.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
    }

    function desvincularordentrabajo(num,id) 
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
        xmlhttp.open('GET', 'desvincularordentrabajo.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
    }

    function atendertareas(num,id) 
    {
      if (num<=0) {
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('numero orden='+num);
            document.getElementById("lsdetalles").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'atendertareas.php?num='+num+'&id='+id, false);
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
            //alert ('numero chasis='+num);
            document.getElementById("lsdetalles").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'historialorden.php?num='+num+"&ver=S", false);
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
      <h1>Atender Ordenes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item"><a href="atenderordenes.php">Atención de ordenes</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <span id="lsdetalles">
    
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ordenes de Trabajo Disponibles/Autorizadas</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope='col'>N° Orden</th>
                    <th scope='col'>Titulo Orden</th>
                    <th scope='col'>Afectados</th>
                    <th scope='col'>Estado</th>
                    <th scope='col'>&nbsp;</th>
                    <th scope='col'>&nbsp;</th>
                    <th scope='col'>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                <?php echo $filasproydis; ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>

        </div>
      </div>
    </section>
   
    <?php echo $filasap; ?>

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
