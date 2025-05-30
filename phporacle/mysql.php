<?php

    include "configuracion/conexion.php";

    try 
    {
        $cnx=conectar();
       
        $sql = "SELECT CONCAT(a.`apellido`,', ',a.`nombre`) AS usuario,b.`tipopersona`
                FROM personas a INNER JOIN tipopersona b ON (a.`idtipopersona`=b.`idtipopersona`)
                WHERE a.`accion`!='B';";

        $result = $cnx->query($sql);

        if (!$result) 
        {
          die('Invalid query: ' . $cnx->error);
        }

        if (!$result) 
        {
          die('Invalid query: ' . $mysqli->error);
        }
        else
        {
            while($row = $result->fetch_assoc())
            {
              $id=$row['idpersona'];
              $apenomb=$row['usuario'];
              $tipousu=$row['tipopersona'];

              echo "<p>id=".$id."-apenomb=".$apenomb."-tipo=".$tipousu."</p>";
            }
        }
       
        desconectar($cnx);
    }
    catch(Exception $err)
    {
        $cnx=false;
    }
?>