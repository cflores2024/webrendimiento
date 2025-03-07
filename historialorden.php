<?php
    include "configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    $info="";
    $verbtn=""; 

    if (isset($_GET["num"]))
    {
      $verbtn=$_GET["ver"];
      if ($verbtn=="S") 
      {
        $verbtn="&nbsp;&nbsp;&nbsp;<a href='#' onclick='vermovimientostareasvsempledos()'>
                <img src='./assets/img/volver.png' alt='Volver'></a>";
      }
      else
      {
        $verbtn=""; 
      }
    }
    

    if (isset($_GET["num"]))
    {  
      $patente=$_GET["num"];
   
      $sql = "SELECT CONCAT(a.`apellido`,', ', a.`nombre`) AS cliente, MAX(a.`domicilio`) dom,MAX(a.`tel`) tel,MAX(a.`emailusuario`) email,b.`patente`,b.`modelo`,b.`numchasis`,b.`kilometraje`
              FROM personas a INNER JOIN numeroorden b ON (a.`idpersona`=b.`idcliente` AND b.`accion`!='B')
              WHERE a.accion!='B' AND a.`idtipopersona`=2 AND b.`patente`='".$patente."';";

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
        $info="";

        while($row = mysqli_fetch_array($result))
        {
          $info="
                  <section class='section'>
                      <div class='row'>
                          <div class='col-lg-6'>
                            <div class='card'>
                              <div class='card-body'>
                                  <h5 class='card-title'>Datos Cliente</h5>
                                  <!-- General Form Elements -->
                                  <div class='row mb-3'>
                                      <label for='inputText' class='col-sm-3 col-form-label'>Cliente</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['cliente']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputEmail' class='col-sm-3 col-form-label'>Domicilio</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['dom']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputPassword' class='col-sm-3 col-form-label'>Telefono</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['tel']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputNumber' class='col-sm-3 col-form-label'>Email</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['email']."'>
                                      </div>
                                  </div>
                              </div>
                            </div>

                          </div>
                          <div class='col-lg-6'>

                              <div class='card'>
                              <div class='card-body'>
                                  <h5 class='card-title'>Datos Auto</h5>
                                  <div class='row mb-3'>
                                      <label for='inputPassword' class='col-sm-3 col-form-label'>Modelo</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['modelo']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputNumber' class='col-sm-3 col-form-label'>N° Chasis</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['numchasis']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputNumber' class='col-sm-3 col-form-label'>Patente</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['patente']."'>
                                      </div>
                                  </div>
                                  <div class='row mb-3'>
                                      <label for='inputNumber' class='col-sm-3 col-form-label'>Kilometraje</label>
                                      <div class='col-sm-9'>
                                      <input type='text' class='form-control' value='".$row['kilometraje']."'>
                                      </div>
                                  </div>
                                </div>
                              </div>

                          </div>
                      </div>
                  </section>
                ";
        }
      }

      desconectar($con);

      $sql = "SELECT a.`numorden`,a.`fecha`,a.`estado`
              FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
              WHERE a.`accion`!='B' AND a.`patente`='".$patente."'
              GROUP BY a.`numorden`,a.`fecha`,a.`estado`
              ORDER BY a.`fecha` DESC;";

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
        $histo="";
        $msn="";
        while($row = mysqli_fetch_array($result))
        {
          $histo=$histo."
                          <div class='activity-item d-flex'>
                            <div class='activite-label'>". date("d/m/Y", strtotime($row['fecha'])) ."</div>";

          switch ($row['estado'])
          {
            case "S": //ORDEN PENDIENTE A SER ASIGNADA PARA ESTAR DISPONIBLE - GRIS text-muted
                    $histo=$histo."<i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>";
                    $msn="Orden pendiente de aceptación";
            break;
            case "D": //ORDEN DISPONIBLE - AMARILLO text-warning
                    $histo=$histo."<i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>";
                    $msn="Orden disponible para ser trabajada";
            break;
            case "P": //ORDEN EN PROCESO - VERDE text-success 
                    $histo=$histo."<i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>";
                    $msn="Orden en tratamiento";
            break;
            case "F": //ORDEN FINALIZADA - CELESTE text-info
                    $histo=$histo."<i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>";
                    $msn="Orden finalizada";
            break;
          }
          $histo=$histo."
                            <div class='activity-content'>
                              Número de orden <a href='#' class='fw-bold text-dark' title='".$msn."' onclick='vertabla(".$row['numorden'].")'>#".$row['numorden']."</a>
                            </div>
                          </div><!-- End activity item-->
                        ";
        }
      }
            
      desconectar($con);

    }

    $info=$info."
                  <section class='section dashboard'>
                    <div class='row'>

                      <!-- Left side columns -->
                      <div class='col-lg-8'>
                        <div class='row'>

                          <!-- Recent Sales -->
                          <div class='col-12'>
                            <div class='card recent-sales overflow-auto'>

                              <div class='card-body'>
                                <span id='tbldetalleorden'>
                                  <h5 class='card-title'>Listado de tareas</h5>

                                  Seleccione alguna orden para ver su información
                                </span>

                              </div>

                            </div>
                          </div><!-- End Recent Sales -->

                        </div>
                      </div><!-- End Left side columns -->

                      <!-- Right side columns -->
                      <div class='col-lg-4'>

                        <!-- Recent Activity -->
                        <div class='card'>
                          <div class='card-body'>
                            <h5 class='card-title'>Historial Mantenimieto". $verbtn ."</h5>

                            <div class='activity'>".

                              $histo

                            ."</div>

                          </div>
                        </div><!-- End Recent Activity -->
                      </div><!-- End Right side columns -->

                    </div>
                  </section>
    ";

    echo $info;
?>