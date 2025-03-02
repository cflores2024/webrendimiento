<!--// CHEQUEO DATOS LOGIN -->
<?php
    include "/configuracion/conexion.php";

    $id="";
    $lsfotos="";
    $orden="";
    $titulo="";
    $idpersona="";
    $faccion="";
    $filas="";
    
    session_start();

    if (isset($_SESSION['id']))
    {  
        $id=$_SESSION['id'];
    }
    else
    {
        header('Location: index.php');
        exit;
    }   

    $sql = "SELECT a.`numorden`,a.`tituloorden`,b.`idpersona`,
                    (SELECT CONCAT(xx.`apellido`,', ',xx.`nombre`) FROM personas xx WHERE xx.idpersona=b.idpersona AND xx.accion!='B') AS empleado
                    ,b.`estado`,a.`fechaaccion`
            FROM numeroorden a LEFT JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
            WHERE a.`accion`!='B' AND a.`estado` NOT IN ('S','F') AND b.`idpersona` IS NULL
            UNION
            SELECT a.`numorden`,a.`tituloorden`,b.`idpersona`,
                    (SELECT CONCAT(xx.`apellido`,', ',xx.`nombre`) FROM personas xx WHERE xx.idpersona=b.idpersona AND xx.accion!='B') AS empleado
                    ,b.`estado`,a.`fechaaccion`
            FROM numeroorden a LEFT JOIN autorizaraccorden b ON (a.`numorden`=b.`numorden` AND b.`accion`!='B')
            WHERE a.`estado` NOT IN ('S','F') AND b.`estado`='P'
            GROUP BY 1,2,3,4,5,6
            ORDER BY 6;";

    $con=conectar();

    $result = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_array($result))
    {
        $orden=$row['numorden'];
        $titulo=$row['tituloorden'];
        $persona=$row['empleado'];
        $estado=$row['estado'];
        $faccion=$row['fechaaccion'];
       
        $filas=$filas."
                        <tr>
                            <th scope='row'><a href='#'>#".$orden."</a></th>
                            <td>".$titulo."</td>
                            <td>". $faccion ."</td>
                            <td>". $persona ."</td>";
    
        if ($estado=="P")
        {
            $filas=$filas."
                            <td>
                                <a href='#' title='No autoriza acceso'>
                                <img src='assets/img/usu_dele.png' srcset=''>
                                </a>
                            </td></tr>";
        }
        else
        {
            $filas=$filas."
                            <td>
                                <a href='#' title='Autoriza acceso'>
                                    <img src='assets/img/usu_autoriza.png' srcset=''>
                                </a>
                            </td></tr>";
        }
    }

    desconectar($con);

    echo "<section class='section'>
            <div class='row'>
                <div class='col-lg-12'>

                <div class='card'>
                    <div class='card-body'>
                    <h5 class='card-title'>Autoriza Acceso a Ordenes de Tareas</h5>
                    <p>Permite que un administrador autorice el pedido de mecanicos en acceder a una orden de trabajo.</p>
                    <!-- Table with stripped rows -->
                    <table class='table table-borderless datatable'>
                            <thead>
                            <tr>
                                <th scope='col'>N° Orden</th>
                                <th scope='col'>Titulo</th>
                                <th scope='col'>Fecha Solicitud</th>
                                <th scope='col'>Mecanico</th>
                                <th scope='col'>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>". $filas ."</tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                    </div>
                </div>
                </div>
            </div>
        </section>";
?>