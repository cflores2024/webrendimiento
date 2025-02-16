<?php
$verop="N";

echo "

  <!-- ======= Sidebar ======= -->
  <aside id='sidebar' class='sidebar'>

    <ul class='sidebar-nav' id='sidebar-nav'>

      <li class='nav-item'>
        <a class='nav-link ' href='home.php'>
          <i class='bi bi-grid'></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class='nav-item'>
        <a class='nav-link collapsed' data-bs-target='#tables-nav' data-bs-toggle='collapse' href='#'>
          <i class='bi bi-layout-text-window-reverse'></i><span>CRUD Varios</span><i class='bi bi-chevron-down ms-auto'></i>
        </a>
        <ul id='tables-nav' class='nav-content collapse ' data-bs-parent='#sidebar-nav'>
";

      if (($tipousu=="Administrador")||($tipousu=="Recepción"))
      {  
        $verop="S";

        echo "
                <li>
                  <a href='buscadorpersonal.php'>
                    <i class='bi bi-circle'></i><span>CRUD Personal</span>
                  </a>
                </li>
                <li>
                  <a href='buscadordisciplinas.php'>
                    <i class='bi bi-circle'></i><span>CRUD Especialidades</span>
                  </a>
                </li>
                <li>
                  <a href='buscadorordenes.php'>
                    <i class='bi bi-circle'></i><span>CRUD Ordenes Trabajos</span>
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
                
              </ul>
            </li><!-- End Tables Nav -->

            <li class='nav-heading'>Recurrentes</li>

            <li class='nav-item'>
              <a class='nav-link collapsed' href='buscadorpersonal.php'>
                <i class='bi bi-person-lines-fill'></i>
                <span>Personal</span>
              </a>
            </li><!-- End Profile Page Nav -->";

      }
      
echo "
     <li class='nav-item'>
        <a class='nav-link collapsed' href='validaringreso.php'>
          <i class='bi bi-box-arrow-in-right'></i>
          <span>Validar Ingreso</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class='nav-item'>
        <a class='nav-link collapsed' href='contactenos.php'>
          <i class='bi bi-envelope'></i>
          <span>Contactenos</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class='nav-item'>
        <a class='nav-link collapsed' href='ayuda.php'>
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
?>