<?php 
    session_start(); 

    include "configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    $id=$_SESSION['id'];
    $num=$_GET['num'];
    $mecanico=$_GET['mecanico']; //1=UN MECANICO ESTA RECUPERANDO LA ORDEN. 0=UN SUPERVISOR ESTA RECUPERANDO LA ORDEN
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
                $query = "SELECT numero_or,fecha_carga_or,fecha_remito,cliente,chasis,patente,kilom,dni,telefono,email,donde_conocio,modelo,modelo_descrip  
                          FROM CAB_ORDREP_W 
                          WHERE numero_or = :eidbv";
                
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
                
                $fcompra=explode(' ',$datos[2]);
                $fdato=explode('/',$fcompra[0]);
                $fcompra=$fdato[2]."-".$fdato[1]."-".$fdato[0];
                
                $cliente=$datos[3];
                $chasis=$datos[4];
                
                if (strlen($datos[5])<=0) $patente="0";
                else $patente=$datos[5];
                
                $kilometraje=$datos[6];
                if (strlen($datos[7])<=0) $dni=$numorden;
                else $dni=str_replace('-','',$datos[7]);
                
                $tel=$datos[8];
                $email=$datos[9];
                $idpublicacion=0;
                $conocio=$datos[10];
                $codmodelo=$datos[11];
                $marcamodelo=$datos[12];

                //echo "Datos: numorden=>". $numorden ."</br>fcarga=>". $fcarga ."</br>fventa=>". $fcompra ."<br/>ApeNombCli=>". $cliente ."<br/>chasis=>". $chasis ."<br/>patente=>". $patente ."<br/>kilometraje=>". $kilometraje ."<br/>dni=>". 
                //$dni ."<br/>Tel=>". $tel ."<br/>Email=>". $email."<br/>CodModelo=>". $codmodelo ."<br/>Marca-Modelo=>". $marcamodelo;
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
                
                    //=========================SI PRESENTA TAREAS A EXPORTAR SIGUE CON EL PROCESO DE LO CONTRARIO EMITE MENSAJE
                        if(count($datos)>0)
                        {
                            //TRATAMIENTO SOBRE EL CLIENTE EN LA TABLA
                                //RECUPERO ID DEL CLIENTE SI EXISTE
                                    $idcliente=0;
                                    
                                    $sql = "SELECT a.`idpersona` FROM personas a WHERE a.`accion`!='B' AND a.dni='".$dni."';";
                                
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
                                //FIN CHEQUEO DE CLIENTE EN TABLA

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
                                                //FIN ALTA COMO CLIENTE VS DISCIPLINAS
                                            //FIN RECUPERO ID DEL NUEVO CLIENTE
                                        }
                                        else $idcliente=0;
                                    }
                                //FIN TABLA CLIENTES MYSQL
                            //FIN TRATAMIENTO SOBRE EL CLIENTE EN LA TABLA

                            //echo "Cliente=>". $idcliente;
                            if ($idcliente>0)
                            {     
                                //=======================================================================REALIZA ALTA DETALLE ORDEN
                                //echo "Total elementos=>". count($datos);      
                                
                                //TRATAMIENTO DE TAREAS Y ORDEN DE TRABAJO
                                    for ($i=0;$i<count($datos);$i++) 
                                    { 
                                        //VERIFICO SI TAREA EXISTE EN MYSQL
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
                                        //FIN VERIFICO SI TAREA EXISTE EN MYSQL

                                        if ($idtarea<=0)
                                        {
                                            //ALTA LA TAREA
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
                                            //FIN ALTA TAREA

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
                                            //FIN RECUPERO ID DE LA NUEVA TAREA EN MYSQL
                                        }

                                        //echo $sql."-IDTAREA=".$idtarea."</br>";
                                    
                                        //ALTA TAREA EN EL DETALLE DE LA ORDEN
                                            $accion="N";
                                            $tiempotarea="0";
                                            $fechaaccion=date("Y-m-d H:i:s"); 
                                            $sql="INSERT INTO detalleorden (numeroorden,idtarea,accion,idempleadoaccion,fechaaccion)
                                                VALUES (?,?,?,?,?);";

                                            $con=conectar();
                                            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                            mysqli_stmt_bind_param($sentencia,'sssss',$numorden,$idtarea,$accion,$id,$fechaaccion);
                                            $resp=mysqli_stmt_execute($sentencia);
                                                
                                            desconectar($con);
                                        //FIN ALTA TAREA EN EL DETALLE DE LA ORDEN
                                        
                                        //echo "IdTarea=". $idtarea ."-Tarea=". $datotarea ."-Numorden=". $numorden ."</br>";
                                    }
                                //FIN TRATAMIENTO DE TAREAS Y ORDEN DE TRABAJO
                                               
                                //TRATAMIENTO DEL DATO PUBLICIDAD EN MYSQL
                                    $sql = "SELECT a.`idpublicacion` FROM publicaciones a WHERE a.`publicacion`='". $conocio ."';";

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
                                            $idpublicacion=$row['idpublicacion']; //SI EXISTE publicidad SE RECUPERO ID
                                        }
                                    }

                                    desconectar($con);
                                    
                                    if ($idpublicacion<=0)
                                    {
                                        //DOY DE ALTA LA PUBLIDAD Y RECUPERO ID
                                        $sql="INSERT INTO publicaciones (publicacion) VALUES (?);";

                                        $con=conectar();
                                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                        mysqli_stmt_bind_param($sentencia,'s',$conocio);
                                        $resp=mysqli_stmt_execute($sentencia);
                                            
                                        desconectar($con);

                                        $sql = "SELECT a.`idpublicacion` FROM publicaciones a WHERE a.`publicacion`='". $conocio ."';";

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
                                                $idpublicacion=$row['idpublicacion']; //SI EXISTE publicidad SE RECUPERO ID
                                            }
                                        }

                                        desconectar($con);
                                    }
                                //FIN TRATAMIENTO DEL DATO PUBLICIDAD EN MYSQL

                                    if ($idpublicacion>0)
                                    {
                                    // echo "</br>ABM Modelo";
                                    // echo "</br>idpublicidad=".$idpublicacion;
                                    // echo "</br>codmodelo=".$codmodelo;

                                        //CHEQUEO SI EXISTE MARCA-MODELO
                                            $sql = "SELECT a.`codmodelo` FROM modelos a WHERE a.`codmodelo`='". $codmodelo ."';";
                                            $idmodelo=0;

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
                                                    $idmodelo=$row['codmodelo']; //SI EXISTE marca-modelo SE RECUPERO ID
                                                }
                                            }

                                            desconectar($con);
                                            
                                            if ($idmodelo<=0)
                                            {
                                                //ALTA LA MARCA Y MODELO DEL AUTO
                                                    $sql="INSERT INTO modelos (codmodelo,modelomarca) VALUES (?,?);";

                                                    $con=conectar();
                                                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                                    mysqli_stmt_bind_param($sentencia,'ss',$codmodelo,$marcamodelo);
                                                    $resp=mysqli_stmt_execute($sentencia);
                                                        
                                                    desconectar($con);

                                                    $sql = "SELECT a.`codmodelo` FROM modelos a WHERE a.`codmodelo`='". $codmodelo ."';";

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
                                                            $idmodelo=$row['codmodelo']; //SI EXISTE modelo-marca SE RECUPERO ID
                                                        }
                                                    }

                                                    desconectar($con);
                                                //FIN ALTA LA MARCA Y MODELO DEL AUTO
                                            }
                                        //FIN CHEQUEO MARCA-MODELO    
                                        
                                        if ($idmodelo>0)
                                        {
                                            //TRATAMIENTO DE ORDEN DE TRABAJO
                                                $accion="N";
                                                $fechaaccion=date("Y-m-d H:i:s"); 
                                                $sql="INSERT INTO numeroorden (numorden,fecha,fventa,idcliente,numchasis,patente,kilometraje,conocio,idpublicidad,codmodelo,accion,fechaaccion,idempleadoaccion)
                                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";

                                                $con=conectar();
                                                $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                                mysqli_stmt_bind_param($sentencia,'sssssssssssss',$numorden,$fcarga,$fcompra,$idcliente,$chasis,$patente,$kilometraje,$conocio,$idpublicacion,$codmodelo,$accion,$fechaaccion,$id);
                                                $resp=mysqli_stmt_execute($sentencia);
                                                    
                                                desconectar($con);
                                                                        
                                                if ($resp) $numorden=$num;
                                                else $numorden=0;
                                                
                                                //echo "Fecha carga=". $fcarga ."-idcliente=". $idcliente ."-Numorden=". $numorden ."</br>";
                                            //FIN TRATAMIENTO DE ORDEN DE TRABAJO

                                            //CHEQUEA EXISTENCIA DE ORDEN EXPORTADA ORACLE A MYSQL
                                                $sql = "SELECT CONCAT(a.`apellido`,', ', a.`nombre`) AS cliente, a.`domicilio`,d.modelomarca,b.`numchasis`,b.`patente`,b.`kilometraje`,b.`fventa`,c.publicacion
                                                        FROM personas a INNER JOIN numeroorden b ON (a.`idpersona`=b.`idcliente` AND b.`accion`!='B')
                                                                        INNER JOIN publicaciones c ON (b.idpublicidad=c.idpublicacion)
                                                                        INNER JOIN modelos d ON (d.codmodelo=b.codmodelo)
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
                                                                                    <input type='text' class='form-control' value='".$row['modelomarca']."'>
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
                                                                                <div class='row mb-3'>
                                                                                    <label for='inputNumber' class='col-sm-3 col-form-label'>Conocio Por</label>
                                                                                    <div class='col-sm-9'>
                                                                                    <input type='text' class='form-control' value='".$row['publicacion']."'>
                                                                                    </div>
                                                                                </div>
                                                                                </form>
                                                                                <!-- End General Form Elements -->
                                                                            </div>
                                                                        </div>
                                                                    </div>";
                                                        }
                                                    //FIN MUESTRA DETALLE DEL CLIENTE Y LA ORDEN DE TRABAJO
                                                }

                                                desconectar($con);

                                                $sql = "SELECT b.`descripciontarea`,b.`tiempotarea`,a.`estado`
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

                                                if ($mecanico==0) echo $info."".$infoencabezado."".$infofilas."".$infopie;
                                                if ($mecanico==1) echo "OK";
                                            //FIN MUESTRO RESULTADOS ORDEN DE TRABAJO
                                        }
                                        else $numorden=0;    
                                    }
                                    else $numorden=0;
                            }
                            else $numorden=0;
                        }
                        else
                        {
                            if ($mecanico==0)
                            {
                                $info= "
                                        <section class='section'>
                                            <div class='row'>
                                                <div class='col-lg-6'>
                                                    <div class='card'>
                                                        <div class='card-body'>
                                                            <h5 class='card-title'>Sin Datos Cliente</h5>
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
                                                                        <td colspan=3 style='text-align: center;'>Sin Datos</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- End Table with stripped rows -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>"; 

                                echo $info; 
                            }
                            else
                            { 
                               echo "<p style='text-align: center;'>Sin Datos</p>";
                            }      
                        }
                }  

            }
        }
    }
    else
    {
      echo "<script> window.location.href='index.html'</script>";
    }  
?>