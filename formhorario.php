<?php
    include "/configuracion/conexion.php";
    date_default_timezone_set("America/Argentina/Tucuman");

    session_start();
    //RECUPERO DATOS SESSION
    if (isset($_SESSION['id']))
    {  
        $idusulog=$_SESSION['id'];
        $fechaaccion=date("Y-m-d H:i:s"); 

        $idprof=$_GET["idprof"];
        $iddisc=$_GET["iddisc"];
        
        $dias=array("LU","MA","MI","JU","VI","SA");
       
        //ARMO CONTENDIO DEL FORMULARIO
        $listaopciones="";

        foreach ($dias as $valor) 
        {
            $listaopciones=$listaopciones ."<option value='". $valor ."'>". $valor ."</option>";
        }

        echo "  <form action=''>
                    <div class='row mb-3'>
                        <label for='cbdisciplina' class='col-sm-2 col-form-label'>Elija Día de Clase</label>
                        <div class='col-sm-10'>
                            <select id='txtdia' name='txtdia' class='form-select'>
                                ". $listaopciones ."
                            </select>
                        </div>
                    </div>
        
                    <div class='row mb-3'>
                        <label for='txthini' class='col-sm-2 col-form-label'>Hora Fin</label>
                        <div class='col-sm-10'>
                            <input name='txthini' type='time' class='form-control' id='txthini'>
                        </div>
                    </div>
                    
                    <div class='row mb-3'>
                    <label for='txthfin' class='col-sm-2 col-form-label'>Hora Inicio</label>
                        <div class='col-sm-10'>
                            <input name='txthfin' type='time' class='form-control' id='txthfin'>
                        </div>
                    </div>
                                            
                    <div class='row mb-3'>
                        <div class='col-sm-10'>
                            <span id='resp'>
                                <button type='button' class='btn btn-primary' onclick='guardarhorario()'>Guardar Horario</button>
                            </span>
                            <input type='hidden' id='txtidprof' name='txtidprof' value='". $idprof ."'>
                            <input type='hidden' id='txtiddisc' name='txtiddisc' value='". $iddisc ."'>
                        </div>
                    </div>
                </form>";
    }
    else
    {
        echo "<h2>ERROR EN EL INICIO DE SECCIÓN</h2>";
    }
?>