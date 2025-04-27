<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
      $numorden=$_GET['num'];
      $idtarea=$_GET['idtarea'];
      $idmecanico=$_GET['idmecanico'];
      $estadocambia=$_GET['estado'];

      //INGRESO PEDIDO DE VINCULACIÓN DEL MECANICO A LA TAREA DE  LA ORDEN DE TRABAJO Y LO PONGO EN PROCESO
      $idusuario=$_SESSION['id'];

      //SE ANALIZA ESTADO AL QUE SE DEBERA DE INVIAR LA TAREA SEGUN LO INDICADO POR MECANICO
      switch ($estadocambia)
      {
            case "I":
                    $fechaaccion=date("Y-m-d H:i:s"); 
                    $estado="D";
                    $obs="SE INICIA TAREA";
                    
                    //ALTA DEL NUEVO PEDIDO DE LA ORDEN VS MECANICO
                    
                    $sql="DELETE FROM afectadostareas WHERE numorden=? AND idtarea=?;";

                    $con=conectar();
                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                    mysqli_stmt_bind_param($sentencia,'ss',$numorden,$idtarea);
                    $resp=mysqli_stmt_execute($sentencia);

                    desconectar($con);

                    if ($resp)  
                    {
                        $accion="M";
                        //SE PONE A LA TAREA EN PROCESO DENTRO DE LA ORDEN
                        $sql="UPDATE detalleorden SET estado=?,fini=null,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numeroorden=? AND idtarea=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'ssssss',$estado,$accion,$idmecanico,$fechaaccion,$numorden,$idtarea);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);
                    
                        $sql="UPDATE numeroorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numorden=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$idmecanico,$fechaaccion,$numorden);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);

                        echo "0"; //Se realizo la accion correctamente
                    }
                    else
                    {
                        echo "1"; //La acción dio error
                    }
            break;
            case "P":
                    $accion="N";
                    $fechaaccion=date("Y-m-d H:i:s"); 
                    $estado="P";
                    $obs="SE INICIA TAREA";
                    
                    //ALTA DEL NUEVO PEDIDO DE LA ORDEN VS MECANICO
                    
                    $sql="INSERT INTO afectadostareas (numorden,idtarea,estado,idempleado,observacion,fechaobs)
                          VALUES (?,?,?,?,?,?);";

                    $con=conectar();
                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                    mysqli_stmt_bind_param($sentencia,'ssssss',$numorden,$idtarea,$estado,$idmecanico,$obs,$fechaaccion);
                    $resp=mysqli_stmt_execute($sentencia);

                    desconectar($con);

                    if ($resp)  
                    {
                        $accion="M";
                        //SE PONE A LA TAREA EN PROCESO DENTRO DE LA ORDEN
                        $sql="UPDATE detalleorden SET estado=?,fini=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numeroorden=? AND idtarea=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'sssssss',$estado,$fechaaccion,$accion,$idmecanico,$fechaaccion,$numorden,$idtarea);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);
                    
                        $sql="UPDATE numeroorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numorden=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$idmecanico,$fechaaccion,$numorden);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);

                        echo "0"; //Se realizo la accion correctamente
                    }
                    else
                    {
                        echo "1"; //La acción dio error
                    }
            break;
            case "F":
                    $accion="M";
                    $fechaaccion=date("Y-m-d H:i:s"); 
                    $estado="F";
                    $obs= $_GET['obs'];
                    
                    //ALTA DEL NUEVO PEDIDO DE LA ORDEN VS MECANICO
                    
                    $sql="UPDATE afectadostareas SET estado=?,idempleado=?,observacion=?,fechaobs=?
                          WHERE numorden=? AND idtarea=?;";

                    $con=conectar();
                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                    mysqli_stmt_bind_param($sentencia,'ssssss',$estado,$idmecanico,$obs,$fechaaccion,$numorden,$idtarea);
                    $resp=mysqli_stmt_execute($sentencia);

                    desconectar($con);

                    if ($resp)  
                    {
                        $accion="M";
                        //SE PONE A LA TAREA EN FINALIZADA DENTRO DE LA ORDEN
                        $sql="UPDATE detalleorden SET estado=?,ffin=?,observacion=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numeroorden=? AND idtarea=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'ssssssss',$estado,$fechaaccion,$obs,$accion,$idmecanico,$fechaaccion,$numorden,$idtarea);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);

                        //SE DETERMINA LA CANTIDAD DE TAREAS QUE TIENE EN CURSO VS FINALIZADAS
                        $totaltareas=0;
                        $totalfin=0;

                        $sql = "SELECT COUNT(a.`idtarea`) AS totaltareas,(SELECT COUNT(b.`idtarea`) 
                                                                        FROM detalleorden b 
                                                                        WHERE b.`accion`!='B' AND b.`estado`='F' AND b.`numeroorden`=a.numeroorden) AS totalfin
                              FROM detalleorden a
                              WHERE a.`accion`!='B' AND a.`numeroorden`=". $numorden;

                        $con=conectar();

                        $result = $con->query($sql);

                        if (!$result) 
                        {
                              die('Invalid query: ' . $con->error);
                        }

                        if (!$result) 
                        {
                              die('Invalid query: ' . $mysqli->error);
                        }
                        else
                        {
                              while($row = mysqli_fetch_array($result))
                              {
                                    $totaltareas=$row['totaltareas'];
                                    $totalfin=$row['totalfin'];
                              }

                              desconectar($con);
                        }

                        if ($totalfin<$totaltareas) $estado="P";

                        $sql="UPDATE numeroorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
                              WHERE numorden=?;";

                        $con=conectar();
                        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                        mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$idmecanico,$fechaaccion,$numorden);
                        $resp=mysqli_stmt_execute($sentencia);

                        desconectar($con);

                        //SE ACTUALIZA TIEMPOS DE TAREAS GUARDANDO LOS MEJORES
                              $ttarea=0;
                              $tnuevo=0;
                              $sql = "SELECT a.`idtarea`,max(a.`tiempotarea`) as tiempot,TIMESTAMPDIFF(MINUTE, b.`fini`,b.`ffin`) AS tiempo 
                                      FROM tareas a inner join detalleorden b on (a.`idtarea`=b.`idtarea`)
                                      WHERE a.`idtarea`=". $idtarea ."
                                      GROUP BY a.`idtarea`;";

                              $con=conectar();

                              $result = $con->query($sql);

                              if (!$result) 
                              {
                                    die('Invalid query: ' . $con->error);
                              }

                              if (!$result) 
                              {
                                    die('Invalid query: ' . $mysqli->error);
                              }
                              else
                              {
                                    while($row = mysqli_fetch_array($result))
                                    {
                                          $ttarea=$row['tiempot'];
                                          $tnuevo=$row['tiempo'];
                                    }

                                    desconectar($con);
                              }

                              if (($ttarea==0)||($tnuevo<$ttarea))  
                              {
                                    $sql="UPDATE tareas SET tiempotarea=?,accion=?,idempleadoaccion=?,fechaaccion=?
                                          WHERE idtarea=?;";
                              
                                    $con=conectar();
                                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                                    mysqli_stmt_bind_param($sentencia,'sssss',$tnuevo,$accion,$idmecanico,$fechaaccion,$idtarea);
                                    $resp=mysqli_stmt_execute($sentencia);

                                    desconectar($con);
                              }
                        //FIN ACTUALIZA TIEMPO DE TAREAS
                    
                        echo "0"; //Se realizo la accion correctamente
                    }
                    else
                    {
                        echo "1"; //La acción dio error
                    }
            break;
      }
  }
  else
  {
      header('Location: index.php');
      exit;
  }   
?>