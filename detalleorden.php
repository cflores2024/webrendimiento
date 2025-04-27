<?php
    include "configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    session_start();
    $id=$_SESSION['id'];
    $num=$_GET['num'];
    $idtarea=0;

    if (isset($num))
    {
        //CHEQUEO SI ORDEN DE TRABAJO YA FUE EXPORTADA DE ORACLE A MYSQL
        $sql = "SELECT count(a.`numorden`) as cant FROM numeroorden a where a.`numorden`='".$num."';";

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
            $existe=0;

            //MUESTRA DETALLE DEL CLIENTE Y LA ORDEN DE TRABAJO
            while($row = mysqli_fetch_array($result))
            {
                $existe= $row['cant'];
            }

            desconectar($con);
        }
        //=============================================================FIN CHEQUEO EXISTENCIA ORDEN
        
        if ($existe!=0)
        {
            echo "<p style='text-align: center;'>Número de orden ". $num ." ya fue exportado para su tratamiento!!!</p>";
        }
        else
        {
            //TRAIGO DATOS DE LA ORDEN DE ORACLE
            //DATOS REFERENTE A LA ORDEN DE TRABAJO Y CLIENTE ASOCIADO A ESTA
            include "connect.php";

            $username = 'CESAR';
            $password = 'cesar';
            $connection_string = '//134.14.1.88/orcl';
            
            // Establish a connection
            $c = oci_connect($username, $password, $connection_string);
            
            if (!$c) 
            {
                echo "<p style='text-align: center;'>Error. No se puede establecer la comunicación con la base de datos de ORACLE!!!</p>";
            }
            else
            {
                // RECUPERO CABECERA DE LA ORDEN DE TRABAJO
                    $query = 'SELECT numero_or,fecha_carga_or,fecha_entrega_estimada_or,cliente,chasis,patente,kilom,dni,telefono,email 
                              FROM CAB_ORDREP_W 
                              WHERE numero_or = :eidbv';
                    
                    $s = oci_parse($c, $query);
                    
                    $myeid = $num;
                    oci_bind_by_name($s, ":EIDBV", $myeid);
                    oci_execute($s);
                    
                    $datos=array();
                    
                    while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                    {   
                        foreach ($row as $item) { $datos[]=$item; }
                    }
                    
                    // Close the Oracle connection
                    oci_close($c);
                    
                    $numorden=$datos[0];
                    $fcarga=explode(' ',$datos[1]);
                    $fdato=explode('/',$fcarga[0]);
                    $fcarga=$fdato[2]."-".$fdato[1]."-".$fdato[0]." ". $fcarga[1];
                   
                    //$fdato=explode('/',$datos[2]);
                    $fentrega=date("Y-m-d", strtotime($datos[2]));// $fdato[2]."-".$fdato[1]."-".$fdato[0];
                   
                    $cliente=$datos[3];
                    $chasis=$datos[4];
                    if (strlen($dato[5])<=0) $patente="0";
                    else $patente=$datos[5];
                    $kilometraje=$datos[6];
                    if (strlen($dato[7])<=0) $dni=$numorden;
                    else $dni=$datos[7];
                    $tel=$datos[8];
                    $email=$datos[9];

                    //echo "Datos=>". $numorden ."=fechacarga=>". $fcarga ."=fentrega=>". $fentrega ."=". $cliente ."=". $chasis ."=". $patente ."=". $kilometraje ."=". 
                    //$dni ."=". $tel ."=". $email;
                //============================================================SE RECUPERO CABECERA ORDEN DE TRABAJO ORACLE
               
                if (strlen($numorden)<=0) 
                {
                    echo "<p style='text-align: center;'>No existe el número de orden ". $num ." en ORACLE!!!</p>";
                }
                else
                {
                    //DETALLE DE LO QUE SE TIENE QUE HACER EN LA ORDEN DE TRABAJO
                        $query = 'SELECT texto FROM ORDREP_W WHERE NUMERO= :eidb';

                        $s = oci_parse($c, $query);

                        $myeid = $num;
                        oci_bind_by_name($s, ":EIDB", $myeid);
                        oci_execute($s);

                        unset($datos); //LIMPIA ARRAY Y LO DEJA SIN ELEMENTOS
                        
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {
                            foreach ($row as $item) 
                            { 
                                $datos[]=$item;
                            }
                        }
                        
                        // Close the Oracle connection
                        oci_close($c);
                    //============================================================SE RECUPERO DETALLE ORDEN DE TRABAJO ORACLE
                
                    //=========================================SE CHEQUEA SI EXISTE CLIENTE
                        //BUSCO CLIENTE EN MYSQL
                        $sql = "SELECT a.`idpersona` FROM personas a WHERE a.`accion`!='B' AND a.`idtipopersona`=2 AND a.`dni`='".$dni."';";

                        $con=conectar();

                        $result = $cnx->query($sql);
                        $bandera=false;

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
                            $idcliente=0;
                            while($row = mysqli_fetch_array($result))
                            {
                                $idcliente=$row['idpersona']; //SI EXISTE CLIENTE SE OBTIENE ID DEL CLIENTE
                            }
                        }

                        desconectar($con);

                    //CLIENTE NO EXISTE SE LO DA DE ALTA
                        if ($idcliente<=0)
                        {
                            $txtapellido="";
                            $txtnombre=$cliente;
                            $txtdni=$dni;
                            $txttel=$tel;
                            $txtemail=$email;
                            $accion="N";
                            $fechaaccion=date("Y-m-d H:i:s"); 
                            $idtipoper="2";
                            $idarea="2";

                            $sql="INSERT INTO personas (apellido,nombre,dni,idtipopersona,emailusuario,tel,idoficina,accion,idempleadoaccion,fechaaccion)
                                VALUES (?,?,?,?,?,?,?,?,?,?);";

                            $con=conectar();
                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                            mysqli_stmt_bind_param($sentencia,'ssssssssss',$txtapellido,$txtnombre,$txtdni,$idtipoper,$txtemail,$txttel,$idarea,$accion,$id,$fechaaccion);
                            $respsoc=mysqli_stmt_execute($sentencia);
                                
                            desconectar($con);
                                                        
                            if ($respsoc)  
                            {
                                //RECUPERO ID DEL NUEVO CLIENTE
                                $sql = "SELECT a.`idpersona` FROM personas a WHERE a.`accion`!='B' AND a.dni='".$txtdni."';";
                                $respact="";

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
                                        $idcliente=$row['idpersona'];
                                    }
                                }

                                desconectar($con);
                                
                                //ALTA COMO CLIENTE VS DISCIPLINAS
                                $sql="INSERT INTO personasvsdisciplinas (idpersona,iddisciplina,accion,idempleadoaccion,fechaaccion)
                                    VALUES (?,?,?,?,?);";

                                $con=conectar();
                                $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                mysqli_stmt_bind_param($sentencia,'sssss',$idcliente,$idtipoper,$accion,$id,$fechaaccion);
                                $respact=mysqli_stmt_execute($sentencia);
                                desconectar($con);
                        
                                if (!$respact) $idcliente=0;
                            }
                            else $idcliente=0;
                        }
                    //======================================================================FIN TABLA CLIENTES MYSQL

                        //echo "Cliente=>". $idcliente;
                        if ($idcliente>0)
                        {     
                            //=======================================================================REALIZA ALTA DETALLE ORDEN
                            //echo "Total elementos=>". count($datos);      
                            
                            //================================================================SE CONTROLA QUE TAREA EXISTA Y LUEGO ALTA EN ORDEN
                                for ($i=0;$i<count($datos);$i++) 
                                { 
                                    //BUSCO DATOS DE LA TAREA EN LA CORRESPONDIENTE TABLA TAREAS EN MYSQL
                                    $idtarea=0;
                                    $datotarea=ltrim($datos[$i]);

                                    $sql = "SELECT a.idtarea
                                            from tareas a
                                            where a.`accion`!='B' and a.`descripciontarea`='". $datotarea ."';";

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
                                            $idtarea=$row['idtarea']; //SI EXISTE TAREA SE RECUPERO ID
                                        }
                                    }

                                    desconectar($con);

                                    if ($idtarea<=0)
                                    {
                                        //DOY DE ALTA LA TAREA
                                        $accion="N";
                                        $tiempo=0;
                                        $fechaaccion=date("Y-m-d H:i:s"); 

                                        $sql="INSERT INTO tareas (descripciontarea,tiempotarea,accion,fechaaccion,idempleadoaccion)
                                            VALUES (?,?,?,?,?);";

                                        $con=conectar();
                                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                        mysqli_stmt_bind_param($sentencia,'sssss',$datotarea,$tiempo,$accion,$fechaaccion,$id);
                                        $resp=mysqli_stmt_execute($sentencia);
                                            
                                        desconectar($con);
                                        //===================================================================FIN ALTA TAREA

                                        //RECUPERO ID DE LA NUEVA TAREA EN MYSQL
                                        $sql = "SELECT a.idtarea
                                                FROM tareas a
                                                WHERE a.`descripciontarea`='". $datotarea ."';";

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
                                            $idtarea=0;
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                $idtarea=$row['idtarea']; //SI EXISTE TAREA SE RECUPERO ID
                                            }
                                        }

                                        desconectar($con);
                                    }

                                    //echo $sql."-IDTAREA=".$idtarea."</br>";
                                
                                    //DOY DE ALTA TAREA EN EL DETALLE DE LA ORDEN
                                    $accion="N";
                                    $tiempotarea="0";
                                    $fechaaccion=date("Y-m-d H:i:s"); 
                                    $sql="INSERT INTO detalleorden (numeroorden,idtarea,tiempotarea,accion,idempleadoaccion,fechaaccion)
                                        VALUES (?,?,?,?,?,?);";

                                    $con=conectar();
                                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                    mysqli_stmt_bind_param($sentencia,'ssssss',$numorden,$idtarea,$tiempotarea,$accion,$id,$fechaaccion);
                                    $resp=mysqli_stmt_execute($sentencia);
                                        
                                    desconectar($con);

                                    //echo "IdTarea=". $idtarea ."-Tarea=". $datotarea ."-Numorden=". $numorden ."</br>";
                                }
                            //===================================================================FIN ALTA DETALLE DE LA ORDEN
                        
                            //===================================================================ALTA ORDEN DE TRABAJO
                    
                            //NUMERO DE ORDEN DE TRABAJO NO EXISTE SE LA DA DE ALTA
                            $accion="N";
                            $fechaaccion=date("Y-m-d H:i:s"); 
                            $sql="INSERT INTO numeroorden (numorden,fecha,fechaentrega,idcliente,numchasis,patente,kilometraje,accion,fechaaccion,idempleadoaccion)
                            VALUES (?,?,?,?,?,?,?,?,?,?);";

                            $con=conectar();
                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                            mysqli_stmt_bind_param($sentencia,'ssssssssss',$numorden,$fcarga,$fentrega,$idcliente,$chasis,$patente,$kilometraje,$accion,$fechaaccion,$id);
                            $resp=mysqli_stmt_execute($sentencia);
                                
                            desconectar($con);
                                                    
                            if ($resp) $numorden=$num;
                            else $numorden=0;
                            
                            //echo "Fecha carga=". $fcarga ."-idcliente=". $idcliente ."-Numorden=". $numorden ."</br>";
                            //===================================================================FIN ALTA ORDEN DE TRABAJO

                            //========================================================MUESTRO RESULTADOS ORDEN DE TRABAJO QUE SE EXPORTO DESDE ORACLE A MYSQL
                            $sql = "SELECT CONCAT(a.`apellido`,', ', a.`nombre`) AS cliente, a.`domicilio`,b.`modelo`,b.`numchasis`,b.`patente`,b.`kilometraje`,b.`fventa`
                                    FROM personas a INNER JOIN numeroorden b ON (a.`idpersona`=b.`idcliente` AND b.`accion`!='B')
                                    WHERE a.accion!='B' AND a.`idtipopersona`=2 AND b.`numorden`='".$numorden."';";

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

                                //MUESTRA DETALLE DEL CLIENTE Y LA ORDEN DE TRABAJO
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
                            }

                            desconectar($con);

                            $sql = "SELECT b.`descripciontarea`,a.`tiempotarea`,a.`estado`
                                    FROM detalleorden a INNER JOIN tareas b ON (a.`idtarea`=b.`idtarea` AND b.`accion`!='B')
                                    WHERE a.`accion`!='B' AND a.`numeroorden`='".$numorden."' ORDER BY a.`estado`,a.`fini`;";

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
                                //MUESTRA DETALLE DE LA ORDEN Y LAS TAREAS
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
                                        case "S": //LA TAREA ESTA EN PROCESO DE PASAR A DISPONIBLE
                                                $infofilas=$infofilas. "<tr>
                                                                            <th scope='row'>".$fil."</th>
                                                                            <td>".$row['descripciontarea']."</td>
                                                                            <td>".$row['tiempotarea']."</td>
                                                                        </tr>";
                                        break;
                                    }

                                    $fil=$fil+1;
                                }
                            }

                            desconectar($con);

                            echo $info."".$infoencabezado."".$infofilas."".$infopie;
                            //========================================================FIN MUESTRO RESULTADOS ORDEN DE TRABAJO
                        }
                        else $numorden=0;
                }  

            }
        }
    }
    else
    {
      header('Location: index.php');
      exit;
    }  
?>