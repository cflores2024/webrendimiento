<?php

    include "/configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    session_start();
  
    $idprof=$iddisc=$ordendia=$dia=$hini=$hfin="";
  
    if (isset($_SESSION['id']))
    {  
        $id=$_SESSION['id'];
        $accion="...";
        
        //SE RECUPERAN LOS DATOS DE LA NUEVA DISCIPLINA
        if (isset($_GET['idprof']))
        {
            //OBTENIENDO DATOS DEL POST
            $idprof=$_GET["idprof"];
            $iddisc=$_GET["iddisc"];
            $dia=$_GET["dia"];
            $hini=$_GET["hini"];
            $hfin=$_GET["hfin"];
            $accion="N";
            $fechaaccion=date("Y-m-d H:i:s"); 
            
            $dias=array("LU","MA","MI","JU","VI","SA");
            
            $ordendia=array_search($dia,$dias)+1;
         
            //ALTA DE HORARIO DE CLASE
            $sql="INSERT INTO horariosclases (idpersona,iddisciplina,ordendia,dia,horaini,horafin,accion,idempleadoaccion,fechaaccion)
                  VALUES (?,?,?,?,?,?,?,?,?);";

            $con=conectar();
            $sentencia=mysqli_prepare($con,$sql);//preparo consulta
            mysqli_stmt_bind_param($sentencia,'sssssssss',$idprof,$iddisc,$ordendia,$dia,$hini,$hfin,$accion,$id,$fechaaccion);
            $resp=mysqli_stmt_execute($sentencia);
            
            desconectar($con);
            
            if ($resp)  
            {
                echo "Día y horario agendado";
            }
            else
            {
                echo "Error en la acción. No se pudieron guardar los datos!";
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