<?php
include "configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

if (isset($_GET['id']))
{  
  $id=$_GET['id'];
  $orden="";

  if (isset($_GET["num"]))
  {  
    $orden=$_GET["num"];
  
    $sql = "";

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
        if ($orden==$row['numorden'])
        {
        }
      }
    }

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
                    <input type='text' class='form-control' value='".$orden."'>
                  </div>
              </div>
              <div class='row mb-3'>
                    <label for='inputEmail' class='col-sm-3 col-form-label'>Titulo</label>
                    <div class='col-sm-9'>
                    <input type='text' class='form-control' value='...'>
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
                    <input type='text' class='form-control' value='".$orden."'>
                  </div>
              </div>
              <div class='row mb-3'>
                    <label for='inputEmail' class='col-sm-3 col-form-label'>Modelo</label>
                    <div class='col-sm-9'>
                      <input type='text' class='form-control' value='...'>
                    </div>
                </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class='section'>
      <div class='row align-items-top'>
        <div class='col-lg-4'>

          <!-- Card with header and footer -->
          <div class='card'>
            <div class='card-header'><Data>Tareas Disponibles</Data></div>
            
            <div class='card-body'>
              <!-- Lista De Tareas -->
              <div class='accordion accordion-flush' id='accordionFlushExample'>
                <div class='accordion-item'>
                  <h2 class='accordion-header' id='flush-headingTwo'>
                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseTwo' aria-expanded='false' aria-controls='flush-collapseTwo'>
                      Cambio de aceite&nbsp;&nbsp; 
                      <a href='#' onclick='cambioestado()'>
                        <img src='assets/img/tarea_cambio.png' alt='Cambiar estado tarea'>
                      </a>
                    </button>
                  </h2>
                  <div id='flush-collapseTwo' class='accordion-collapse collapse' aria-labelledby='flush-headingTwo' data-bs-parent='#accordionFlushExample'>
                    <div class='accordion-body'>
                      
                        Administrador 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.'>10/02/2025 13:55:00</code>
                        </p>

                      <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#basicModal'>
                        Proceso
                      </button>
                     
                        <div class='card-body'>
                          <!-- Basic Modal -->
                          <div class='modal fade' id='basicModal' tabindex='-1'>
                            <div class='modal-dialog'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h5 class='modal-title'>Basic Modal</h5>
                                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                  Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
                                </div>
                                <div class='modal-footer'>
                                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                  <button type='button' class='btn btn-primary'>Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div><!-- End Basic Modal-->
                        </div>
                    </div>
                  </div>
                </div>
              </div><!-- End Accordion without outline borders -->
            </div>
            
            <div class='card-footer'>
              Tareas Disponibles
            </div>
          </div><!-- End Card with header and footer -->

        </div>

        <div class='col-lg-4'>

          <!-- Card with header and footer -->
          <div class='card'>
            <div class='card-header'>Tareas En Proceso</div>
 
            <div class='card-body'>
              <div class='card-body'>
                <!-- Lista De Tareas -->
                <div class='accordion accordion-flush' id='accordionFlushExample'>
                  <div class='accordion-item'>
                    <h2 class='accordion-header' id='flush-headingOne'>
                      <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne' aria-expanded='false' aria-controls='flush-collapseOne'>
                        Cambio de filtro&nbsp&nbsp
                        <a href='#'>
                          <img src='assets/img/usu_msn.png' alt='Hacer una observación'>
                        </a>
                        &nbsp
                        <a href='#'>
                          <img src='assets/img/tarea_cambio.png' alt='Cambiar estado tarea'>
                        </a>
                      </button>
                    </h2>
                    <div id='flush-collapseOne' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                      <div class='accordion-body'>
                        Administrador 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.'>10/02/2025 13:55:00</code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 1'>
                            10/02/2025 13:55:00
                          </code>
                          <a href='#'>
                            <img src='assets/img/deletemsn.png' alt=''>
                          </a>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 2'>
                            10/02/2025 13:55:00
                          </code>
                          <a href='#'>
                            <img src='assets/img/deletemsn.png' alt=''>
                          </a>
                        </p>                        
                        
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#basicModal'>
                          Disponible
                        </button>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#basicModal'>
                          Terminado
                        </button>
                       
                          <div class='card-body'>
                            <!-- Basic Modal -->
                            <div class='modal fade' id='basicModal' tabindex='-1'>
                              <div class='modal-dialog'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h5 class='modal-title'>Basic Modal</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                  </div>
                                  <div class='modal-body'>
                                    Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
                                  </div>
                                  <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button type='button' class='btn btn-primary'>Save changes</button>
                                  </div>
                                </div>
                              </div>
                            </div><!-- End Basic Modal-->
                          </div>
                        </div>
                    </div>
                  </div>
                </div><!-- End Accordion without outline borders -->
              </div>
            </div>
 
            <div class='card-footer'>
              Tareas En Proceso
            </div>
          </div><!-- End Card with header and footer -->

        </div>

        <div class='col-lg-4'>

        <!-- Card with header and footer -->
        <div class='card'>
          <div class='card-header'>Tareas Finalizadas</div>
            <div class='card-body'>
                <!-- Lista De Tareas -->
                <div class='accordion accordion-flush' id='accordionFlushExample'>
                  <div class='accordion-item'>
                    <h2 class='accordion-header' id='flush-headingThree'>
                      <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseThree' aria-expanded='false' aria-controls='flush-collapseThree'>
                        Cambio de liquidos de frenos 
                        &nbsp;&nbsp;
                        <a href='#' onclick='cambioestado()'>
                          <img src='assets/img/tarea_cambio.png' alt='Cambiar estado tarea'>
                        </a>
                      </button>
                    </h2>
                    <div id='flush-collapseThree' class='accordion-collapse collapse' aria-labelledby='flush-headingThree' data-bs-parent='#accordionFlushExample'>
                      <div class='accordion-body'>
                        Administrador 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.'>10/02/2025 13:55:00</code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 1'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 2'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 3'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                      </div>
                    </div>
                  </div>
                </div><!-- End Accordion without outline borders -->

                <!-- Lista De Tareas -->
                <div class='accordion accordion-flush' id='accordionFlushExample4'>
                  <div class='accordion-item'>
                    <h2 class='accordion-header' id='flush-heading4'>
                      <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse4' aria-expanded='false' aria-controls='flush-collapse4'>
                        Cambio de liquidos de frenos 
                        &nbsp;&nbsp;
                        <a href='#' onclick='cambioestado()'>
                          <img src='assets/img/tarea_cambio.png' alt='Cambiar estado tarea'>
                        </a>
                      </button>
                    </h2>
                    <div id='flush-collapse4' class='accordion-collapse collapse' aria-labelledby='flush-heading4' data-bs-parent='#accordionFlushExample'>
                      <div class='accordion-body'>
                        Administrador 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Da entrada a la tarea para su atención.'>10/02/2025 13:55:00</code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 1'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 2'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                        K. Anderson 1 
                        <p>
                          <code data-bs-toggle='tooltip' data-bs-placement='top' title='Comentario 3'>
                            10/02/2025 13:55:00
                          </code>
                        </p>
                      </div>
                    </div>
                  </div>
                </div><!-- End Accordion without outline borders -->
            </div>
          <div class='card-footer'>
            Tareas Finalizadas
          </div>
        </div><!-- End Card with header and footer -->
        </div>

      </div>
    </section>
    ";
  }
}
else
{
  header('Location: index.php');
  exit;
}   
?>