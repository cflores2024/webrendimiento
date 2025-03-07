<?php

$server="localhost";
$usu="root";
$pass="123456a$";
$base="dbrendimiento";

function conectar()
    {
        global $server,$usu,$pass,$base,$cnx;

        try 
        {
            //$cnx = mysqli_connect($server, $usu, $pass, $base);
            $cnx = new mysqli($server, $usu, $pass, $base);

            if ($cnx->connect_error) 
            {
                die('Connect Error (' . $cnx->connect_errno . ') ' . $cnx->connect_error);
            }
        }
        catch(Exception $err)
        {
            $cnx=null;
        }

        return $cnx;
    }

    function desconectar($cnx)
    {
        try 
        {
            //$estado=mysqli_close($cnx); 
            $cnx->close();
            $estado=true; 
        }
        catch(Exception $err)
        {
            $estado=false;
        }

        return $estado;
    }
/*
    function ejecutarsqlselect($sql)
    {
        global $cnx;

        $cnx=conectar();

        $result = $cnx->query($sql);

        if (!$result) {
            die('Invalid query: ' . $cnx->error);
        }
        
        return $result;
    }
        */
?>