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
    
    $idsuspendida=0;
    //SE BUSCA SI TAREA EXISTE Y ESTA SUSPENDIDA
    $sql = "SELECT a.`idtareasuspendida` 
            FROM tareassuspendidas a 
            WHERE a.`numorden`=".$numorden." AND a.`idtarea`=".$idtarea." AND a.`suspendida`='S';";

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
        $idsuspendida=$row['idtareasuspendida'];
      }
    }

    desconectar($con);

    //SI NO EXISTEN TAREA EN ORDEN SUSPENDIDA SE LA DA DE ALTA Y SE LA SUSPENDE
    if ($idsuspendida<=0)
    {
      $sql="INSERT INTO tareassuspendidas (numorden,idtarea,suspendida,observacionfini,fini,idempleadofini)
            VALUES (?,?,?,?,?,?);";
      
      $con=conectar();

      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
      mysqli_stmt_bind_param($sentencia,'ssssss',$numorden,$idtarea,$estado,$obs,$fechaaccion,$idempleado);
      $resp=mysqli_stmt_execute($sentencia);

      desconectar($con);
    }
    else
    { //SI EXISTEN TAREA EN ORDEN SUSPENDIDA SE LA REACTIVA
      $sql="UPDATE tareassuspendidas SET suspendida=?,observacionffin=?,ffin=?,idempleadoffin=?
             WHERE idtareasuspendida=?;";

      $con=conectar();

      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
      mysqli_stmt_bind_param($sentencia,'sssss',$estado,$obs,$fechaaccion,$idempleado,$idsuspendida);
      $resp=mysqli_stmt_execute($sentencia);

      desconectar($con);
    }
    
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