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

  <!-- =======================================================
  POR OTRO LADO LAS TAREAS PUEDEN TENER LOS SIGUIENTES ESTADOS
  * D => DISPONIBLES PARA SU ATENCION
  * P => EN PROCESO SE ESTA ATENDIENDO
  * F => TAREA TERMINADA
  ======================================================== -->
  <script>
    function exportarorden(idmecanico)
    {
      let num=document.getElementById('txtnumorden').value;; //RECUPERO NUMERO ORDEN
      let titulo=document.getElementById("txttitulo").value; //RECUPERO TITULO ORDEN
      let dias=document.getElementById("txtdias").value; //RECUPERO DIAS DURA TRATAR ORDEN
      let hora=document.getElementById("txthora").value; //RECUPERO DIAS DURA TRATAR ORDEN
      let eresp="";

      //alert ("Numero de orden ingresado="+num+"-Titulo ingresado="+titulo+"-Dias dura tarea="+dias);
        
      if ((num=="")||(titulo=="")||(dias=="")||(hora=="")) {
        document.getElementById("lblproceso").innerHTML="<p style='text-align: center;'>Se requiere de un número de orden, un titulo, un número de dias y hora que dura tratar la orden!!!</p>";
        return;
      } else {
        document.getElementById("lblproceso").innerHTML="<p style='text-align: center;'>Procesando...</p>";
 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            eresp=this.responseText;
            
            if (eresp=="OK") 
            {
              //alert ('1ERA EXPORTARORDEN=>LA RESPUESTA RECIBIDA ES='+eresp);
              organizartareas(num,'D',titulo,dias,hora,num,idmecanico); //EXPORTACION OK SE PONE DISPONIBLE TAREA CON TITULO INDICADO Y DIAS
           }
            else document.getElementById("lblproceso").innerHTML=eresp; //SE GENERO ERROR EN LA EXPORTACIÓN
          }
        };
        xmlhttp.open('GET', 'detalleorden.php?num='+num+'&mecanico=1', true);
        xmlhttp.send();
      }
    }
   
    function organizartareas(orden,estado,titulo,dias,hora,num,idmecanico) 
    {
        let resp="";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            resp=this.responseText;

            //alert("Cambiaron a disponible ("+resp+"). Se envia la orden numero=>"+orden+" y se lo pasa al estado de =>"+estado+", con el titulo "+titulo+" y es para el mecanico="+idmecanico);
            
            //console.log(resp);
            
            document.getElementById("lblproceso").innerHTML="";
 
            //SE VINCULA ORDEN AL MECANICO QUE LA EXPORTO
            if (resp) 
            {
              vincularordentrabajo(num,idmecanico);
            }
            else 
            {
              //alert ("recarga desde fn organizartareas");
              vermovimientostareasvsempledos();
            }
          }
        };
        xmlhttp.open('GET', 'organizarorden.php?orden='+orden+'&estado='+estado+'&titulo='+titulo+'&dias='+dias+'&hora='+hora+'&mecanico=1', false);
        xmlhttp.send();
    }

    function nuevatarea(num,idmecanico) 
    {
      let idtarea=document.getElementById("txttarea").value; //RECUPERO NOMBRE DE LA NUEVA TAREA 
      
      //alert("DETALLE NUEVA TAREA=>Orden:"+num+"-mecanico:"+idmecanico+"-idtarea="+idtarea);

      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          
            let resp=this.responseText;
 
            if (resp=="0") 
            {//SE REALIZA LA ACTUALIZACION DE LA VISTA
              //alert("DETALLE NUEVA TAREA=>Orden:"+num+"-mecanico:"+idmecanico+"-idtarea="+idtarea);
              atendertareas(num,idmecanico);
            }
            else
            {
              alert("ERROR AL DAR DE ALTA LA TAREA EN LA ORDEN=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
          }
        };
        
        xmlhttp.open('GET', 'agregartareaorden.php?num='+num+'&idtarea='+idtarea, false);
        xmlhttp.send();
      }
    }

    function pausartarea(num,idtarea,idmecanico) 
    {
      let obs=document.getElementById("txtobspausa"+idtarea).value;// "RECUPERO OBSERVACION"; 
      let estado='S';

      //alert("SE PAUSA LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico+"-obs="+obs);
              
      if (num<=0 && idtarea<=0 && idmecanico<=0 && obs.length<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          
            let resp=this.responseText;
 
            if (resp=="0") 
            {//SE REALIZA LA ACTUALIZACION DE LA VISTA
              //alert("SE PAUSA LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico+"-obs="+obs);
              atendertareas(num,idmecanico);
            }
            else
            {
              alert("ERROR AL PAUSAR LA TAREA POR PARTE DEL MECANICO=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
          }
        };
        
        xmlhttp.open('GET', 'pausartarea.php?estado='+estado+'&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico+'&obs='+obs, false);
        xmlhttp.send();
      }
        
    }

    function reactivartarea(num,idtarea,idmecanico) 
    {
      let estado='N';
      let obs="Reactivar Tarea";

      //alert("SE SACA DE LA PAUSA A LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
              
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          
            let resp=this.responseText;
 
            if (resp=="0") 
            {//SE REALIZA LA ACTUALIZACION DE LA VISTA
              //alert("SE SACA DE LA PAUSA A TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
              atendertareas(num,idmecanico);
            }
            else
            {
              alert("ERROR AL SACAR DE LA PAUSAR A LA TAREA POR PARTE DEL MECANICO=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
          }
        };
        
        xmlhttp.open('GET', 'pausartarea.php?estado='+estado+'&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico+'&obs='+obs, false);
        xmlhttp.send();
      }
        
    }

    function abandonar(num,idtarea,idmecanico) 
    {
      let obs=document.getElementById("txtobservacionmec").value;// "Se finaliza por prueba de CESAR"; 
           
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          
            //alert("SE BAJA DE LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico+"-obs="+obs);
            
            let resp=this.responseText;
 
            if (resp=="0") 
            {//SE REALIZA LA ACTUALIZACION DE LA VISTA
              atendertareas(num,idmecanico);
            }
            else
            {
              alert("ERROR EN LA DESVINCULACION DEL MECANICO A LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
          }
        };
        
        xmlhttp.open('GET', 'gestionartareamecanico.php?estado=B&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico+'&obs='+obs, false);
        //xmlhttp.open('GET', 'crudcolaboratarea.php?estado=S&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico+'&obs='+obs, false);
        xmlhttp.send();
      }
    }

    function addcolaborartarea(num,idtarea,idmecanico) 
    {
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert("COLABORA A LA TAREA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            
            let resp=this.responseText;
 
            if (resp=="0") 
            {//SE REALIZLA ACTUALIZACION DE LA VISTA
              atendertareas(num,idmecanico);
              //alert("ALTA REALIZADA=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
            else
            {
              alert("ERROR EN LA VINCULACION DE LA TAREA CON EL MECANICO=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            }
          }
        };
        xmlhttp.open('GET', 'gestionartareamecanico.php?estado=C&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico, false);
        //xmlhttp.open('GET', 'crudcolaboratarea.php?estado=P&num='+num+'&idtarea='+idtarea+'&idmecanico='+idmecanico, false);
        xmlhttp.send();
      }
    }

    function iniciar(num,idtarea,idmecanico) 
    {
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert("VALORES INICIALES=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            
            let resp=this.responseText;
 
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
      //alert("VALORES INICIALES=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
         
      if (num<=0 && idtarea<=0 && idmecanico<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert("VALORES INICIALES=>Orden:"+num+"-tarea:"+idtarea+"-mecanico:"+idmecanico);
            
            let resp=this.responseText;
 
            //alert ("El valor de respesta fue: "+resp);

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
      let obs=document.getElementById("txtobservacion").value;// "Se finaliza por prueba de CESAR";

      if ((num<=0)&&(idtarea<=0)&&(idmecanico<=0)) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ("VINCULAR orden ="+num+" y tarea ="+idtarea+" y idempleado="+idmecanico);
            let resp=this.responseText;
 
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
      let vresp="";

      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('1-FUNCION VINCULAR=>vincular numero orden='+num+" con idempleado="+id);
           
            vresp=this.responseText;//0=SE REALIZO VINCULACION. 1= ERROR EN LA VINCULACION
            //var bandera=this.responseText;
     
            if (vresp=="0") 
            {
              autoriza(num,id);
            
              //vresp=document.getElementById("lsinfo").innerHTML;

              //alert ('3-FUNCION VINCULAR=>Se realizo la autorización de lo pedido por el mecanico sobre la orden='+num+" y idempleado="+id+". Con respuesta igual=>"+vresp);
           
              if (vresp==="0") 
              {
                vermovimientostareasvsempledos();
              }
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
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //alert ('DESVINCULAR numero orden='+num+" y idempleado="+id);
            let resp=this.responseText;

            if (resp==0) 
            {
              vermovimientostareasvsempledos();
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
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('ATENDERTAREA=>se atiende la tarea numero orden='+num+' - idmecanico='+id+' - Respuesta='+this.responseText);
            
            document.getElementById("lsdetalles").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'atendertareas.php?num='+num+'&id='+id+'&mostrar=S', false);
        xmlhttp.send();
      }
    }

    function vercontenidotarea(num,id) 
    {
      //alert ('ATENDERTAREA=>se atiende la tarea numero orden='+num+' - idmecanico='+id);
      
      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
            //alert ('ATENDERTAREA=>se atiende la tarea numero orden='+num+' - idmecanico='+id+' - Respuesta='+this.responseText);
            
            document.getElementById("lsdetalles").innerHTML=this.responseText;
          }
        };
        xmlhttp.open('GET', 'atendertareas.php?num='+num+'&id='+id+'&mostrar=N', false);
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
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
             //alert ('2-AUTORIZA=>se atiende la tarea numero orden='+num+' - idmecanico='+id+' - respuesta='+this.responseText);
     
            document.getElementById("lsinfo").innerHTML =this.responseText; //0=AUTORIZADA-1=NO AUTORIZADA
          }
        };
        xmlhttp.open('GET', 'autoriza.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
    }

    function vertarearealizo(num,id) 
    {
      if (num<=0) {
        return;
      } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            
             //alert ('DESDE JS SE RECIBIERON LOS DATOS DEL MECANIDO '+id+' Y LA ORDEN '+num);
     
            document.getElementById("lsinfotareamec").innerHTML =this.responseText;
          }
        };
        xmlhttp.open('GET', 'tareasafectadoenorden.php?num='+num+'&id='+id, false);
        xmlhttp.send();
      }
        
    }
  </script>
</head>

<body>
<?php
  include "configuracion/conexion.php";

  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $apenomb=$_SESSION['apenomb'];
    $tipousu=$_SESSION['tipo'];
    $foto=$_SESSION['foto'];
    $nombrecorto=$_SESSION['nombrecorto'];
    $filtrar=$_GET['ver'];

    $idusuario=$id;
    $idempleado="0";
    $lsfotos="";
    $orden="";
    $titulo="0";
    $numchasis="0";
    $fila="";
    $filasproydis="";
    $filasap="";
    $bandera="";
    $estado="";
    $estadoorden="0";
    $color="0";
    $sql="";
 
  switch($filtrar)
  {
    case "D"://ORDENES DISPONIBLES
              $sql = "-- ORDENES DISPONIBLES
                    SELECT xx2.`numorden`,xx2.`tituloorden`,xx2.`patente`,

                    xx2.`idpersonadisp` AS idempleado,
                    zz1.urlfoto AS foto, 
                    CONCAT(zz1.`apellido`,', ',zz1.`nombre`) empleado,

                    xx2.`estado`,xx2.`fechaaccion`,

                    'DI' AS situacionorden, 
                    (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=xx2.`numchasis` AND tt.numorden!=xx2.`numorden`) historial,
                    xx2.numchasis
                    FROM numeroorden xx2 INNER JOIN personas zz1 ON (xx2.idpersonadisp=zz1.`idpersona` AND zz1.`accion`!='B')
                    WHERE xx2.accion!='B' AND xx2.estado IN ('D','P') AND xx2.`numorden` NOT IN  
                    (
                    SELECT aa.`numorden`
                    FROM autorizaraccorden aa
                    WHERE aa.`accion`!='B' AND aa.`idpersona`=".$idusuario."
                    )
                    ORDER BY 1,4;";
    break;
    case "P"://ORDENES EN PROCESO
            switch ($tipousu)
            {
              case "Administración":
              case "Gerente":
              case "Supervisor":
                                $sql = "-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
                                        SELECT a.`numorden`,b.`tituloorden`,b.patente,
                                              b.idpersonadisp AS idempleado,
                                              (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
                                              (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
                                              'I' AS `estado`,b.fentrega,'DI' AS situacionorden, 
                                              (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=b.`numchasis` AND tt.numorden!=b.`numorden`) historial,
                                              b.numchasis  
                                        FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                        WHERE b.`estado`!='F' AND a.disponible='S' AND b.`accion`!='B' AND b.`numorden` IN (SELECT yy.`numorden` FROM autorizaraccorden yy WHERE yy.`accion`!='B')
                                        GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.`fechaaccion`,b.`estado`,b.numchasis,b.patente,b.idpersonadisp,b.fentrega
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
                                        WHERE xx1.`accion`!='B' AND yy1.disponible='S' AND xx1.`estado`='P' AND xx1.`numorden` NOT IN  
                                        (
                                        SELECT aa.`numorden`
                                        FROM autorizaraccorden aa 
                                        WHERE aa.`accion`!='B'
                                        ) 
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
              break;
              case "Mecanico":
                              $sql = "-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
                                      SELECT a.`numorden`,b.`tituloorden`,b.patente,
                                      b.idpersonadisp AS idempleado,
                                      (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
                                      (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
                                      'I' AS `estado`,b.fentrega,'DI' AS situacionorden, 
                                      (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=b.`numchasis` AND tt.numorden!=b.`numorden`) historial,
                                        b.numchasis  
                                      FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                      WHERE b.`estado`!='F' AND a.disponible='S' AND b.`accion`!='B' AND b.`numorden` IN (SELECT yy.`numorden` FROM autorizaraccorden yy WHERE yy.`accion`!='B' AND yy.`idpersona`=".$idusuario.")
                                      GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.`fechaaccion`,b.`estado`,b.numchasis,b.patente,b.idpersonadisp,b.fentrega
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
                                      WHERE xx1.`accion`!='B' AND yy1.disponible='S' AND xx1.`estado`='P' AND xx1.`numorden` NOT IN  
                                      (
                                      SELECT aa.`numorden`
                                      FROM autorizaraccorden aa 
                                      WHERE aa.`accion`!='B'
                                      ) AND
                                      yy1.`idempleado`=".$idusuario."
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
                                      WHERE xx2.accion!='B' AND zz.estado='A' AND xx2.estado!='F' AND yy.idpersona=".$idusuario."
                                      ORDER BY 1,4;";
              break;
            }
    break; 
    case "F"://ORDENES FINALIZADAS/TERMINADAS
            switch ($tipousu)
            {
              case "Administración":
              case "Gerente":
              case "Supervisor":
                                $sql = "-- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
                                          SELECT a.`numorden`,b.`tituloorden`,b.patente,
                                                  b.idpersonadisp AS idempleado,
                                                  (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
                                                  (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
                                                  'I' AS `estado`,b.fentrega,'DI' AS situacionorden, 
                                                  (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=b.`numchasis` AND tt.numorden!=b.`numorden`) historial,
                                                  b.numchasis,
                                                  'Orden disponible para su tratamiento' AS descripciontarea  
                                          FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                          WHERE b.`estado`='F' AND a.disponible='S' AND b.`accion`!='B' AND b.`numorden` IN (SELECT yy.`numorden` FROM afectadostareas yy WHERE yy.`estado`='F' AND yy.disponible='S')
                                          GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.`fechaaccion`,b.`estado`,b.numchasis,b.patente,b.idpersonadisp,b.fentrega
                                          UNION
                                          -- QUIEN PARTICIPARON Y QUE HICIERON
                                          SELECT a.numorden,b.tituloorden,b.`patente`,c.`idpersona` AS idempleado,c.urlfoto AS foto, 
                                                CONCAT(c.`apellido`,', ',c.`nombre`) AS empleado,b.estado,b.fecha AS fechaaccion,'FI' AS situacionorden, 
                                                (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=b.numchasis AND tt.numorden!=a.numorden) AS historial,
                                                b.numchasis,
                                                d.`descripciontarea`
                                          FROM afectadostareas a INNER JOIN numeroorden b ON (a.numorden=b.numorden AND b.accion!='B')
                                                                INNER JOIN personas c ON (c.idpersona=a.idempleado AND c.accion!='B') 
                                                                INNER JOIN tareas d ON (a.`idtarea`=d.`idtarea` AND d.`accion`!='B')
                                          WHERE b.estado='F' AND a.disponible='S' AND a.`numorden` IN (SELECT yy.`numorden` FROM afectadostareas yy WHERE yy.`estado`='F' AND yy.disponible='S')
                                          GROUP BY 1,4
                                          ORDER BY 1,8 ASC;
                                        ";
              break;
              case "Mecanico":
                              $sql = "
                                      -- TRAE LAS ORDEN DONDE SOLO FIGURA QUIEN LA PUSO DISPONIBLE
                                      SELECT a.`numorden`,b.`tituloorden`,b.patente,
                                              b.idpersonadisp AS idempleado,
                                              (SELECT xx.urlfoto FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS foto,
                                              (SELECT CONCAT(xx.apellido,',',xx.nombre) FROM personas xx WHERE xx.accion!='B' AND xx.idpersona=b.idpersonadisp) AS empleado,
                                              'I' AS `estado`,b.fentrega,'DI' AS situacionorden, 
                                              (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.accion!='B' AND tt.estado='F' AND tt.numchasis=b.`numchasis` AND tt.numorden!=b.`numorden`) historial,
                                              b.numchasis,
                                              'Orden disponible para su tratamiento' AS descripciontarea  
                                      FROM afectadostareas a INNER JOIN numeroorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
                                      WHERE b.`estado`='F' AND b.`accion`!='B' AND a.disponible='S' AND b.`numorden` IN (SELECT yy.`numorden` FROM afectadostareas yy WHERE yy.`estado`='F' AND yy.disponible='S' AND yy.`idempleado`=".$idusuario.")
                                      GROUP BY a.`numorden`,b.`tituloorden`,b.`fecha`,b.`fechaaccion`,b.`estado`,b.numchasis,b.patente,b.idpersonadisp,b.fentrega
                                      UNION
                                      -- QUIEN PARTICIPARON Y QUE HICIERON
                                      SELECT a.numorden,b.tituloorden,b.`patente`,c.`idpersona` AS idempleado,c.urlfoto AS foto, 
                                            CONCAT(c.`apellido`,', ',c.`nombre`) AS empleado,b.estado,b.fecha AS fechaaccion,'FI' AS situacionorden, 
                                            (SELECT COUNT(tt.numorden) FROM numeroorden tt WHERE tt.numchasis=b.numchasis AND tt.numorden!=a.numorden) AS historial,
                                            b.numchasis,
                                            d.`descripciontarea`
                                      FROM afectadostareas a INNER JOIN numeroorden b ON (a.numorden=b.numorden AND b.accion!='B')
                                                            INNER JOIN personas c ON (c.idpersona=a.idempleado AND c.accion!='B') 
                                                            INNER JOIN tareas d ON (a.`idtarea`=d.`idtarea` AND d.`accion`!='B')
                                      WHERE b.estado='F' AND a.disponible='S' AND a.`numorden` IN (SELECT yy.`numorden` FROM afectadostareas yy WHERE yy.`estado`='F' AND yy.disponible='S' AND yy.`idempleado`=".$idusuario.")
                                      GROUP BY 1,4
                                      ORDER BY 1,8 ASC;
                                    ";
                break;
            }
    break;
  }

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
              $lsfotos=$lsfotos."<a href='#'><img src='./assets/img/".$row['foto']."' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicDetalle' class='rounded-circle' width='30' height='30' onclick='vertarearealizo(".$orden.",".$row['idempleado'].")'></a>";
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
            //$bandera="";
            
            if (strlen($orden)>0)
            {
                $fila="
                      <tr>
                          <th scope='row'><a href='#' onclick='vercontenidotarea(\"$orden\",\"$idusuario\")'>#".$orden."</a></th>
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
                                        
                                       // if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                       // else 
                                             $fila=$fila."<a href='#'>
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
                                        ";

                            if ($tipousu=="Mecanico")
                            {
                              $fila=$fila."<td>
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
                            }
                            else
                            {
                              $fila=$fila."
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td> 
                                            &nbsp;
                                        </td>
                                        <td>";
                            }           

                            if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                            else $fila=$fila."<a href='#'>
                                                <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                              </a></td></tr>";
                          }
                          else
                          {//SE SUMA EMPLEADO ORDEN
                            $fila=$fila."
                                        <td>".$color."</td>
                                        ";
                            
                            if ($tipousu=="Mecanico")
                            {
                              $fila=$fila."
                                        <td>
                                            <a href='#'>
                                                <img src='assets/img/usu_add.png' alt='Sumarse a tarea' onclick='vincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                            </a>
                                        </td>
                                        <td> 
                                            &nbsp;
                                        </td>
                                        <td>"; 
                            }
                            else
                            {
                              $fila=$fila."
                                          <td>
                                              &nbsp;
                                          </td>
                                          <td> 
                                              &nbsp;
                                          </td>
                                          <td>
                                        ";
                            } 

                            if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                            else $fila=$fila."<a href='#'>
                                                <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                              </a></td></tr>";
                          }

                          $bandera="";
                  break;
                  case "PE"://ORDEN PENDIENTE DE APROBACION POR PARTE DE RESPONSABLE
                          if ($tipousu=="Mecanico")
                          {
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
                          } 
                          
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
              $lsfotos="<a href='#'><img src='./assets/img/".$row['foto']."' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicDetalle' class='rounded-circle' width='30' height='30' onclick='vertarearealizo(\"$orden\",\"$idempleado\")'></a>";
            }
            else
            {
              $lsfotos="&nbsp;";
            }
        }   
      }
      
      if ($orden>0)
      {
        $fila="
              <tr>
                  <th scope='row'><a href='#' onclick='vercontenidotarea(\"$orden\",\"$idusuario\")'>#".$orden."</a></th>
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
                                
                                //if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                //else 
                                $fila=$fila."<a href='#'>
                                                    <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                  </a></td></tr>";
                  $bandera="";
          break;
          case "DI"://ORDEN DISPONIBLE
          case "PR"://ORDEN EN PROCESO
          case "AU"://ORDEN AUTORIZADA POR SUPERVISOR AL MECANICO
                  if ($bandera=="del")
                  {//BORRA EMPLEADO ORDEN
                      $fila=$fila."
                                  <td>".$color."</td>
                                  ";
                      if ($tipousu=="Mecanico")
                      {   
                        $fila=$fila."<td>
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
                      }
                      else
                      {
                        $fila=$fila."<td>
                                      &nbsp;
                                  </td>
                                  <td>
                                      &nbsp;
                                  </td>
                                  <td>"; 
                      }         

                                  
                                  if ($tienehisto<=0) $fila=$fila."&nbsp</td></tr>";
                                  else $fila=$fila."<a href='#'>
                                                      <img src='assets/img/tarea_historia.png' alt='Ver Historial Chasis' onclick='historial(\"$numchasis\")'>
                                                    </a></td></tr>";
                  }
                  else
                  {//SE SUMA EMPLEADO ORDEN
                      $fila=$fila."
                                    <td>".$color."</td>
                                  ";
                      if ($tipousu=="Mecanico")
                      {   
                        $fila=$fila."<td>
                                      <a href='#'>
                                          <img src='assets/img/usu_add.png' alt='Sumarse a tarea' onclick='vincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                      </a>
                                    </td>
                                    <td> 
                                        &nbsp;
                                    </td>
                                    <td>"; 
                      }
                      else
                      {
                        $fila=$fila."<td>
                                      &nbsp;
                                    </td>
                                    <td> 
                                        &nbsp;
                                    </td>
                                    <td>"; 
                      }

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
                                ";
                    if ($tipousu=="Mecanico")
                    {
                      $fila=$fila."<td>
                                      <a href='#'>
                                        <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' onclick='desvincularordentrabajo(\"$orden\",\"$idusuario\")'>
                                      </a>
                                  </td>
                                  <td> 
                                      &nbsp;
                                  </td>
                                  <td>";
                    }
                    else
                    {
                      $fila=$fila."<td>
                                      &nbsp;
                                  </td>
                                  <td> 
                                      &nbsp;
                                  </td>
                                  <td>";
                    }
                                
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
      else $filasproydis="<tr><td colspan='7' style='text-align: center;'>Sin información a mostrar</td></tr>";
      
      
    }
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
      <h1>Atender Ordenes</h1>
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
          <li class="breadcrumb-item">
          <?php
            switch ($filtrar)
                    {
                      case "F": //ORDEN FINALIZADA - AZUL
                              echo "<a href='atenderordenes.php?ver=F'>Ordenes Finalizadas</a>";
                      break;
                      case "D": //ORDEN DISPONIBLE - AMARILLO bg-warning
                              echo "<a href='atenderordenes.php?ver=D'>Ordenes Disponibles</a>";
                      break;
                      case "P": //ORDEN EN PROCESO - VERDE bg-success 
                              echo "<a href='atenderordenes.php?ver=P'>Ordenes en Procesos</a>";
                      break;
                    }
          ?>
          
          </li>
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
              <?php 
                if (($filtrar=="P")&&($tipousu=="Mecanico"))
                {
              ?>  
                <div class="text-center">
                  <a href="#" data-bs-toggle='modal' data-bs-target='#NuevaOrden'>
                    <i class="btn btn-primary">Recuperar Datos Orden</i>
                  </a>
                  <span id="lblproceso"></span>
                  <input type="hidden" id="lblid">
                </div>
              <?php 
                } 
              ?>

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


              <div class='card-body'>
                <!-- Cambio Estado a Finalizar Modal -->
               <div class="modal fade" id="basicDetalle" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class='modal-title'>Tareas</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                      </div>
                      <div class='modal-body'>
                        <span id="lsinfotareamec" name="lsinfotareamec"></span>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Volver</button>
                      </div>
                    </div>
                  </div>
                </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
   
    <?php if ($filasap>0) echo $filasap; else ""; ?>

    <input id="lsinfo" name="lsinfo" type="hidden" value="." />
     
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

  <div class='card-body'>
    <!-- Cambio Estado a Finalizar Modal -->
    <div class='modal fade' id='NuevaOrden' tabindex='-1'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Exportar Orden</h5>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
            <div class='row mb-3'>
              <label class='col-sm-2 col-form-label'>Orden</label>
              <div class='col-sm-10'>
                <input name='txtnumorden' type='text' class='form-control' id='txtnumorden' placeholder='Ingrese número de la orden a buscar'>
              </div>
              <p></p>
              <label class='col-sm-2 col-form-label'>Titulo</label>
              <div class='col-sm-10'>
                <input name='txttitulo' type='text' class='form-control' id='txttitulo' placeholder='Ingrese un titulo'>
              </div>
              <p></p>
              <label for="txtdias" class="col-sm-2 col-form-label">Dia/s:</label>
              <div class='col-sm-10'>
                  <div class="form-floating mb-3">
                    <select class="form-select" id="txtdias" aria-label="State">
                      <?php
                        $ccdias="<option value='0' selected>Hoy</option>";                
                        for ($i=1;$i<=365;$i++)
                        {
                          $ccdias=$ccdias."<option value='".$i."'>".$i." día</option>";
                        }

                        echo $ccdias;
                      ?>
                    </select>
                    <label for="txtdias">Duración de la tarea</label>
                  </div>
              </div>
              <p></p>
              <label class='col-sm-2 col-form-label'>Hora Fin</label>
              <div class='col-sm-10'>
                <input name='txthora' type='time' class='form-control' id='txthora' placeholder='Ingrese hora estimada'>
              </div>
            </div>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
            <?php echo "<button type='button' class='btn btn-primary' onclick='exportarorden(".$id.")' data-bs-dismiss='modal'>Buscar</button>"; ?>
          </div>
        </div>
      </div>
    </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
  </div>
</body>

</html>
