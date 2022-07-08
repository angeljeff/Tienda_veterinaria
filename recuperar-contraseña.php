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

$pin=false;
$mostrar=False;
$click=(isset($_POST['ingreso']))?$_POST['ingreso']:"";
switch($click){
    case "ingresar":
        include("config/bd.php");
        $correo=$_POST['correo']; $contra=$_POST['cedula'];
        $sqly = "SELECT *FROM usuarios where correo=:co and contrasenia=:cec";
        $consultarusuarioc = $conexion->prepare($sqly);
        $consultarusuarioc->bindParam(':co',$correo);
        $consultarusuarioc->bindParam(':cec',$contra);
        $consultarusuarioc->execute();
        $count= $consultarusuarioc->rowCount();
        if($count >0) {
            $usuario=$consultarusuarioc->fetch();
            $pin=True;?>

            

           
     <?php  }else{ 
            
             $mostrar=True;

          }

        break;
    }
        ?>

<?php include("plantillas/cabecera.php"); ?>
<br><br>
<form action="correo.php">
<?php    $hola="angeljeff00@gmail.com"; ?>
<input type="text"   class="form-control" id="direccion" name="cv"  value="<?php  echo  $hola; ?>">

                
</form>
<div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <?php if ($mostrar==False){ ?>

            <div class="col-md-8 border border-secondary">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">Recuperación de contraseña</h3>
                <br>
                <form class="row g-3" action="login.php" method="POST">

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                        <br>
                        <label for="inputState" class="form-label">Correo electrónico:</label>
                        <input type="text"   class="form-control" id="direccion" name="correo"  required>
                        <br>
                        </div>
                        <div class="col-md-6">
                        <br>
                        <label for="inputState" class="form-label">Cédula:</label>
                        <input type="text"   class="form-control" id="direccion" name="cedula"  required>
                        <br>
                        </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-1"></div>
             <?php } else{ ?>
                             <div class="col-md-8 border border-secondary">
                             <br>
                             <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">Recuperación de contraseña</h3>
                             <br>
                             <form class="row g-3" action="login.php" method="POST">
             
                             <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                <br>
                                <label for="inputState" class="form-label">Correo electrónico:</label>
                                <input type="text"   class="form-control" id="direccion" name="correo" value="<?php echo $correo ?>"  required>
                                <br>
                                </div>
                                <div class="col-md-6">
                                <br>
                                <label for="inputState" class="form-label">Cédula:</label>
                                <input type="text"   class="form-control" id="direccion" name="cedula" value="<?php echo $contra ?>" required>
                                 <label for="inputEmail4" class="form-label text-center" style="color:red">Datos no encontrados </label>
                                
                                <br>
                                </div>
                                </div>
                            </div>
                        </div>

                                 <div class="col-md-1"></div>
                <?php    } ?>
                  <div class="col-md-4"></div>
                  <br>
                    <div class="col-md-4 text-center">
                        <br>
                      <button type="submit" class="btn bton" name="ingreso" value="comprobar">Comprobar</button> <br>
                      <?php if ($mostrar==True){ ?>
                      <a href=""> olvidé mi contraseña</a>
                      <?php } ?>
                    </div>
                    
                    <div class="col-md-4"></div>        
                  </form>
                  <br>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <?php include("plantillas/footer.php"); ?>