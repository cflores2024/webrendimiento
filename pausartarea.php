<?php
  session_start();

  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
  
  if (isset($_SESSION['id']))
  {  
    $numorden=$_GET['num'];
    $idtarea=$_GET['idtarea'];
    $idempleado=$_GET['idmecanico'];
    $estado=$_GET['estado'];
    $obs=$_GET['obs'];
    $fechaaccion=date("Y-m-d H:i:s"); 
    
    $sql="INSERT INTO tareassuspendidas (numorden,idtarea,idempleado,suspendida,fechaaccion,observacion)
          VALUES (?,?,?,?,?,?);";
    
    $con=conectar();

    $sentencia=mysqli_prepare($con,$sql);//preparo consulta
    mysqli_stmt_bind_param($sentencia,'ssssss',$numorden,$idtarea,$idempleado,$estado,$fechaaccion,$obs);
    $resp=mysqli_stmt_execute($sentencia);

    desconectar($con);

    if ($resp)  
    {
        $sql="UPDATE afectadostareas SET suspendida=?
              WHERE numorden=? AND idtarea=?;";
    
        $con=conectar();

        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'sss',$estado,$numorden,$idtarea);
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
      echo "1"; //La acción dio error
    }
  }
  else
  {
    echo "<script> window.location.href='index.html'</script>";
  }   
?>