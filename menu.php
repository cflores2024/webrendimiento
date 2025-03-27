<?php
$verop="N";

switch ($tipousu)
{
  case "Gerente":
                       $verop="S";
                        echo "
                                <!-- ======= Sidebar ======= -->
                                <aside id='sidebar' class='sidebar'>

                                  <ul class='sidebar-nav' id='sidebar-nav'>

                                    <li class='nav-item'>
                                      <a class='nav-link ' href='home.php'>
                                        <i class='bi bi-reception-4'></i>
                                        <span>Metricas</span>
                                      </a>
                                    </li>
                                    <li class='nav-item'>
                                      <a class='nav-link ' href='avancestareas.php'>
                                        <i class='bi bi-grid'></i>
                                        <span>Tareas en curso</span>
                                      </a>
                                    </li><!-- End Dashboard Nav -->

                                    <li class='nav-item'>
                                      <a class='nav-link collapsed' data-bs-target='#tables-nav' data-bs-toggle='collapse' href='#'>
                                        <i class='bi bi-layout-text-window-reverse'></i><span>Operaciones</span><i class='bi bi-chevron-down ms-auto'></i>
                                      </a>
                                      <ul id='tables-nav' class='nav-content collapse ' data-bs-parent='#sidebar-nav'>
                                        <li>
                                          <a href='buscadorpersonal.php'>
                                            <i class='bi bi-circle'></i><span>Gestión Usuarios</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href='buscadordisciplinas.php'>
                                            <i class='bi bi-circle'></i><span>Gestión Especialidades</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href='buscadorordenes.php'>
                                            <i class='bi bi-circle'></i><span>Gestión Ordenes</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href='buscadortareas.php'>
                                            <i class='bi bi-circle'></i><span>Estimar Tiempos Tareas</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href='atenderordenes.php'>
                                            <i class='bi bi-circle'></i><span>Atender Ordenes</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href='autorizarpedido.php'>
                                            <i class='bi bi-circle'></i><span>Autorizar Acceso Orden</span>
                                          </a>
                                        </li>
                                        
                                      </ul>
                                    </li><!-- End Tables Nav -->

                                    <li class='nav-heading'>Recurrentes</li>

                                    <li class='nav-item'>
                                      <a class='nav-link collapsed' href='buscadorpersonal.php'>
                                        <i class='bi bi-person-lines-fill'></i>
                                        <span>Personal</span>
                                      </a>
                                    </li><!-- End Profile Page Nav -->
                                    <li class='nav-item'>
                                      <a class='nav-link collapsed' href='contactenos.php'>
                                        <i class='bi bi-envelope'></i>
                                        <span>Contactenos</span>
                                      </a>
                                    </li><!-- End Contact Page Nav -->

                                    <li class='nav-item'>
                                      <a class='nav-link collapsed' href='#'>
                                        <i class='bi bi-question-circle'></i>
                                        <span>F.A.Q</span>
                                      </a>
                                    </li><!-- End F.A.Q Page Nav -->

                                    <li class='nav-item'>
                                      <a class='nav-link collapsed' href='index.php'>
                                        <i class='bi bi-box-arrow-in-right'></i>
                                        <span>Login</span>
                                      </a>
                                    </li><!-- End Login Page Nav -->

                                  </ul>

                                </aside><!-- End Sidebar-->
                              ";
  break;
  case "Administración":
                    $verop="S";
                    echo "
                            <!-- ======= Sidebar ======= -->
                            <aside id='sidebar' class='sidebar'>

                              <ul class='sidebar-nav' id='sidebar-nav'>

                                <li class='nav-item'>
                                  <a class='nav-link ' href='home.php'>
                                    <i class='bi bi-reception-4'></i>
                                    <span>Metricas</span>
                                  </a>
                                </li>
                                <li class='nav-item'>
                                  <a class='nav-link ' href='avancestareas.php'>
                                    <i class='bi bi-grid'></i>
                                    <span>Tareas en curso</span>
                                  </a>
                                </li><!-- End Dashboard Nav -->

                                <li class='nav-item'>
                                  <a class='nav-link collapsed' data-bs-target='#tables-nav' data-bs-toggle='collapse' href='#'>
                                    <i class='bi bi-layout-text-window-reverse'></i><span>Operaciones</span><i class='bi bi-chevron-down ms-auto'></i>
                                  </a>
                                  <ul id='tables-nav' class='nav-content collapse ' data-bs-parent='#sidebar-nav'>
                                    <li>
                                      <a href='buscadorordenes.php'>
                                        <i class='bi bi-circle'></i><span>Gestión Ordenes</span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href='buscadortareas.php'>
                                        <i class='bi bi-circle'></i><span>Estimar Tiempos Tareas</span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href='autorizarpedido.php'>
                                        <i class='bi bi-circle'></i><span>Autorizar Acceso Orden</span>
                                      </a>
                                    </li>
                                    
                                  </ul>
                                </li><!-- End Tables Nav -->

                                <li class='nav-heading'>Recurrentes</li>
                                <li class='nav-item'>
                                  <a class='nav-link collapsed' href='#'>
                                    <i class='bi bi-question-circle'></i>
                                    <span>F.A.Q</span>
                                  </a>
                                </li><!-- End F.A.Q Page Nav -->

                                <li class='nav-item'>
                                  <a class='nav-link collapsed' href='index.php'>
                                    <i class='bi bi-box-arrow-in-right'></i>
                                    <span>Login</span>
                                  </a>
                                </li><!-- End Login Page Nav -->

                              </ul>

                            </aside><!-- End Sidebar-->
                          ";
  break;
  case "Mecanico":
                  $verop="S";
                  echo "
                          <!-- ======= Sidebar ======= -->
                          <aside id='sidebar' class='sidebar'>

                            <ul class='sidebar-nav' id='sidebar-nav'>

                              <li class='nav-item'>
                                <a class='nav-link ' href='home.php'>
                                  <i class='bi bi-reception-4'></i>
                                  <span>Metricas</span>
                                </a>
                              </li>
                              <li class='nav-item'>
                                <a class='nav-link ' href='avancestareas.php'>
                                  <i class='bi bi-grid'></i>
                                  <span>Tareas en curso</span>
                                </a>
                              </li><!-- End Dashboard Nav -->

                              <li class='nav-item'>
                                <a class='nav-link collapsed' data-bs-target='#tables-nav' data-bs-toggle='collapse' href='#'>
                                  <i class='bi bi-layout-text-window-reverse'></i><span>Operaciones</span><i class='bi bi-chevron-down ms-auto'></i>
                                </a>
                                <ul id='tables-nav' class='nav-content collapse ' data-bs-parent='#sidebar-nav'>
                                  <li>
                                    <a href='atenderordenes.php'>
                                      <i class='bi bi-circle'></i><span>Atender Ordenes</span>
                                    </a>
                                  </li>
                                </ul>
                              </li><!-- End Tables Nav -->

                              <li class='nav-heading'>Recurrentes</li>

                              <li class='nav-item'>
                                <a class='nav-link collapsed' href='#'>
                                  <i class='bi bi-question-circle'></i>
                                  <span>F.A.Q</span>
                                </a>
                              </li><!-- End F.A.Q Page Nav -->

                              <li class='nav-item'>
                                <a class='nav-link collapsed' href='index.php'>
                                  <i class='bi bi-box-arrow-in-right'></i>
                                  <span>Login</span>
                                </a>
                              </li><!-- End Login Page Nav -->

                            </ul>

                          </aside><!-- End Sidebar-->
                        ";
  break;
}
/*

echo "<!-- ======= Sidebar ======= -->
                                <aside id='sidebar' class='sidebar'>

                                  <ul class='sidebar-nav' id='sidebar-nav'>

                                    <li class='nav-item'>
                                      <a class='nav-link ' href='home.php'>
                                        <i class='bi bi-reception-4'></i>
                                        <span>".$tipousu."</span>
                                      </a>
                                    </li>
            </ul>

                          </aside><!-- End Sidebar-->";
                          */
                          
?>