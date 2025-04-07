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
    }
  }
  else
  {
    header('Location: index.php');
    exit;
  }   
?>