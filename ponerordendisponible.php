<?php 
  session_start(); 
?>

<?php
    include "configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");
    
    if (isset($_SESSION['id']))
    {  
        $id=1;
        $idpersonadisp=$_SESSION['id'];
        $accion="...";
        $numorden=$_GET['orden'];
        $estado=$_GET['estado'];
        $titulo=$_GET['titulo'];
        $msn="";

        if ($numorden>0)
        {
            
            //SE CAMBIA DE ESTADO DE LA ORDEN SELECCIONADA A DISPONIBLE PARA QUE ALGUN MECANICO TRATE ALGUNA 
            //DE SUS TAREAS
        
            $accion="M";
            $fechaaccion=date("Y-m-d H:i:s"); 
            //PONE ORDEN EN DISPONIBLE
            $sql="UPDATE numeroorden SET tituloorden=?,estado=?,idpersonadisp=?,accion=?,idempleadoaccion=?,fechaaccion=?
                    WHERE numorden=?;";

            $con=conectar();
            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
            mysqli_stmt_bind_param($sentencia,'sssssss',$titulo,$estado,$idpersonadisp,$accion,$id,$fechaaccion,$numorden);
            $resp2=mysqli_stmt_execute($sentencia);
            
            desconectar($con);
                
            if ($resp2)  
            {//DETALLE ORDEN EN DISPONIBLE
                $sql="UPDATE detalleorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
                    WHERE numeroorden=?;";

                $con=conectar();
                $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$id,$fechaaccion,$numorden);
                $resp=mysqli_stmt_execute($sentencia);
                
                desconectar($con);

                if ($resp)  
                {//SE BUSCA ORDEN CON OTRO ESTADO Y SE LO DA DE BAJA
                    $accion="B";
                    $sql="UPDATE autorizaraccorden SET accion=?,idempleadoaccion=?,fechaaccion=?
                            WHERE numorden=?;";

                    $con=conectar();
                    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
                    mysqli_stmt_bind_param($sentencia,'ssss',$accion,$idpersonadisp,$fechaaccion,$numorden);
                    $resp=mysqli_stmt_execute($sentencia);
                    
                    desconectar($con);

                    if ($resp)  
                    {
                    
                        $msn=""; //DISPONIBLE OK. orden=".$numorden."-idempleado=".$id."-estado=".$estado."-titulo=".$titulo;
                   
                    }
                    else
                    {
                        $msn="<p style='text-align: center;'>Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.</p>";
                    }
                }
                else
                {
                    $msn="<p style='text-align: center;'>Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.</p>";
                } 
            }
            else
            {
                $msn="<p style='text-align: center;'>Error!!!. La accion de actualizar la orden a disponible dio error. Intente de nuevo.</p>";
            } 
            
        }
        else
        {
            $msn="<p style='text-align: center;'>Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.</p>";   
        } 

        echo $msn;
    }
    else
    {
        echo "<script> window.location.href='index.html'</script>";
    }   
?>