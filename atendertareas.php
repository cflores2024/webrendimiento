<?php
include "configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

session_start();
  
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
                                <code>Usuario: ". $row['nombrecortousu'] ." <br/> ". $row['fechaobs'] ."</code>
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

          $sql="SELECT a.`numorden`, a.`idtarea`,b.`descripciontarea`,a.`idempleado`,c.`nombrecortousu`,a.`fechaobs`,a.`observacion`
                FROM afectadostareas a INNER JOIN tareas b ON (b.`idtarea`=a.`idtarea` AND b.`accion`!='B') 
                                      INNER JOIN personas c ON (c.`idpersona`=a.`idempleado` AND c.`accion`!='B') 
                WHERE a.`estado`='P' AND a.`numorden`=". $numorden ."
                ORDER BY a.`fechaobs`;";

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
                              <a href='#' data-bs-placement='top' title='". $row['observacion'] ."' data-bs-toggle='modal' data-bs-target='#basicModal'>
                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                  ". $row['descripciontarea'] ."
                                  <p>
                                    <code>Usuario: ". $row['nombrecortousu'] ." <br/> ". $row['fechaobs'] ."</code>
                                  </p>
                                </div>
                              </a>
                              
                              <div class='card-body'>
                                <!-- Cambio Estado a Finalizar Modal -->
                                <div class='modal fade' id='basicModal' tabindex='-1'>
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
                              </div>
                            ";
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

            $sql="SELECT a.`numorden`, a.`idtarea`,b.`descripciontarea`,a.`idempleado`,c.`nombrecortousu`,a.`fechaobs`,a.`observacion`
                  FROM afectadostareas a INNER JOIN tareas b ON (b.`idtarea`=a.`idtarea` AND b.`accion`!='B') 
                                        INNER JOIN personas c ON (c.`idpersona`=a.`idempleado` AND c.`accion`!='B') 
                  WHERE a.`estado`='F' AND a.`numorden`=". $numorden ."
                  ORDER BY a.`fechaobs`;";

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
                                      <code>Usuario: ". $row['nombrecortousu'] ." <br/> ". $row['fechaobs'] ."</code>
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
  header('Location: index.php');
  exit;
}   
?>