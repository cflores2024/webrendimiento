<?php
  session_start();

  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");
  
  if (isset($_SESSION['id']))
  {  
    $idusuario=$_SESSION['id'];
    $lsdatos=$_GET['lsdatos'];
    $accion="B";
    $fechaaccion=date("Y-m-d H:i:s");
    $bandera=true;

    //SEPARO ORDENES DE TRABAJOS
    $lsordenes=explode(";",$lsdatos);
    
    //echo "PHP recibe". $lsdatos;
    
    for ($i=0;$i<count($lsordenes);$i++)
    {
        $numorden=$lsordenes[$i];
        
        //ELIMINAR DETALLES DE LA ORDEN
        $sql="UPDATE detalleorden SET accion=?,idempleadoaccion=?,fechaaccion=?
              WHERE numeroorden=?;";
        
        $con=conectar();

        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'ssss',$accion,$idusuario,$fechaaccion,$numorden);
        $resp=mysqli_stmt_execute($sentencia);

        desconectar($con);

        if ($resp)  
        {
            //ELIMINAR ORDEN
            $sql="UPDATE numeroorden SET accion=?,idempleadoaccion=?,fechaaccion=?
                  WHERE numorden=?;";
            
            $con=conectar();

            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
            mysqli_stmt_bind_param($sentencia,'ssss',$accion,$idusuario,$fechaaccion,$numorden);
            $resporden=mysqli_stmt_execute($sentencia);

            desconectar($con);

            if (($resporden)&&($bandera))
            {
                //echo "Eliminado=>". $numorden;
                $bandera=true; //La accion dio ok
            }
            else
            {
                $bandera=false; //La acción dio error
            }
        }
        else
        {
            $bandera=false; //La acción dio error
        }
    }

    if ($bandera) echo "0";
    else echo "1";
  }
  else
  {
    echo "<script> window.location.href='index.html'</script>";
  }   
?>