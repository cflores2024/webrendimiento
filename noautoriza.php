<!--// CHEQUEO DATOS LOGIN -->
<?php
  
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $idusuario=$_SESSION['id'];
    $numorden=$_GET['num'];
    $idempleado=$_GET['id'];
    
    //INGRESO PEDIDO DE VINCULACIÓN DEL USUARIO A LA ORDEN DE TRABAJO Y LO PONGO EN PENDIENTE
    //PARA SU POSTERIOR AUTORIZACION
    $accion="M";
    $fechaaccion=date("Y-m-d H:i:s"); 
    $estado="N";
    $obs="NO AUTORIZA";
    
    //AUTORIZO ORDEN VS MECANICO
  
    $sql="UPDATE autorizaraccorden SET estado=?,fechaautoriza=?,observacion=?,accion=?,idempleadoaccion=?,fechaaccion=?
          WHERE numorden=? AND idpersona=? AND estado='P';";
    
    $con=conectar();

    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
    mysqli_stmt_bind_param($sentencia,'ssssssss',$estado,$fechaaccion,$obs,$accion,$idusuario,$fechaaccion,$numorden,$idempleado);
    $resp=mysqli_stmt_execute($sentencia);

    desconectar($con);

    if ($resp)  
    {
        echo "0"; //Se realizo la accion correctamente
    }
    else
    {
        echo "1"; //La acción dio error
    }
  }
  else
  {
    header('Location: index.php');
    exit;
  }   
?>