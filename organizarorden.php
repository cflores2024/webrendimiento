<!--// CHEQUEO DATOS LOGIN -->
<?php
  include "configuracion/conexion.php";
  date_default_timezone_set("America/Argentina/Tucuman");

  session_start();
  
  if (isset($_SESSION['id']))
  {  
    $id=$_SESSION['id'];
    $accion="...";
    $numorden=$_GET['orden'];
    $estado=$_GET['estado'];
    $titulo=$_GET['titulo'];
    $msn="";

    if ($numorden>0)
    {//SE CAMBIA DE ESTADO DE LA ORDEN SELECCIONADA A DISPONIBLE PARA QUE ALGUN MECANICO TRATE ALGUNA 
     //DE SUS TAREAS
  
      $accion="M";
      $fechaaccion=date("Y-m-d H:i:s"); 
      //BORRAR HORARIO DE CLASE
      $sql="UPDATE numeroorden SET tituloorden=?,estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
            WHERE numorden=?;";

      $con=conectar();
      $sentencia=mysqli_prepare($con,$sql);//preparo consulta
      mysqli_stmt_bind_param($sentencia,'ssssss',$titulo,$estado,$accion,$id,$fechaaccion,$numorden);
      $resp2=mysqli_stmt_execute($sentencia);
      
      desconectar($con);
        
      if ($resp2)  
      {
        $sql="UPDATE detalleorden SET estado=?,accion=?,idempleadoaccion=?,fechaaccion=?
              WHERE numeroorden=?;";

        $con=conectar();
        $sentencia=mysqli_prepare($con,$sql);//preparo consulta
        mysqli_stmt_bind_param($sentencia,'sssss',$estado,$accion,$id,$fechaaccion,$numorden);
        $resp=mysqli_stmt_execute($sentencia);
        
        desconectar($con);

        if ($resp)  
        {
          $accion="B";
          $sql="UPDATE autorizaraccorden SET accion=?,idempleadoaccion=?,fechaaccion=?
                WHERE numorden=?;";

          $con=conectar();
          $sentencia=mysqli_prepare($con,$sql);//preparo consulta
          mysqli_stmt_bind_param($sentencia,'ssss',$accion,$id,$fechaaccion,$numorden);
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
        else
        {
          $msn="Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.";
        } 
      }
      else
      {
        $msn="Error!!!. La accion de actualizar la orden a disponible dio error. Intente de nuevo.";
      } 
    }
    else
    {
      $msn="Error!!!. La orden no pudo ser cambiada de estado a DISPONIBLE. Intente de nuevo.";
    } 
  
    //SE TRATAN TODAS LAS ORDENES A VER COMO NO DISPONIBLES
    $sql = "SELECT b.`iddetalleorden`,a.`patente`,b.`numeroorden`,a.`estado`,a.`historial`,c.`idtarea`,c.`descripciontarea`
            FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                               INNER JOIN tareas c ON (c.`idtarea`=b.`idtarea` AND c.`accion`!='B')
            WHERE a.`estado`='S'
            ORDER BY A.`fechaaccion`;";

    $con=conectar();

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
            $matricula=$row['patente'];
            $encabezado="<div class='accordion-item'>
                          <h2 class='accordion-header' id='flush-heading".$numorden."'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse".$numorden."' aria-expanded='false' aria-controls='flush-collapse".$numorden."'>
                              Orden de trabajo #".$numorden."&nbsp;&nbsp;&nbsp;&nbsp;";
            
            if ($row['historial']=="S") 
            {//LA ORDEN PRESENTA UN HISTORIAL
            /* $encabezado=$encabezado."<a href='#' onclick='historial(\"$matricula\")'>
                                        <img src='assets/img/tarea_historia.png' alt='La orden ya presenta un historial'>
                                      </a>";
                                      */
            }

                  
            
            $poup="
                    <div class='modal fade' id='".$numorden."' tabindex='-1'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Titulo Descripción</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                          </div>
                          <div class='modal-body'>
                                <form>
                                  <div class='row mb-3'>
                                    <label for='txttitulo' class='col-md-4 col-lg-3 col-form-label'>Titulo orden:</label>
                                    <div class='col-md-8 col-lg-9'>
                                      <input name='txttitulo' type='text' class='form-control' id='txttitulo".$numorden."' placeholder='Ingrese un titulo para esta orden' value=''>
                                    </div>
                                  </div>
                                </form>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='disponible(".$numorden.")'>Aceptar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  ";
                  
            $encabezado=$encabezado."<a href='#' data-bs-toggle='modal' data-bs-target='#".$numorden."'>
                                    <!--a href='#' onclick='disponible(".$numorden.",'')'-->
                                      <img src='assets/img/tarea_cambio_der.png' alt='Cambiar estado tarea'>
                                    </a>
                                  </button>

                                </h2>
                              ". $poup;

            $info="<div id='flush-collapse".$numorden."' class='accordion-collapse collapse' aria-labelledby='flush-heading".$numorden."' data-bs-parent='#accordionFlush".$numorden."'>
                    <div class='accordion-body'>
                    <p>#".$item."&nbsp;".$row['descripciontarea']."</p>";
          }

          $item=$item+1;
      }

      $lsdatosnodisp=$lsdatos."".$encabezado."".$info."</div></div></div>";
    }

    desconectar($con);

    //SE BUSCAN Y TRATAN TODAS LAS ORDENES A VER COMO DISPONIBLES
    $sql = "SELECT b.`iddetalleorden`,a.`patente`,b.`numeroorden`,a.`estado`,a.`historial`,c.`idtarea`,c.`descripciontarea`
            FROM numeroorden a INNER JOIN detalleorden b ON (a.`numorden`=b.`numeroorden` AND b.`accion`!='B')
                                INNER JOIN tareas c ON (c.`idtarea`=b.`idtarea` AND c.`accion`!='B')
            WHERE a.`estado`='D'
            ORDER BY A.`fechaaccion`;";

    $con=conectar();

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
      $encabezado="";
      $info="";
      $lsdatos="";
      $numorden="";
      $item=1;
      $matricula="";
      $poup="";
    
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
            $matricula=$row['patente'];
            $encabezado="<div class='accordion-item'>
                          <h2 class='accordion-header' id='flush-heading".$numorden."'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse".$numorden."' aria-expanded='false' aria-controls='flush-collapse".$numorden."'>
                              Orden de trabajo #".$numorden."&nbsp;&nbsp;&nbsp;&nbsp;";
            
            if ($row['historial']=="S") 
            {//LA ORDEN PRESENTA UN HISTORIAL
              /*
              $encabezado=$encabezado."<a href='#' onclick='historial(\"$matricula\")'>
                                        <img src='assets/img/tarea_historia.png' alt='La orden ya presenta un historial'>
                                      </a>";
                                      */
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
    }    
    
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
            </div>". $poup ."</section>";
}
else
{
    header('Location: index.php');
    exit;
}   
?>