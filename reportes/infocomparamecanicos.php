<?php
    include "../configuracion/conexion.php";

    $encabezado="";
    $pie="";

    if ((isset($_GET['fini']))&&(isset($_GET['ffin']))&&(isset($_GET['num']))&&(isset($_GET['titulo']))&&(isset($_GET['datosid'])))
    {
        $fini=$_GET['fini'];
        $ffin=$_GET['ffin'];
        $titulo=$_GET['titulo'];
        $num=$_GET['num'];
        $emp=$_GET['emp'];
        $datosid=$_GET['datosid'];
        $fila="";
        $i=1;

        $sql="select * from personas where idpersona=0;";

        //echo $sql;
        $con=conectar();

        $resp=false;

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
                if (strlen($row["idempleado"])>0)
                {
                    $fila=$fila."<tr>
                                    <th scope='row'>".$i."</th>
                                    <td>".$row["mecanico"]."</td>
                                    <td>".$row["cantproceso"]."</td>
                                    <td>".$row["cantsuspendida"]."</td>
                                    <td>".$row["cantfinalizadas"]."</td>
                                    <td>".$row["cantabproceso"]."</td>
                                    <td>".$row["cantabsuspendida"]."</td>
                                    <td>".$row["cantabfinalizadas"]."</td>
                                    <td><input type='checkbox' id='".$row["idempleado"]."' name='".$row["idempleado"]."' value='".$row["idempleado"]."'></td>
                                </tr>";
                    $i=$i+1;
                }
            }

            $fila= "<div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Rendimientos</h5>

                        <!-- Default Tabs -->
                        <ul class='nav nav-tabs d-flex' id='myTabjustified' role='tablist'>
                        <li class='nav-item flex-fill' role='presentation'>
                            <button class='nav-link w-100 active' id='home-tab' data-bs-toggle='tab' data-bs-target='#id1-justified' type='button' role='tab' aria-controls='id1' aria-selected='true'>Mecanico 1</button>
                        </li>
                        <li class='nav-item flex-fill' role='presentation'>
                            <button class='nav-link w-100' id='profile-tab' data-bs-toggle='tab' data-bs-target='#id2-justified' type='button' role='tab' aria-controls='id2' aria-selected='false'>Mecanico 2</button>
                        </li>
                        <li class='nav-item flex-fill' role='presentation'>
                            <button class='nav-link w-100' id='contact-tab' data-bs-toggle='tab' data-bs-target='#id3-justified' type='button' role='tab' aria-controls='id3' aria-selected='false'>Mecanico 3</button>
                        </li>
                        </ul>
                        <div class='tab-content pt-2' id='myTabjustifiedContent'>
                        <div class='tab-pane fade show active' id='home-justified' role='tabpanel' aria-labelledby='home-tab'>
                            <p>Apellido</p>
                            <p>Nombre</p>
                            <p>Tareas finalizadas</p>
                                <div class='card'>
                                    <div class='card-body'>
                                    <!-- Table with hoverable rows -->
                                    <table class='table table-hover'>
                                        <thead>
                                        <tr>
                                            <th scope='col'>Tarea</th>
                                            <th scope='col'>Observacion</th>
                                            <th scope='col'>Fecha inicio</th>
                                            <th scope='col'>Fecha fin</th>
                                            <th scope='col'>Tiempo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope='row'>Tarea 1</th>
                                            <td>En proceso</td>
                                            <td>2016-05-25</td>
                                            <td>2016-05-25</td>
                                            <td>28</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>Tarea 2</th>
                                            <td>En proceso</td>
                                            <td>2016-05-25</td>
                                            <td>2016-05-25</td>
                                            <td>28</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>Tarea 3</th>
                                            <td>En proceso</td>
                                            <td>2016-05-25</td>
                                            <td>2016-05-25</td>
                                            <td>28</td>
                                        </tr>
                                        <tr>
                                            <th scope='row'>Tarea 4</th>
                                            <td>En proceso</td>
                                            <td>2016-05-25</td>
                                            <td>2016-05-25</td>
                                            <td>28</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- End Table with hoverable rows -->

                                    </div>
                                </div>
                            <p>Tareas en proceso</p>
                            <p>Tareas suspendidas</p>
                        </div>
                        <div class='tab-pane fade' id='profile-justified' role='tabpanel' aria-labelledby='profile-tab'>
                            Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
                        </div>
                        <div class='tab-pane fade' id='contact-justified' role='tabpanel' aria-labelledby='contact-tab'>
                            Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
                        </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>";
        }

        desconectar($con);   
      
        if ($fila!="") echo $encabezado."".$fila."".$pie;
        else echo $encabezado."<tr><td style='text-align: center;' colspan='9'>Sin datos para mostrar</td></tr>".$pie;
    }
    else
    {
        echo $encabezado."<tr><td style='text-align: center;' colspan='9'>Falta indicar un rango de fecha a analizar</td></tr>".$pie;
    }
?>