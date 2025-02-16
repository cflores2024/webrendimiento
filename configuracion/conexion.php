<?php

function conectar()
    {
        $server="localhost";
        $usu="root";
        $pass="123456a$";
        $base="dbrendimiento";

        set_error_handler(function()//Manejador de excepciones
        {
            throw new Exception("Error");
        });

        try {
            $cnx = mysqli_connect($server, $usu, $pass, $base);
        }
        catch(Exception $err)
        {
            $cnx=false;
        }

        return $cnx;
    }

    function desconectar($cnx)
    {
        set_error_handler(function()//Manejador de excepciones
        {
            throw new Exception("Error");
        });

        try {
                $estado=mysqli_close($cnx);  
        }
        catch(Exception $err)
        {
                $estado=false;
        }

        return $estado;
    }


?>