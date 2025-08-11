<?php
include "configuracion/conexion.php";
date_default_timezone_set("America/Argentina/Tucuman");

if (isset($_GET["ver"]))
{  
    $ver=$_GET["ver"];

    $encabezado="<!-- Table with stripped rows -->
                <table class='table table-borderless datatable'>
                      <thead>
                        <tr>
                          <th scope='col'>Orden</th>
                          <th scope='col'>Titulo Orden</th>
                          <th scope='col' data-type='date' data-format='MM/DD/YYYY'>Fecha inicio</th>
                          <!--th scope='col'>Tiempo</th-->
                          <th scope='col'>Avance %</th>
                          <th scope='col'>Afectados</th>
                          <th scope='col'>Estado</th>
                          <th scope='col'>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>";

   $fila="<tr><td colspan='6' style='text-align: center;'>Sin información a mostrar</td></tr>";

            $pie="</tbody>
                </table>
                <!-- End Table with stripped rows -->";

    switch ($ver)
    {
        case "P":
                    $info="SE MUESTRA LA TABLA DE ORDENES EN PROCESO";
            break;
        case "D":
                    //$info="SE MUESTRA LA TABLA DE ORDENES DISPONIBLES";
                    $info=$encabezado."".$fila."".$pie;
            break;
        case "F":
                    $info="SE MUESTRA LA TABLA DE ORDENES FINALIZADAS";
            break;
    }
}
else
{
    $info="Error. No se recibio correctamente el número de orden!!!";
}

echo $info;
?>