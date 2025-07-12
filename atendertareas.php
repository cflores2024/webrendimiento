<?php
  session_start();

  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
  
    if (isset($_GET['id']))
    {  
      $idusuario=$_GET['id'];
      $numorden="";

      if (isset($_GET["num"]))
      {  
        $numorden=$_GET["num"];
        $mostrar=$_GET["mostrar"];
      
        $sql = "SELECT a.`numorden`, a.`tituloorden`, a.`fventa`, a.`kilometraje`, b.`modelomarca` AS modelo
                FROM numeroorden a INNER JOIN modelos b ON (a.`codmodelo`=b.`codmodelo`)
                WHERE a.`accion`!='B' AND a.`numorden`=".$numorden;

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
          //echo "NUMERO DE LA ORDEN=>".$numorden;
          //echo "sql=>".$sql;

          while($row = mysqli_fetch_array($result))
          {
            //echo "NUMERO DE LA ORDEN=>".$numorden;
            
            echo "<section class='section'>
                    <div class='row'>
                      <div class='col-lg-6'>

                        <div class='card'>
                          <div class='card-body'>
                            <h5 class='card-title'>Detalle Orden</h5>
                            <div class='row mb-3'>
                                <label for='inputText' class='col-sm-3 col-form-label'>N° Orden</label>
                                <div class='col-sm-9'>
                                  <input type='text' class='form-control' value='".$row['numorden']."'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                  <label for='inputEmail' class='col-sm-3 col-form-label'>Titulo</label>
                                  <div class='col-sm-9'>
                                    <input type='text' class='form-control' value='".$row['tituloorden']."'>
                                  </div>
                              </div>
                          </div>
                        </div>

                      </div>

                      <div class='col-lg-6'>

                        <div class='card'>
                          <div class='card-body'>
                            <h5 class='card-title'>Detalle Auto</h5>
                            <div class='row mb-3'>
                                <label for='inputEmail' class='col-sm-3 col-form-label'>Modelo</label>
                                <div class='col-sm-9'>
                                  <input type='text' class='form-control' value='".$row['modelo']."'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputEmail' class='col-sm-3 col-form-label'>Fecha Venta</label>
                                <div class='col-sm-9'>
                                  <input type='text' class='form-control' value='".$row['fventa']."'>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </section>";
                  
          }

          desconectar($con);
          //============================================================================
          //SE TRATAN TAREAS DE INICIO DE LA ORDEN DISPONIBLE
          $sql="SELECT a.`numorden`, b.`idtarea`,c.`descripciontarea`,d.`nombrecortousu`,b.`fechaaccion` AS fechaautoriza
                FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                                  INNER JOIN tareas c ON (b.`idtarea`=c.`idtarea` AND c.`accion`!='B') 
                                  INNER JOIN personas d ON (d.`idpersona`=a.`idpersonadisp` AND d.`accion`!='B') 
                WHERE a.`accion`!='B' AND b.`estado`='D' AND a.`numorden`=". $numorden ."
                ORDER BY b.`fechaaccion`;";

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
            $datos="";
            $opdisponibles="";
            $idtarea="";
          
            while($row = mysqli_fetch_array($result))
            {
              $idtarea=$row['idtarea'];
            
              if ($mostrar=="S") $datos=$datos ."<a href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.' onclick='aprocesar(\"$numorden\",\"$idtarea\",\"$idusuario\")'>";
              else $datos=$datos ."<a href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.'>";
                                      
              $datos=$datos ."
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                ". $row['descripciontarea'] ."
                                <p>
                                  <code>Usuario: ". $row['nombrecortousu'] ." <br/> ". $row['fechaautoriza'] ."</code>
                                </p>
                                </div>
                              </a>";
                              
            }

            $opdisponibles="<div class='col-lg-4'>
                              <div class='card'>
                                <div class='card-body'>
                                
                                  <h5 class='card-title'>Tareas Disponibles
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

            if ($mostrar=="S") $opdisponibles=$opdisponibles."<a href='#'><img src='assets/img/nueva_tarea.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#NuevaTarea'></a></h5>";

            $opdisponibles=$opdisponibles."<!-- Lista De Tareas Disponibles-->
                                  ". $datos ."
                                  <!-- Fin Lista De Tareas Disponibles -->
                                                
                                </div>
                              </div>
                            </div>";

            desconectar($con);

            //FIN TAREAS DE INICIO DE LA ORDEN DISPONIBLE
            //============================================================================

            //============================================================================
            //SE TRATAN TAREAS EN PROCESO DE LA ORDEN DISPONIBLE
              $sql="SELECT a.`numorden`, a.`idtarea`,b.`descripciontarea`,a.suspendida
                    FROM afectadostareas a INNER JOIN tareas b ON (b.`idtarea`=a.`idtarea` AND b.`accion`!='B') 
                    WHERE a.`estado`='P'  AND a.disponible='S' AND a.`numorden`=". $numorden ." 
                    GROUP BY a.`numorden`, a.`idtarea`,b.`descripciontarea`,a.suspendida
                    ORDER BY a.`idtarea`,a.`fechaobs`;";
              
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
                $datos="";
                $opprocesos="";
                $idtarea="";

                while($row = mysqli_fetch_array($result))
                {
                  $idtarea=$row['idtarea'];
                  $suspendida=$row['suspendida'];

                  if ($suspendida=="S") $datos=$datos ."<a href='#'>";
                  else $datos=$datos ."<a href='#' data-bs-placement='top' data-bs-toggle='modal' data-bs-target='#basicModal".$idtarea."'>";

                  if ($suspendida=="S") $datos=$datos."<div class='alert alert-dark  alert-dismissible fade show' role='alert'>"; //TAREA SUSPENDIDA
                  else $datos=$datos."<div class='alert alert-warning alert-dismissible fade show' role='alert'>"; //TAREA EN PROCESO

                  $datos=$datos."". $row['descripciontarea'] ."<p><code>Usuario: ";
                  
                  //==================================================CHEQUEO SI EXISTE MECANICO EN LA TAREA
                    $bandera=false;//USADO PARA SABER SI EMPLEADO EXISTE EN LA TAREA
                    $afectados="";//USADO PARA ARMAR LA LISTA DE AFECTADOS EN LA TAREA
                    $cantparticipan=0;//USADO PARA DETERMINAR CANTIDAD DE AFECTADOS A LA TAREA
                    
                    $_sql="SELECT a.`idempleado`,b.`nombrecortousu`,a.`fechaini`,a.fechaobs,a.`observacion`,a.abandona
                          FROM afectadostareas a INNER JOIN personas b ON (a.`idempleado`=b.`idpersona` AND b.`accion`!='B')
                          WHERE a.`numorden`=".$numorden." AND a.`idtarea`=".$idtarea." AND a.`estado`='P' AND a.disponible='S'
                          ORDER BY a.`fechaini`;";

                    $_con=conectar();

                    $_result = $cnx->query($_sql);

                    if (!$_result) 
                    {
                      die('Invalid query: ' . $_cnx->error);
                    }

                    if (!$_result) 
                    {
                      die('Invalid query: ' . $mysqli->error);
                    }
                    else
                    {
                      while($_row = mysqli_fetch_array($_result))
                      {
                        $afectados=$afectados."</br>&nbsp;&nbsp;<a href='#' title='". $_row['observacion']."&nbsp;". $_row['fechaobs'] ."'>";
                        
                        if ($_row['abandona']=="S")
                        {//MECANICO ABANDONAN LA TAREA, TACHADO Y SE DESCUENTA EN LA CUENTA DE PARTICIPANTES
                          $afectados=$afectados ."<span style='text-decoration:line-through;'>". $_row['nombrecortousu'] ."</span>&nbsp;". $_row['fechaini'];
                        }
                        else 
                        {//MECANICOS AFECTADOS A LAS TAREAS EN CURSO Y SE INCREMENTA LA CUANTA DE PARTICIPANTES
                          $afectados=$afectados ."". $_row['nombrecortousu'] ."&nbsp;". $_row['fechaini'] ."</a>";
                          $cantparticipan=$cantparticipan+1;
                        }

                        //EMPLEADO EXISTE EN LA TAREA
                        if ($idusuario==$_row['idempleado'])
                        {
                          if ($_row['abandona']=="N") 
                          {
                            $bandera=true; //NO ABANDONA TAREA. SE MUESTRA EL BOTON DE BORRAR
                          }
                          else
                          {
                            $bandera=false;//ABANDONO TAREA. SE MUESTRA EL BOTON DE SUMARSE
                          }
                        } 
                      }
                      
                      $datos=$datos.$afectados."</code></p><a style='float: right;' href='#'>";
                      
                      if ($suspendida=="S") //TAREA SUSPENDIDA SOLO SE MUESTRA UN ICONO DE SACAR DE SUSPENDIDA
                      {
                        if ($mostrar=="S") $datos=$datos ."<img src='assets/img/sacar_pausa.png' alt='Profile' onclick='reactivartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")'>";
                      }
                      else
                      {
                        if ($cantparticipan>1)
                        {
                          if ($mostrar=="S")
                          {
                            //SI HAY MÁS DE UN MECANICO SE PUEDE MOSTRARA EL BOTON DE BORRAR O AGREGAR TAREA EN CASO DE SER UN MECANICO NUEVO DE EXISTIR EL MECANICO EN TAREA SE MUESTRA EL BOTON BAJA
                            if ($bandera==true) $datos=$datos ."<img src='assets/img/del_tarea.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicModalMec".$idtarea."'>
                                                                &nbsp;
                                                                <img src='assets/img/pausar.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicPausa".$idtarea."'>";
                            else $datos=$datos ."<img src='assets/img/add_tarea.png' alt='Profile' onclick='addcolaborartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")'>
                                                &nbsp;
                                                <img src='assets/img/pausar.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicPausa".$idtarea."'>";
                          }
                        }
                        else 
                        {
                          if ($mostrar=="S")
                          {
                            //EXISTE UN UNICO MECANICO POR CONSIGUIENTE SE ANALIZA SI ES EL ACTUALMENTE LOGUEADO, DE NO SER SE MUESTRA EL BOTON AGREGAR
                            if ($bandera==false) $datos=$datos ."<img src='assets/img/add_tarea.png' alt='Profile' onclick='addcolaborartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")'>
                                                                &nbsp;
                                                                <img src='assets/img/pausar.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicPausa".$idtarea."'>";
                            else $datos=$datos ."<img src='assets/img/pausar.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicPausa".$idtarea."'>";
                          }
                        }
                      }
                      
                      desconectar($_con);
                    } 
                  //=====================================FIN CONTROL EXISTE MECANICO EN TAREA
                
                  //======================================VENTANAS EMERGENTES SEGUN ACCION PRESIONADAS DE ELIMINAR O AGREGAR COLABORADOR MECANICO O CAMBIAR ESTADO DE LA ORDEN A DISPONIBLE O FINALIZADA
                    $datos=$datos ."      </a>
                                      </div>
                                    </a>";
                    
                        if ($mostrar=="S")
                          {
                            $datos=$datos."
                                    <div class='card-body'>
                                      <!-- Cambio Estado a Finalizar Modal -->
                                      <div class='modal fade' id='basicModal".$idtarea."' tabindex='-1'>
                                        <div class='modal-dialog'>
                                          <div class='modal-content'>
                                            <div class='modal-header'>
                                              <h5 class='modal-title'>Finalizar Tarea</h5>
                                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                              <input name='txtobservacion' type='text' class='form-control' id='txtobservacion' placeholder='Ingrese una observación sobre la tarea a finalizar'>
                                            </div>
                                            <div class='modal-footer'>
                                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                              <button type='button' class='btn btn-primary' onclick='iniciar(\"$numorden\",\"$idtarea\",\"$idusuario\")' data-bs-dismiss='modal'>Disponible</button>
                                              <button type='button' class='btn btn-primary' onclick='finalizar(\"$numorden\",\"$idtarea\",\"$idusuario\")' data-bs-dismiss='modal'>Finalizar</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
                                    </div>";
                          }

                          $datos=$datos."<div class='card-body'>
                                      <!-- Cambio Estado a Finalizar Modal -->
                                      <div class='modal fade' id='basicModalMec".$idtarea."' tabindex='-1'>
                                        <div class='modal-dialog'>
                                          <div class='modal-content'>
                                            <div class='modal-header'>
                                              <h5 class='modal-title'>Dejar Tarea</h5>
                                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                              <input name='txtobservacionmec' type='text' class='form-control' id='txtobservacionmec' placeholder='Ingrese una observación sobre la tarea a dejar'>
                                            </div>
                                            <div class='modal-footer'>
                                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                              <button type='button' class='btn btn-primary' onclick='abandonar(\"$numorden\",\"$idtarea\",\"$idusuario\")' data-bs-dismiss='modal'>Dejar tarea</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
                                    </div>

                                    <div class='card-body'>
                                      <!-- Cambio Estado a Finalizar Modal -->
                                      <div class='modal fade' id='basicPausa".$idtarea."' tabindex='-1'>
                                        <div class='modal-dialog'>
                                          <div class='modal-content'>
                                            <div class='modal-header'>
                                              <h5 class='modal-title'>Pausar Tarea</h5>
                                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                              <input name='txtobspausa".$idtarea."' type='text' class='form-control' id='txtobspausa".$idtarea."' placeholder='Ingrese una observación sobre el motivo de la pausa'>
                                            </div>
                                            <div class='modal-footer'>
                                              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                              <button type='button' class='btn btn-primary' onclick='pausartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")' data-bs-dismiss='modal'>Pausar tarea</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
                                    </div>";
                  //======================================FIN VENTANAS EMERGENTES SEGUN ACCION PRESIONADAS DE ELIMINAR O AGREGAR COLABORADOR MECANICO O CAMBIAR ESTADO DE LA ORDEN A DISPONIBLE O FINALIZADA
                }

                $opprocesos="<div class='col-lg-4'>
                                <div class='card'>
                                  <div class='card-body'>
                                  
                                    <h5 class='card-title'>Tareas En Procesos</h5>

                                    <!-- Lista De Tareas En Proceso -->
                                      ". $datos ."
                                    <!-- Fin Lista De Tareas En Proceso -->

                                  </div>
                                </div>
                              </div>";

                desconectar($con);

              //FIN TAREAS DE PROCESO DE LA ORDEN DISPONIBLE
              //============================================================================

              //============================================================================
                //SE TRATAN TAREAS A FINALIZAR DE LA ORDEN DISPONIBLE
                $sql="SELECT a.`numeroorden` AS `numorden`, a.`idtarea`,b.`descripciontarea`,a.`observacion`,a.`fini`,a.`ffin`
                      FROM detalleorden a INNER JOIN tareas b ON (b.`idtarea`=a.`idtarea` AND b.`accion`!='B')
                      WHERE a.`estado`='F' AND a.`numeroorden`=". $numorden ." 
                      ORDER BY a.`fini`,a.`ffin`;";

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
                  $datos="";
                  $opfinalizar="";
                  $idtarea="";
                
                  while($row = mysqli_fetch_array($result))
                  {
                    $idtarea=$row['idtarea'];
                    $datos=$datos ."<a href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='". $row['observacion'] ."'>
                                        <div class='alert alert-info alert-dismissible fade show' role='alert'>
                                        ". $row['descripciontarea'] ."
                                        <p>
                                          <code>Inicio: ". $row['fini'] ." <br/> Fin: ". $row['ffin'] ."</code>
                                        </p>
                                      </div>
                                    </a>";
                  }

                  $opfinalizar="<div class='col-lg-4'>
                                  <div class='card'>
                                    <div class='card-body'>

                                      <h5 class='card-title'>Tareas Finalizadas</h5>

                                      <!-- Lista De Tareas Finalizadas -->
                                      ". $datos ."
                                      <!-- Fin Lista De Tareas Finalizadas -->
                                    </div>
                                  </div>
                                </div>";

                  desconectar($con);

                  //FIN TAREAS A FINALIZAR DE LA ORDEN DISPONIBLE
                  //============================================================================
                }
              }
            }  
          }
                      
        $imprimir= "
            <section class='section'>
              <div class='row'>
              
                ".
                $opdisponibles
                ."

                ".
                $opprocesos
                ."

                ".
                $opfinalizar
                ."

              </div>
            </section>";


            $sql = "SELECT a.`idtarea`,a.`descripciontarea`
                    FROM tareas a
                    WHERE a.`accion`!='B'
                    order by a.`descripciontarea` asc;";

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
                $lista=$lista ."<option value='".$row['idtarea']."'>".$row['descripciontarea']."</option>";
              }
            }
            
            desconectar($con);

        $imprimir=$imprimir."<div class='card-body'>
              <!-- Cambio Estado a Finalizar Modal -->
              <div class='modal fade' id='NuevaTarea' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title'>Nueva Tarea</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                      <div class='row mb-3'>
                        <label class='col-sm-2 col-form-label'>Tarea</label>
                        <div class='col-sm-10'>
                          <select class='form-select' aria-label='Default select example' id='txttarea'>
                            <option selected>Seleccione una tarea del listado</option>".
                            $lista
                            ."</select>
                        </div>
                      </div>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                      <button type='button' class='btn btn-primary' onclick='nuevatarea(\"$numorden\",\"$idusuario\")' data-bs-dismiss='modal'>Aceptar</button>
                    </div>
                  </div>
                </div>
              </div><!-- Finalizar Cambio Estado a Finalizar Modal-->
            </div>
          ";

          echo $imprimir;
      }
    }
  }
  else
  {
    echo "<script> window.location.href='index.html'</script>";
  }   

?>