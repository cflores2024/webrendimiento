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

        //SE RECUPERAN LOS DATOS DEL PROFESOR Y DISCIPLINAS QUE DICTA
        $encabezado="";
        $pie="";
        $dias=array(
                        "LU"=>"<tr><td>LU</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>",
                        "MA"=>"<tr><td>MA</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>",
                        "MI"=>"<tr><td>MI</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>",
                        "JU"=>"<tr><td>JU</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>",
                        "VI"=>"<tr><td>VI</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>",
                        "SA"=>"<tr><td>SA</td>
                        <td><input type='time' class='form-control' id='txtluini' name='txtluini'></td>
                        <td><input type='time' class='form-control' id='txtlufin' name='txtlufin'></td>
                        <td>&nbsp;</td></tr>"
                    );

        $sql = "SELECT a.`idhorarios`,a.`dia`,a.`horaini`,a.`horafin`,b.`color`
                FROM horariosclases a INNER JOIN disciplinas b ON (a.`iddisciplina`=b.`iddisciplina` AND b.`accion`!='B')
                WHERE a.`idpersona`=". $idprof ." AND a.`iddisciplina`=". $iddisc ." AND a.`accion`!='B' 
                ORDER BY a.`ordendia`,a.`horaini` ASC;";     
                        
        $con=conectar();

        $result = mysqli_query($con,$sql);
        
        $lu=$ma=$mi=$ju=$vi=$sa=0;

        while($row = mysqli_fetch_array($result))
        {
            if (strlen($encabezado)<=0)
            {
                $encabezado="<div class='row mb-3'>
                                <label for='inputText' class='col-sm-2 col-form-label'>Color Disciplina</label>
                                <div class='col-sm-10'>
                                    <input type='color' class='form-control form-control-color' value='". $row["color"] ."' disabled='disabled'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <!-- Table with hoverable rows -->
                                <table class='table table-hover'>
                                    <thead>
                                    <tr>
                                        <th scope='col'>DIA</th>
                                        <th scope='col'>HORA INICIO</th>
                                        <th scope='col'>HORA FIN</th>
                                        <th scope='col'>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                
                $pie="</tbody>
                        </table>
                        <!-- End Table with hoverable rows -->
                        </div>";
            }

            switch($row["dia"])
            {   
                case "LU":
                            if ($lu<=0)
                            {
                                $dias["LU"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtluini' name='txtluini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtlufin' name='txtlufin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                                $lu=1;
                            }
                            else
                            {
                                $dias["LU"]=$dias["LU"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtluini' name='txtluini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtlufin' name='txtlufin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }
                break;
                case "MA":
                            if ($ma<=0)
                            {
                                $dias["MA"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtmaini' name='txtmaini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtmafin' name='txtmafin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                                $ma=1;
                            }
                            else
                            {
                                $dias["MA"]=$dias["MA"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtmaini' name='txtmaini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtmafin' name='txtmafin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }
                break;
                case "MI":
                            if ($mi<=0)
                            {
                                $dias["MI"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtmiini' name='txtmiini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtmifin' name='txtmifin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                                $mi=1;
                            }
                            else
                            {
                                $dias["MI"]=$dias["MI"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtmiini' name='txtmiini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtmifin' name='txtmifin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }
                break;
                case "JU":
                            if ($ju<=0)
                            {
                                $dias["JU"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtjuini' name='txtjuini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtjufin' name='txtjufin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                                $ju=1;
                            }
                            else
                            {
                                $dias["JU"]=$dias["JU"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtjuini' name='txtjuini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtjufin' name='txtjufin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }
                break;
                case "VI":
                            if ($vi<=0)
                            {
                                $dias["VI"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtviini' name='txtviini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtvifin' name='txtvifin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                                $vi=1;
                            }
                            else
                            {
                                $dias["VI"]=$dias["VI"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtviini' name='txtviini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtvifin' name='txtvifin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }
                break;
                case "SA":
                            if ($sa<=0)
                            {
                                $dias["SA"]="<tr>   
                                                <td>". $row["dia"] ."</td>
                                                <td><input type='time' class='form-control' id='txtsaini' name='txtsaini' value='". $row["horaini"] ."'></td>
                                                <td><input type='time' class='form-control' id='txtsafin' name='txtsafin' value='". $row["horafin"] ."'></td>
                                                <td>
                                                    <a href='#'>
                                                        <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                    </a>
                                                </td>
                                            </tr>";
                            }
                            else
                            {
                                $dias["SA"]=$dias["SA"] ."<tr>   
                                                            <td>". $row["dia"] ."</td>
                                                            <td><input type='time' class='form-control' id='txtsaini' name='txtsaini' value='". $row["horaini"] ."'></td>
                                                            <td><input type='time' class='form-control' id='txtsafin' name='txtsafin' value='". $row["horafin"] ."'></td>
                                                            <td>
                                                                <a href='#'>
                                                                    <img src='./assets/img/eliminar.png' alt='Eliminar registro' srcset='' onclick='eliminarhorario(".$row['idhorarios'].");'>
                                                                </a>
                                                            </td>
                                                        </tr>";
                            }

                            $sa=$sa+1;
                break;
            }
        }                 
         
        desconectar($con);   
        
        //ARMO CONTENDIO DE LA TABLA
        $fila="";

        foreach ($dias as $d => $value)
        {
            $fila=$fila ."". $value;
        }

        echo $encabezado ."". $fila ."". $pie;
        
    }
    else
    {
        echo "<h2>ERROR EN EL INICIO DE SECCIÓN</h2>";
    }
  
?>