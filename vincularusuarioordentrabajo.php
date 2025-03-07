<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $idusuario=$_SESSION['id'];
    $numorden=$_GET['num'];

    //INGRESO PEDIDO DE VINCULACIÓN DEL USUARIO A LA ORDEN DE TRABAJO Y LO PONGO EN PENDIENTE
    //PARA SU POSTERIOR AUTORIZACION
    $accion="N";
    $fechaaccion=date("Y-m-d H:i:s"); 
    $estado="P";
    $obs="SOLICITA";
    
    //ALTA DEL NUEVO PEDIDO DE LA ORDEN VS MECANICO
    
    $sql="INSERT INTO autorizaraccorden (numorden,idpersona,estado,observacion,accion,idempleadoaccion,fechaaccion)
          VALUES (?,?,?,?,?,?,?);";

    $con=conectar();
    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
    mysqli_stmt_bind_param($sentencia,'sssssss',$numorden,$idusuario,$estado,$obs,$accion,$idusuario,$fechaaccion);
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