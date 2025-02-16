<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "/configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $accion="...";
    $numorden=$_GET['orden'];
    $estado=$_GET['estado'];
    $msn="";

    if ($numorden>0)
    {//SE CAMBIA DE ESTADO DE LA ORDEN SELECCIONADA A DISPONIBLE PARA QUE ALGUN MECANICO TRATE ALGUNA DE SUS TAREAS
  
      $accion="M";
      $fechaaccion=date("Y-m-d H:i:s"); 
     //BORRAR HORARIO DE CLASE
      $sql="UPDATE numeroorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
            WHERE numorden=?;";

      $con=conectar();
      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
      mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$id,$fechaaccion,$numorden);
      $resp=mysqli_stmt_execute($sentencia);
      
      desconectar($con);
        
      if ($resp)  
      {
        $msn="";
      }
      else
      {
        $msn="Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.";
      } 
    }

    //SE TRATAN TODAS LAS ORDENES A VER COMO NO DISPONIBLES
    $sql = "SELECT b.`iddetalleorden`,a.`matricula`,b.`numeroorden`,a.`estado`,a.`historial`,c.`idtarea`,c.`descripciontarea`
            FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                               INNER JOIN tareas c ON (c.`idtarea`=b.`idtarea` AND c.`accion`!='B')
            WHERE a.`estado`='S'
            ORDER BY A.`fechaaccion`;";

    $con=conectar();

    $result = mysqli_query($con,$sql);

    $encabezado="";
    $info="";
    $lsdatos="";
    $numorden="";
    $item=1;
    $matricula="";
    $lsdatosnodisp="";
    $lsdatosdisp="";
  
    while($row = mysqli_fetch_array($result))
    {
        if ($numorden==$row['numeroorden'])
        {
          $info=$info."<p>#".$item."&nbsp;".$row['descripciontarea']."</p>";
        }
        else
        {
          if (strlen($info)>0)
          {//VIENE CON DATOS DE QUE CORRESPONDEN A TODOS LOS ELEMENTOS DE UN ACORDEON
            $lsdatos=$lsdatos."".$encabezado."".$info."</div></div></div>";
            $item=1;
            $encabezado="";
            $info="";
          }

          $numorden=$row['numeroorden'];
          $matricula=$row['matricula'];
          $encabezado="<div class='accordion-item'>
                        <h2 class='accordion-header' id='flush-heading".$numorden."'>
                          <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse".$numorden."' aria-expanded='false' aria-controls='flush-collapse".$numorden."'>
                            Orden de trabajo #".$numorden."&nbsp;&nbsp;&nbsp;&nbsp;";
          
          if ($row['historial']=="S") 
          {//LA ORDEN PRESENTA UN HISTORIAL
            $encabezado=$encabezado."<a href='#' onclick='historial(\"$matricula\")'>
                                      <img src='assets/img/tarea_historia.png' alt='La orden ya presenta un historial'>
                                    </a>";
          }

          $encabezado=$encabezado."<a href='#' onclick='disponible(".$numorden.")'>
                                    <img src='assets/img/tarea_cambio_der.png' alt='Cambiar estado tarea'>
                                  </a>
                                </button>
                              </h2>
                            ";
          $info="<div id='flush-collapse".$numorden."' class='accordion-collapse collapse' aria-labelledby='flush-heading".$numorden."' data-bs-parent='#accordionFlush".$numorden."'>
                  <div class='accordion-body'>
                  <p>#".$item."&nbsp;".$row['descripciontarea']."</p>";
        }

        $item=$item+1;
    }

    $lsdatosnodisp=$lsdatos."".$encabezado."".$info."</div></div></div>";
                
    desconectar($con);

    //SE BUSCAN Y TRATAN TODAS LAS ORDENES A VER COMO DISPONIBLES
    $sql = "SELECT b.`iddetalleorden`,a.`matricula`,b.`numeroorden`,a.`estado`,a.`historial`,c.`idtarea`,c.`descripciontarea`
            FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                                INNER JOIN tareas c ON (c.`idtarea`=b.`idtarea` AND c.`accion`!='B')
            WHERE a.`estado`='D'
            ORDER BY A.`fechaaccion`;";

    $con=conectar();

    $result = mysqli_query($con,$sql);

    $encabezado="";
    $info="";
    $lsdatos="";
    $numorden="";
    $item=1;
    $matricula="";
  
    while($row = mysqli_fetch_array($result))
    {
        if ($numorden==$row['numeroorden'])
        {
          $info=$info."<p>#".$item."&nbsp;".$row['descripciontarea']."</p>";
        }
        else
        {
          if (strlen($info)>0)
          {//VIENE CON DATOS DE QUE CORRESPONDEN A TODOS LOS ELEMENTOS DE UN ACORDEON
            $lsdatos=$lsdatos."".$encabezado."".$info."</div></div></div>";
            //$i=$i+1;
            $item=1;
            $encabezado="";
            $info="";
          }

          $numorden=$row['numeroorden'];
          $matricula=$row['matricula'];
          $encabezado="<div class='accordion-item'>
                        <h2 class='accordion-header' id='flush-heading".$numorden."'>
                          <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse".$numorden."' aria-expanded='false' aria-controls='flush-collapse".$numorden."'>
                            Orden de trabajo #".$numorden."&nbsp;&nbsp;&nbsp;&nbsp;";
          
          if ($row['historial']=="S") 
          {//LA ORDEN PRESENTA UN HISTORIAL
            $encabezado=$encabezado."<a href='#' onclick='historial(\"$matricula\")'>
                                      <img src='assets/img/tarea_historia.png' alt='La orden ya presenta un historial'>
                                    </a>";
          }

          $encabezado=$encabezado."<a href='#' onclick='nodisponible(".$numorden.")'>
                                    <img src='assets/img/tarea_cambio_izq.png' alt='Cambiar estado tarea'>
                                  </a>
                                </button>
                              </h2>
                            ";

          $info="<div id='flush-collapse".$numorden."' class='accordion-collapse collapse' aria-labelledby='flush-heading".$numorden."' data-bs-parent='#accordionFlush".$numorden."'>
                  <div class='accordion-body'>
                  <p>#".$item."&nbsp;".$row['descripciontarea']."</p>";
        }

        $item=$item+1;
    }

    $lsdatosdisp=$lsdatos."".$encabezado."".$info."</div></div></div>";
                
    desconectar($con);

    echo "
          <section class='section'>
            <div class='row'>
              <div class='col-lg-6'>

                <div class='card'>
                  <div class='card-body'>
                    <h5 class='card-title'>Ordenes de trabajo sin tratar</h5>

                    <!-- Default Accordion -->
                    <div class='accordion' id='accordionExample'>
                      ". $lsdatosnodisp ."
                    </div><!-- End Default Accordion Example -->

                  </div>
                </div>
              </div>

              <div class='col-lg-6'>

                <div class='card'>
                  <div class='card-body'>
                    <h5 class='card-title'>Ordenes de trabajo disponibles a tratar</h5>

                    <!-- Default Accordion -->
                    <div class='accordion' id='accordionExample'>
                      ". $lsdatosdisp ."
                    </div><!-- End Default Accordion Example -->

                  </div>
                </div>

              </div>
            </div>
          </section>
    ";
}
else
{
  //  header('Location: index.php');
  //  exit;
}   
?>