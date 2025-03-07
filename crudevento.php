<?php
        include "configuracion/conexion.php";
        date_default_timezone_set("America/Argentina/Tucuman");

        session_start(); 

        if (isset($_SESSION['id']))
        {  
                $id=$_SESSION['id'];
                $fechaaccion=date("Y-m-d H:i:s"); 
                $idev="0";
                $accion="...";
        
                //SE RECUPERAN LOS DATOS DEL NUEVO SOCIO
                if (isset($_GET['idev']))
                {
                        //SE RECUPERAN DATOS DEL EVENTO Y LA ACCIÓN A REALIZAR CON ESE EVENTO
                        $acc= $_GET['acc'];
                        $idev=$_GET['idev'];
                        $evento=$_GET['evento'];
                        $fini=$_GET['fini'];
                        $ffin=$_GET['ffin'];
                        $todo=$_GET['todo'];

                        switch ($acc)
                        {
                                case 'N':
                                        //INSERTO NUEVO EVENTO
                                        $sql="INSERT INTO eventos (evento,fini,ffin,accion,idempleadoaccion,fechaaccion)
                                              VALUES (?,?,?,?,?,?);";

                                        $con=conectar();
                                      
                                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                        mysqli_stmt_bind_param($sentencia,'ssssss',$evento,$fini,$ffin,$acc,$id,$fechaaccion);
                                        $respsoc=mysqli_stmt_execute($sentencia);
                                        
                                        desconectar($con);
                                       
                                        //SE RECUPERO ID DEL NUEVO EVENTO
                                        $sql = "SELECT idevento
                                                FROM eventos
                                                WHERE accion!='B' AND evento='". $evento ."' AND idempleadoaccion=". $id ." AND fechaaccion='". $fechaaccion ."';";
                                       
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
                                                $elemento="";
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                        $elemento=$row['idevento'];
                                                }
                                        }
                                        desconectar($con);
                               
                                        echo $elemento;
                                        
                                break;
                                case 'M':
                                        //ACTUALIZO EVENTO DEL CALENDARIO
                                        $sql="UPDATE eventos SET fini=?,ffin=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                              WHERE idevento=?;";

                                        $con=conectar();
                                      
                                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                        mysqli_stmt_bind_param($sentencia,'ssssss',$fini,$ffin,$acc,$id,$fechaaccion,$idev);
                                        $respsoc=mysqli_stmt_execute($sentencia);
                                        
                                        desconectar($con);
                                        
                                        echo $idev;
                                break;
                                case 'B':
                                        //ELIMINO EVENTO DEL CALENDARIO
                                        $sql="UPDATE eventos SET accion=?,idempleadoaccion=?,fechaaccion=? 
                                              WHERE idevento=?;";

                                        $con=conectar();
                                      
                                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                        mysqli_stmt_bind_param($sentencia,'ssss',$acc,$id,$fechaaccion,$idev);
                                        $respsoc=mysqli_stmt_execute($sentencia);
                                        
                                        desconectar($con);
                                       
                                        echo $idev;
                                break;     
                        }
                }
                else
                {
                        header('Location: index.php');
                        exit;
                }  
        }
        else
        {
                header('Location: index.php');
                exit;
        }   
?>