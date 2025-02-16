<?php

    include "/configuracion/conexion.php";

    $lsfotos="";
    $orden="";
    $idtarea="";
    $filas="";

    $sql = "SELECT a.`numeroorden`,a.`idtarea`,b.`patente`,c.`descripciontarea`,a.`observacion`,d.`idempleado`,a.`estado`,(SELECT xx.`urlfoto` FROM personas xx WHERE xx.accion!='B' AND xx.`idpersona`=d.idempleado) AS foto
            FROM detalleorden a INNER JOIN numeroorden b ON (a.`numeroorden`=b.`numorden` AND b.`accion`!='B')
                                INNER JOIN tareas c ON (a.`idtarea`=c.`idtarea` AND c.`accion`!='B')
                                LEFT JOIN afectadostareas d ON (a.`numeroorden`=d.`numorden` AND a.`idtarea`=d.`idtarea`) 
            WHERE a.`estado`!='S' AND a.`accion`!='B'
            GROUP BY a.`numeroorden`,a.`idtarea`,b.`patente`,c.`descripciontarea`,a.`observacion`,d.`idempleado`,a.`estado`
            ORDER BY a.`numeroorden`,a.`idtarea`;";

    $con=conectar();

    $result = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_array($result))
    {
        if (($orden==$row['numeroorden'])&&($idtarea==$row['idtarea']))
        {
            if (strlen($row['foto'])>0)
            {
                $lsfotos=$lsfotos."<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30'>";
            }
            else
            {
                $lsfotos=$lsfotos."&nbsp;";
            }
        }
        else
        {
            if (strlen($orden)>0)
            {
                $filas=$filas."
                                <tr>
                                    <th scope='row'><a href='#'>#".$orden."</a></th>
                                    <td>".$matricula."</td>
                                    <td>".$tarea."</td>
                                    <td>".$lsfotos."</td>";
                
                switch($estado)
                {
                    case "D":
                            $filas=$filas."
                                            <td><span class='badge bg-info text-dark'>En Espera</span></td>
                                            <td>
                                                <a href='#'>
                                                    <img src='assets/img/usu_add.png' alt='Sumarse a tarea' srcset=''>
                                                </a>
                                            </td>
                                            <td> 
                                                &nbsp;
                                            </td>
                                            <td> 
                                                &nbsp;
                                            </td></tr>";
                        break;
                    case "P":
                            $filas=$filas."
                                            <td><span class='badge bg-warning'>En proceso</span></td>
                                            <td>
                                                <a href='#'>
                                                <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' srcset=''>
                                                </a>
                                            </td>
                                            <td>
                                                <a href='#'>
                                                <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' srcset=''>
                                                </a>
                                            </td>
                                            <td> 
                                                &nbsp;
                                            </td></tr>";
                        break;
                    case "F":
                            $filas=$filas."
                                            <td><span class='badge bg-success'>Finalizado</span></td>
                                            <td>
                                                &nbsp;
                                            </td>
                                            <td> 
                                                &nbsp;
                                            </td>
                                            <td>
                                                <a href='#'>
                                                    <img src='assets/img/tarea_historia.png' alt='Ver Historial Patente' onclick='historial(\"$matricula\")'>
                                                </a>
                                            </td></tr>";
                    break;
                }
            }

            $orden=$row['numeroorden'];
            $idtarea=$row['idtarea'];
            $matricula=$row['patente'];
            $tarea=$row['descripciontarea'];
            $estado=$row['estado'];
            
            if (strlen($row['foto'])>0)
            {
                $lsfotos="<img src='./assets/img/".$row['foto']."' alt='Profile' class='rounded-circle' width='30' height='30'>";
            }
            else
            {
                $lsfotos="&nbsp;";
            }
        }   
    }

    $filas=$filas."
                    <tr>
                        <th scope='row'><a href='#'>#".$orden."</a></th>
                        <td>".$matricula."</td>
                        <td>".$tarea."</td>
                        <td>".$lsfotos."</td>";
    
    switch($estado)
    {
        case "D":
                $filas=$filas."
                                <td><span class='badge bg-info text-dark'>En Espera</span></td>
                                <td>
                                    <a>
                                        <img src='assets/img/usu_add.png' alt='Sumarse a tarea' srcset=''>
                                    </a>
                                </td>
                                <td> 
                                    &nbsp;
                                </td>
                                <td> 
                                    &nbsp;
                                </td></tr>";
            break;
        case "P":
                $filas=$filas."
                                <td><span class='badge bg-warning'>En proceso</span></td>
                                <td>
                                    <a>
                                    <img src='assets/img/usu_dele.png' alt='Desvincularse de tarea' srcset=''>
                                    </a>
                                </td>
                                <td>
                                    <a>
                                    <img src='assets/img/atender_tarea.png' alt='Continuar con tarea' srcset=''>
                                    </a>
                                </td>
                                <td> 
                                    &nbsp;
                                </td></tr>";
            break;
        case "F":
                $filas=$filas."
                                <td><span class='badge bg-success'>Finalizado</span></td>
                                <td>
                                    &nbsp;
                                </td>
                                <td> 
                                    &nbsp;
                                </td>
                                <td>
                                    <a>
                                        <img src='assets/img/tarea_historia.png' alt='alt='Ver Historial Patente' onclick='historial(\"$matricula\")'>
                                    </a>
                                </td></tr>";
        break;
    }

    desconectar($con);

    echo "<section class='section'>
            <div class='row'>
                <div class='col-lg-12'>

                <div class='card'>
                    <div class='card-body'>
                    <h5 class='card-title'>Toma de Ordenes de Tareas</h5>
                    <p>Permite que un empleado pueda tomar algunas de las tareas disponibles.</p>
                    <!-- Table with stripped rows -->
                    <table class='table table-borderless datatable'>
                            <thead>
                            <tr>
                                <th scope='col'>N° Orden</th>
                                <th scope='col'>Patente</th>
                                <th scope='col'>Tarea</th>
                                <th scope='col'>Afectados</th>
                                <th scope='col'>Estado</th>
                                <th scope='col'>&nbsp;</th>
                                <th scope='col'>&nbsp;</th>
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