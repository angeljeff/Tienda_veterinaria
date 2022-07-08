
<?php

session_start();
error_reporting(0);
$cedula_sesion= $_SESSION ['usuario'][0];
if($cedula_sesion!= null || $cedula_sesion!=""){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/index.php";
      
    </script>
    <?php
    
    die();
}

$mostrar2=False;
$mostrar=False;
$click=(isset($_POST['ingreso']))?$_POST['ingreso']:"";
switch($click){
    case "ingresar":
        include("config/bd.php");
        $correoo=$_POST['correo']; $contra=$_POST['contrasenia'];
        $sqlz = "SELECT *FROM usuarios where correo=:co";
        $consultarusu = $conexion->prepare($sqlz);
        $consultarusu->bindParam(':co',$correoo);
        $consultarusu->execute();
        $coun= $consultarusu->rowCount();
        if($coun >0) {
            $usua=$consultarusu->fetch();
            $mostrar2=True;
            $sql = "SELECT *FROM usuarios where correo=:co and contrasenia=:contra";
            $consultarusuario = $conexion->prepare($sql);
            $consultarusuario->bindParam(':co',$correoo);
            $consultarusuario->bindParam(':contra',$contra);
            $consultarusuario->execute();
            $count= $consultarusuario->rowCount();
            if($count >0) {
                $usuario=$consultarusuario->fetch();
                session_start();
                $_SESSION['usuario']=array();
                $_SESSION['usuario'][0]= $usuario['cedula'];
                $_SESSION['usuario'][1]= $usuario['nombres'];
                $_SESSION['usuario'][2]= $usuario['tipo_usuario'];
                if($_SESSION['usuario'][2]==2){ ?>
                    <script>
                         window.location.href = "<?php echo $url;?>/TIENDA_VETERINARIA/panelusuario.php";
                    </script>

        <?php   } else{ ?>
                    <script>
                        window.location.href = "<?php echo $url;?>/TIENDA_VETERINARIA/index.php";
                    </script>

    <?php   }
                
               
            }else{ 
                
                 $mostrar=True;
    
              }

           
        }
        else{
            $mostrar=True; 
        }


        break;
    }
        ?>

<?php include("plantillas/encabezado.php"); ?>
<br><br>
<div class="container">
        <div class="row">
            


            <div class="col-md-2"></div>
            <?php if ($mostrar==False){ ?>
            



            <div class="col-md-8 border border-secondary" style="border-radius:0.3em; box-shadow: 0px 2px 5px 6px #D5E1DF ;">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-wight:bold;">INICIO DE SESIÓN</h3>
                <br>
                <form class="row g-4" action="login.php" method="POST">

                    <div class="col-md-6 text-center">
                        <img class="" src="imagenes/tiendapet.jpg" alt="foto tienda" style="max-width: auto; max-height: 14rem; height: 14rem; margin-left: 1rem;margin-top: 0.3rem; "> 

                    </div>
                    
                    <div class="col-md-4">
                        <br>
                      <label for="inputState" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                      <input type="text"   class="form-control" id="direccion" name="correo" required>
                      <br>
                      <label for="inputEmail4" class="form-label" style="font-weight:bold;">Contraseña: </label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.5rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7; margin-bottom:0.2em; "> <img style="width:1rem; heigth:auto; margin-bottom:0.3rem;" src="imagenes/ojito.svg" alt=""></button>   

                        <input type="password" class="form-control" id="password" name="contrasenia" required>

                    </div>
                    <div class="col-md-1"></div>
             <?php } else{ ?>
                             <div class="col-md-8 border border-secondary" style="border-radius:0.4em;">
                             <br>
                             <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-weight:bold;">INICIO DE SESIÓN</h3>
                             <br>
                             <form class="row g-3" action="login.php" method="POST">
             
                                 <div class="col-md-6 text-center">
                                     <img class="" src="imagenes/tiendapet.jpg" alt="foto tienda" style="max-width: auto; max-height: 14rem; height: 14rem; margin-left: 1rem;margin-top: 0.3rem; "> 
             
                                 </div>
                                 
                                 <div class="col-md-4">
                                     <br>
                                   <label for="inputState" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                                   <input type="text"   class="form-control" id="direccion" name="correo" value="<?php echo $correoo ?>" required>
                                   <br>
                                   <label for="inputEmail4" class="form-label" style="font-weight:bold;">Contraseña: </label>
                                    <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.5rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7 "> <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""></button>   
                                     

                                     <input type="password" class="form-control" id="password" name="contrasenia" value="<?php echo $contra ?>" required>
                                     
                                    <label for="inputEmail4" class="form-label text-center" style="color:red">Usuario o contraseña incorrecto </label>

                                 </div>

                                 <div class="col-md-1"></div>
                <?php    } ?>
                  <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                      <button type="submit" class="btn bton" name="ingreso" value="ingresar">Ingresar</button> <br>
                      <a  href="recuperar_contrasenia.php" class="envioo" style="text-decoration:none"> olvidé mi contraseña</a>
                      <br><br>
                      <div class="form-group tex-center col-lg-12 centrar">
                                No tienes cuenta <a href="registro.php" class="text-center" style="text-decoration-line: underline; color:blue;">REGÍSTRATE</a>
                            </div>
<!--                       
                    <?php if ($mostrar2==True){ ?>
                        <a  href="correo.php?id=<?php echo $usua['cedula']?>" class="envio" style="text-decoration:none"> olvidé mi contraseña</a>
                      <?php } ?> -->
                    </div>
                    
                    <div class="col-md-4"></div>        
                  </form>
                  <br>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
<br><br><br><br>

    <script>
    $('.envio').on('click', function(e) {
        e.preventDefault();
        const href= $(this).attr('href')
        Swal.fire({
            title: 'se enviará la nueva contraseña a su correo',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ok'
        }).then((result) => {
            if (result.value ) {
                document.location.href= href;

                    
            }else{
                
            }
        })
    })
    
</script>

<script>
  function mostrarContrasena(){
      var tipo = document.getElementById("password");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }
  }
</script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <?php include("plantillas/footer.php"); ?>