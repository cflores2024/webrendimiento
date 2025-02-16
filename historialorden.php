<?php
    $patente=$_GET["num"];
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

    echo "
    <section class='section dashboard'>
      <div class='row'>

        <!-- Left side columns -->
        <div class='col-lg-8'>
          <div class='row'>

            <!-- Recent Sales -->
            <div class='col-12'>
              <div class='card recent-sales overflow-auto'>

                <div class='card-body'>
                  <h5 class='card-title'>Listado de tareas</h5>

                  <table class='table table-hover'>
                    <thead>
                      <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Descripción</th>
                        <th scope='col'>F. Inicio</th>
                        <th scope='col'>F. Fin</th>
                        <th scope='col'>Observacion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope='row'><a href='#'>#1</a></th>
                        <td>Cambio de filtro</td>
                        <td>01/02/1996 11:30:00</td>
                        <td>01/02/1996 12:00:00</td>
                        <td>Se realiza una observación de la tarea sobre la cual se trabajo</td>
                      </tr>
                      <tr>
                        <th scope='row'><a href='#'>#2</a></th>
                        <td>Cambio de Aceite</td>
                        <td>01/02/1996 12:30:00</td>
                        <td>01/02/1996 13:00:00</td>
                        <td>Se realiza una observación de la tarea sobre la cual se trabajo</td>
                      </tr>
                      <tr>
                        <th scope='row'><a href='#'>#3</a></th>
                        <td>Cambio de foco guiño derecho delantero</td>
                        <td>01/02/1996 14:30:00</td>
                        <td>01/02/1996 15:00:00</td>
                        <td>Se realiza una observación de la tarea sobre la cual se trabajo</td>
                      </tr>
                      <tr>
                        <th scope='row'><a href='#'>#4</a></th>
                        <td>Cambio de foco guiño trasero izquierdo</td>
                        <td>01/02/1996 15:30:00</td>
                        <td>01/02/1996 16:00:00</td>
                        <td>Se realiza una observación de la tarea sobre la cual se trabajo</td>
                      </tr>
                     </tbody>
                  </table>

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

              <div class='activity'>

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2025</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2024</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2023</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2022</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2021</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                  <div class='activite-label'>15/04/2020</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class='activity-content'>
                    Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                  </div>
                </div><!-- End activity item-->

                <div class='activity-item d-flex'>
                    <div class='activite-label'>15/04/2019</div>
                    <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                    <div class='activity-content'>
                        Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                      </div>
                  </div><!-- End activity item-->

                  <div class='activity-item d-flex'>
                    <div class='activite-label'>15/04/2018</div>
                    <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                    <div class='activity-content'>
                        Número de orden <a href='#' class='fw-bold text-dark'>45212785</a>
                      </div>
                  </div><!-- End activity item-->

              </div>

            </div>
          </div><!-- End Recent Activity -->
        </div><!-- End Right side columns -->

      </div>
    </section>
    ";
?>