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
    
      $sql = "SELECT a.`numorden`, a.`tituloorden`, a.`kilometraje`, a.`modelo`
              FROM numeroorden a
              WHERE a.`accion`!='B' AND a.`numorden`=". $numorden;

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
          echo "
                <section class='section'>
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
                              <label for='inputText' class='col-sm-3 col-form-label'>Kilometraje</label>
                              <div class='col-sm-9'>
                                <input type='text' class='form-control' value='".$row['kilometraje']."'>
                              </div>
                          </div>
                          <div class='row mb-3'>
                              <label for='inputEmail' class='col-sm-3 col-form-label'>Modelo</label>
                              <div class='col-sm-9'>
                                <input type='text' class='form-control' value='".$row['modelo']."'>
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

        $sql="SELECT a.`numorden`, b.`idtarea`,c.`descripciontarea`,e.`nombrecortousu`,d.`fechaautoriza`
              FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                                INNER JOIN tareas c ON (b.`idtarea`=c.`idtarea` AND c.`accion`!='B') 
                                INNER JOIN autorizaraccorden d ON (d.`numorden`=a.`numorden` AND d.accion!='B')
                                INNER JOIN personas e ON (e.`idpersona`=d.`idempleadoaccion` AND e.`accion`!='B') 
              WHERE a.`accion`!='B' AND b.`estado`='D' AND d.idpersona=". $idusuario ." AND a.`numorden`=". $numorden ."
              ORDER BY d.`fechaautoriza`;";

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
            $datos=$datos ."
                            <a href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.' onclick='aprocesar(\"$numorden\",\"$idtarea\",\"$idusuario\")'>
                              <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                               ". $row['descripciontarea'] ."
                              <p>
                                <code>Usuario: ". $row['nombrecortousu'] ." <br/> ". $row['fechaautoriza'] ."</code>
                              </p>
                              </div>
                            </a>
                          ";
          }

          $opdisponibles="
                          <div class='col-lg-4'>
                            <div class='card'>
                              <div class='card-body'>
                              
                                <h5 class='card-title'>Tareas Disponibles</h5>

                                <!-- Lista De Tareas Disponibles-->
                                ". $datos ."
                                <!-- Fin Lista De Tareas Disponibles -->
                                              
                              </div>
                            </div>
                          </div>
                        ";

          desconectar($con);

          //FIN TAREAS DE INICIO DE LA ORDEN DISPONIBLE
          //============================================================================

          //============================================================================
          //SE TRATAN TAREAS DE PROCESO DE LA ORDEN DISPONIBLE
            $sql="SELECT a.`numorden`, a.`idtarea`,b.`descripciontarea`
                  FROM afectadostareas a INNER JOIN tareas b ON (b.`idtarea`=a.`idtarea` AND b.`accion`!='B') 
                  WHERE a.`estado`='P' AND a.`numorden`=". $numorden ." 
                  GROUP BY a.`numorden`, a.`idtarea`,b.`descripciontarea`
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
                $datos=$datos ."
                                <a href='#' data-bs-placement='top' data-bs-toggle='modal' data-bs-target='#basicModal".$idtarea."'>
                                  <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    ". $row['descripciontarea'] ."  
                                    <p>
                                      <code>Usuario: ";
                
                //==================================================CHEQUEO SI EXISTE MECANICO EN LA TAREA
                  $bandera=false;//USADO PARA SABER SI EMPLEADO EXISTE EN LA TAREA
                  $afectados="";//USADO PARA ARMAR LA LISTA DE AFECTADOS EN LA TAREA
                  $cantparticipan=0;//USADO PARA DETERMINAR CANTIDAD DE AFECTADOS A LA TAREA
                  
                  $_sql="SELECT a.`idempleado`,b.`nombrecortousu`,a.`fechaini`,a.fechaobs,a.`observacion`,a.abandona
                        FROM afectadostareas a INNER JOIN personas b ON (a.`idempleado`=b.`idpersona` AND b.`accion`!='B')
                        WHERE a.`numorden`=".$numorden." AND a.`idtarea`=".$idtarea." AND a.`estado`='P'
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
                    
                    if ($cantparticipan>1)
                    {//SI HAY MÁS DE UN MECANICO SE PUEDE MOSTRARA EL BOTON DE BORRAR O AGREGAR TAREA EN CASO DE SER UN MECANICO NUEVO DE EXISTIR EL MECANICO EN TAREA SE MUESTRA EL BOTON BAJA
                      if ($bandera==true) $datos=$datos ."<img src='assets/img/del_tarea.png' alt='Profile' data-bs-toggle='modal' data-bs-target='#basicModalMec".$idtarea."'>";
                      else $datos=$datos ."<img src='assets/img/add_tarea.png' alt='Profile' onclick='addcolaborartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")'>";
                    }
                    else 
                    {//EXISTE UN UNICO MECANICO POR CONSIGUIENTE SE ANALIZA SI ES EL ACTUALMENTE LOGUEADO, DE NO SER SE MUESTRA EL BOTON AGREGAR
                      if ($bandera==false) $datos=$datos ."<img src='assets/img/add_tarea.png' alt='Profile' onclick='addcolaborartarea(\"$numorden\",\"$idtarea\",\"$idusuario\")'>";
                    }

                    desconectar($_con);
                  } 
                //=====================================FIN CONTROL EXISTE MECANICO EN TAREA
              
                //======================================VENTANAS EMERGENTES SEGUN ACCION PRESIONADAS DE ELIMINAR O AGREGAR COLABORADOR MECANICO O CAMBIAR ESTADO DE LA ORDEN A DISPONIBLE O FINALIZADA
                  $datos=$datos ."      </a>
                                    </div>
                                  </a>
                                  
                                  <div class='card-body'>
                                    <!-- Cambio Estado al Dejar tarea Modal -->
                                    <div class='modal fade' id='basicModalMec".$idtarea."' tabindex='-1'>
                                      <div class='modal-dialog'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title'>Salir de Tarea ".$numorden."-".$idtarea."-".$idusuario."
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
                                    </div><!-- Cambio Estado al Dejar tarea Modal-->
                                  </div>

                                  <div class='card-body'>
                                    <!-- Cambio Estado a Finalizar Modal -->
                                    <div class='modal fade' id='basicModal".$idtarea."' tabindex='-1'>
                                      <div class='modal-dialog'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title'>Finalizar Tarea ".$numorden."-".$idtarea."-".$idusuario."</h5>
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
                                  </div>
                                ";
                //======================================FIN VENTANAS EMERGENTES SEGUN ACCION PRESIONADAS DE ELIMINAR O AGREGAR COLABORADOR MECANICO O CAMBIAR ESTADO DE LA ORDEN A DISPONIBLE O FINALIZADA
              }

              $opprocesos="
              
                            <div class='col-lg-4'>
                              <div class='card'>
                                <div class='card-body'>
                                
                                  <h5 class='card-title'>Tareas En Procesos</h5>

                                  <!-- Lista De Tareas En Proceso -->
                                    ". $datos ."
                                  <!-- Fin Lista De Tareas En Proceso -->

                                </div>
                              </div>
                            </div>
                          ";

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
                  $datos=$datos ."
                                  <a href='#' data-bs-toggle='tooltip' data-bs-placement='top' title='". $row['observacion'] ."'>
                                      <div class='alert alert-info alert-dismissible fade show' role='alert'>
                                      ". $row['descripciontarea'] ."
                                      <p>
                                        <code>Inicio: ". $row['fini'] ." <br/> Fin: ". $row['ffin'] ."</code>
                                      </p>
                                    </div>
                                  </a>
                                ";
                }

                $opfinalizar="
                
                              <div class='col-lg-4'>
                                <div class='card'>
                                  <div class='card-body'>

                                    <h5 class='card-title'>Tareas Finalizadas</h5>

                                    <!-- Lista De Tareas Finalizadas -->
                                    ". $datos ."
                                    <!-- Fin Lista De Tareas Finalizadas -->
                                  </div>
                                </div>
                              </div>
                            ";

                desconectar($con);

                //FIN TAREAS A FINALIZAR DE LA ORDEN DISPONIBLE
                //============================================================================
              }
            }
          }  
        }
                    
      echo "
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
          </section>
        ";
    }
  }
}
else
{
  echo "<script> window.location.href='index.html'</script>";
}   

?>