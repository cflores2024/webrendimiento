<?php
   
    include "/configuracion/conexion.php";
  
    $numorden=$_GET['num'];

    if (isset($numorden))
    {  
        $sql = "SELECT CONCAT(a.`apellido`,', ', a.`nombre`) AS cliente, a.`domicilio`,b.`modelo`,b.`numchasis`,b.`patente`,b.`kilometraje`,b.`fventa`
                FROM personas a INNER JOIN numeroorden b ON (a.`idpersona`=b.`idcliente` AND b.`accion`!='B')
                WHERE a.accion!='B' AND a.`idtipopersona`=2 AND b.`numorden`='".$numorden."';";

        $con=conectar();

        $result = mysqli_query($con,$sql);

        $info="";

        while($row = mysqli_fetch_array($result))
        {
            $info= "
                <section class='section'>
                    <div class='row'>
                        <div class='col-lg-6'>
                            <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>Datos Cliente</h5>
                                <!-- General Form Elements -->
                                <form>
                                <div class='row mb-3'>
                                    <label for='inputText' class='col-sm-3 col-form-label'>Cliente</label>
                                    <div class='col-sm-9'>
                                    <input type='text' class='form-control' value='".$row['cliente']."'>
                                    </div>
                                </div>
                                <div class='row mb-3'>
                                    <label for='inputEmail' class='col-sm-3 col-form-label'>Domicilio</label>
                                    <div class='col-sm-9'>
                                    <input type='text' class='form-control' value='".$row['domicilio']."'>
                                    </div>
                                </div>
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
                                <div class='row mb-3'>
                                    <label for='inputNumber' class='col-sm-3 col-form-label'>F. Venta</label>
                                    <div class='col-sm-9'>
                                    <input type='text' class='form-control' value='".$row['fventa']."'>
                                    </div>
                                </div>
                                </form>
                                <!-- End General Form Elements -->
                            </div>
                        </div>
                    </div>";
        }

        desconectar($con);

        $sql = "SELECT b.`descripciontarea`,a.`tiempotarea`,a.`estado`
                FROM detalleorden a INNER JOIN tareas b ON (a.`idtarea`=b.`idtarea` AND b.`accion`!='B')
                WHERE a.`accion`!='B' AND a.`numeroorden`='".$numorden."' ORDER BY a.`estado`,a.`fini`;";

        $con=conectar();

        $result = mysqli_query($con,$sql);

        $infoencabezado="<div class='col-lg-6'>
                            <div class='card'>
                            <div class='card-body'>
                                <h5 class='card-title'>Lista de Tareas</h5>

                                <!-- Table with stripped rows -->
                                <table class='table table-striped'>
                                <thead>
                                    <tr>
                                    <th scope='col'>#</th>
                                    <th scope='col'>Descripción</th>
                                    <th scope='col'>Tiempo</th>
                                    </tr>
                                </thead>
                                <tbody>";
        $infofilas="";
        $infopie="</tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                    </div>
                    </div>
                    </div>
                    </div>
                </section>";
        $fil=1;
        
        while($row = mysqli_fetch_array($result))
        {
            switch($row['estado'])
            {
                case "D": //LA TAREA ESTA DISPONIBLE
                            $infofilas=$infofilas. "<tr>
                                                        <th scope='row'>".$fil."</th>
                                                        <td>".$row['descripciontarea']."</td>
                                                        <td>Disponible</td>
                                                    </tr>";
                break;
                case "P": //LA TAREA ESTA EN PROCESO
                        $infofilas=$infofilas. "<tr>
                                                    <th scope='row'>".$fil."</th>
                                                    <td>".$row['descripciontarea']."</td>
                                                    <td>En Proceso</td>
                                                </tr>";
                break;
                case "F": //LA TAREA ESTA FINALIZADA
                        $infofilas=$infofilas. "<tr>
                                                    <th scope='row'>".$fil."</th>
                                                    <td>".$row['descripciontarea']."</td>
                                                    <td>".$row['tiempotarea']."</td>
                                                </tr>";
                break;
            }

            $fil=$fil+1;
        }

        desconectar($con);

       echo $info."".$infoencabezado."".$infofilas."".$infopie;
    }
    else
    {
      header('Location: index.php');
      exit;
    }   
  

/*    echo "
             <section class='section'>
                <div class='row'>
                    <div class='col-lg-6'>
                        <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>Datos Cliente</h5>
                            <!-- General Form Elements -->
                            <form>
                            <div class='row mb-3'>
                                <label for='inputText' class='col-sm-3 col-form-label'>Cliente</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='Cesar Flores'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputEmail' class='col-sm-3 col-form-label'>Domicilio</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='Colon 123'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputPassword' class='col-sm-3 col-form-label'>Modelo</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='FIAT UNO'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputNumber' class='col-sm-3 col-form-label'>N° Chasis</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='ADV12345ED'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputNumber' class='col-sm-3 col-form-label'>Patente</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='ADF234'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputNumber' class='col-sm-3 col-form-label'>Kilometraje</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='136.000'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='inputNumber' class='col-sm-3 col-form-label'>F. Venta</label>
                                <div class='col-sm-9'>
                                <input type='text' class='form-control' value='15/05/2013'>
                                </div>
                            </div>
                            </form>
                            <!-- End General Form Elements -->
                        </div>
                        </div>

                    </div>
                    <div class='col-lg-6'>

                        <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>Lista de Tareas</h5>

                            <!-- Table with stripped rows -->
                            <table class='table table-striped'>
                            <thead>
                                <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Descripción</th>
                                <th scope='col'>Tiempo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope='row'>1</th>
                                <td>Cambio Filtro</td>
                                <td>15 min</td>
                                </tr>
                                <tr>
                                <th scope='row'>2</th>
                                <td>Cambio Aceite</td>
                                <td>30 min</td>
                                </tr>
                                <tr>
                                <th scope='row'>3</th>
                                <td>Cambio de foco guiño derecho delantero</td>
                                <td>2 horas</td>
                                </tr>
                                <tr>
                                <th scope='row'>4</th>
                                <td>Cambio de luz de freno trasera derecha</td>
                                <td>2 horas</td>
                                </tr>
                            </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                        </div>

                    </div>
                </div>
            </section>
    ";*/
?>