<?php

include "/configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

session_start();

$idhorario="";

if (isset($_SESSION['id']))
{  
    $id=$_SESSION['id'];
    $accion="...";
    
    //SE RECUPERAN LOS DATOS DE LA NUEVA DISCIPLINA
    if (isset($_GET['idhora']))
    {
        //OBTENIENDO DATOS DEL POST
        $idhorario=$_GET['idhora'];
        $accion="B";
        $fechaaccion=date("Y-m-d H:i:s"); 
        
        //BORRAR HORARIO DE CLASE
        $sql="UPDATE horariosclases SET accion=?,idempleadoaccion=?,fechaaccion=?
              WHERE idhorarios=?;";

        $con=conectar();
        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'ssss',$accion,$id,$fechaaccion,$idhorario);
        $resp=mysqli_stmt_execute($sentencia);
        
        desconectar($con);
        
        if ($resp)  
        {
            echo "Horario Eliminado!!!";
        }
        else
        {
            echo "Error en la acción. No se pudieron eliminar los datos!";
        } 
    }
    else
    {
        echo "Faltan datos";
    } 
}
else
{
    header('Location: index.php');
    exit;
}   

?>