<?php
    include "/configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    session_start();
    //RECUPERO DATOS SESSION
    if (isset($_SESSION['id']))
    {  
        $idusulog=$_SESSION['id'];
        $fechaaccion=date("Y-m-d H:i:s"); 

        $idsocio=$_POST["id"];
        $accion=$_POST["acc"];

        switch ($accion)
        {
            case "M":
                    $nombre_archivo = $_FILES['file']['name'];
                    $ruta_temporal_archivo = $_FILES['file']['tmp_name'];

                    //CAMBIO NOMBRE FOTO ANTES DE MOVER POR EL ID DE LA PERSONA
                    $archivo=explode(".",$nombre_archivo);
                    $nombre_archivo="avatar/". $idsocio .".". $archivo[1];
                    
                    $extensiones = array(0=>'image/jpg',1=>'image/jpeg',2=>'image/png');
                    $max_tamanyo = 1024 * 1024 * 8;
                    
                    if ( in_array($_FILES['file']['type'], $extensiones) ) 
                    {
                        //echo 'Es una imagen';
                        if ( $_FILES['imagen1']['size']< $max_tamanyo ) 
                        {
                            //echo 'Pesa menos de 1 MB';
                            //MUEVO FOTO AL SERVIDOR
                            //$ruta_indexphp = dirname(realpath(__FILE__));
                            //$ruta_nuevo_destino = $ruta_indexphp . '/assets/avatar/' . $nombre_archivo;
                            $ruta_nuevo_destino = "assets/img/". $nombre_archivo;

                            if( move_uploaded_file ( $ruta_temporal_archivo, $ruta_nuevo_destino ) ) 
                            {
                                //echo 'Fichero guardado con éxito';
                                //ACTUALIZO REGISTRO FOTO DE LA PERSONA
                                $sql="UPDATE personas SET urlfoto=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                    WHERE (idpersona=?);";

                                $con=conectar();
                                $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                mysqli_stmt_bind_param($sentencia,'sssss',$nombre_archivo,$accion,$idusulog,$fechaaccion,$idsocio);
                                $resp=mysqli_stmt_execute($sentencia);
                                
                                desconectar($con);
                                
                                if ($resp)  
                                {
                                    //echo "id=". $id ."-acc=". $acc ."-nombre_arc=". $nombre_archivo."-nombre_temp=". $ruta_temporal_archivo;
                                    echo "<img id='avatar' src='". $ruta_nuevo_destino ."' alt='Profile' class='rounded-circle'>";
                                }
                                else
                                {
                                    echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                                }
                            }
                            else
                            {
                                echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                            }
                        }
                        else
                        {
                            echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                        }
                    }
                    else
                    {
                        echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                    }
            break;
            case "B":
                
                    $ruta_archivo="assets/img/". $_POST["srcimg"];
                 
                    if( unlink ( $ruta_archivo ) ) 
                    {
                        $nombre_archivo= "user.png";
                        $accion="M";
                        //echo 'Fichero guardado con éxito';
                        //ACTUALIZO REGISTRO FOTO DE LA PERSONA
                        $sql="UPDATE personas SET urlfoto=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE (idpersona=?);";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'sssss',$nombre_archivo,$accion,$idusulog,$fechaaccion,$idsocio);
                        $resp=mysqli_stmt_execute($sentencia);
                        
                        desconectar($con);
                        
                        if ($resp)  
                        {
                            //echo "id=". $id ."-acc=". $acc ."-nombre_arc=". $nombre_archivo."-nombre_temp=". $ruta_temporal_archivo;
                            echo "<img id='avatar' src='assets/img/". $nombre_archivo ."' alt='Profile' class='rounded-circle'>";
                        }
                        else
                        {
                            echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                        }
                    }
                    else
                    {
                        echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
                    }
                    
            break;
        }
    }
    else
    {
        echo "<img id='avatar' src='assets/img/user.png' alt='Profile' class='rounded-circle'>";
    }
    
?>