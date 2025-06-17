<?php
  session_start();

  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
  
  if (isset($_SESSION['id']))
  {  
    //OBTENIENDO DATOS DEL GET
    $num=$_GET["num"];
    $idtarea=$_GET["idtarea"];
    $estado="D";
    $accion="N";
    $id=$_SESSION['id'];
    $fechaaccion=date("Y-m-d H:i:s"); 

    //ALTA DEL NUEVO SOCIO
    
    $sql="INSERT INTO detalleorden (numeroorden,idtarea,estado,accion,idempleadoaccion,fechaaccion)
          VALUES (?,?,?,?,?,?);";

    $con=conectar();
    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
    mysqli_stmt_bind_param($sentencia,'ssssss',$num,$idtarea,$estado,$accion,$id,$fechaaccion);
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
    echo "<script> window.location.href='index.html'</script>";
  }   
?>