<?php include("plantillas/encabezado.php"); ?>
<?php
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
        $correoo=$_POST['correo'];
        $sqlz = "SELECT *FROM usuarios where correo=:co";
        $consultarusu = $conexion->prepare($sqlz);
        $consultarusu->bindParam(':co',$correoo);
        $consultarusu->execute();
        $coun= $consultarusu->rowCount();
        if($coun >0) {
            $usua=$consultarusu->fetch();
            ?>
              <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'La nueva contraseña se ha enviado a su correo electrónico',
                showConfirmButton: false,
                timer: 2000
                })
                window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/correo.php?id=<?php echo $usua['cedula']?>";
              </script>          
       <?php
             }
        else{
            $mostrar=True; 
        }


        break;
    }

        ?>


<br><br><br><br><br>
<div class="container">
        <div class="row">
            


            <div class="col-md-2"></div>
            <?php if ($mostrar==False){ ?>
            
            <div class="col-md-8 border border-secondary" style="border-radius:0.3em; box-shadow: 0px 2px 5px 6px #D5E1DF ;">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-wight:bold;">RECUPERACIÓN DE CONTRASEÑA</h3>
                <br>
                <form class="row g-4" action="recuperar_contrasenia.php" method="POST">
                    <div class="col-md-6 text-center">
                        <img class="" src="imagenes/tiendapet.jpg" alt="foto tienda" style="max-width: auto; max-height: 14rem; height: 14rem; margin-left: 1rem;margin-top: 0.3rem; "> 
                    </div>
                    <div class="col-md-4">
                        <br>
                      <label for="inputState" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                      <input type="text"   class="form-control" id="direccion" name="correo" required>
                      <br><br>
                      <!-- <label for="inputEmail4" class="form-label" style="font-weight:bold;">Contraseña: </label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.5rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7; margin-bottom:0.2em; "> <img style="width:1rem; heigth:auto; margin-bottom:0.3rem;" src="imagenes/ojito.svg" alt=""></button>   

                        <input type="password" class="form-control" id="password" name="contrasenia" required> -->
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                        <button  style="width:9rem, max-heigth:auto; font-size:1.4rem;" type="submit" class="btn bton" name="ingreso" value="ingresar">Recuperar</button> <br>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    
                    </div>

                    <div class="col-md-1"></div>
             <?php } else{ ?>
                            
            <div class="col-md-8 border border-secondary" style="border-radius:0.3em; box-shadow: 0px 2px 5px 6px #D5E1DF ;">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-wight:bold;">RECUPERACIÓN DE CONTRASEÑA</h3>
                <br>
                <form class="row g-4" action="recuperar_contrasenia.php" method="POST">
                    <div class="col-md-6 text-center">
                        <img class="" src="imagenes/tiendapet.jpg" alt="foto tienda" style="max-width: auto; max-height: 14rem; height: 14rem; margin-left: 1rem;margin-top: 0.3rem; "> 
                    </div>
                    <div class="col-md-4">
                        <br>
                      <label for="inputState" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                      <input type="text"  class="form-control" id="direccion" name="correo" required>
                      <label for="inputEmail4" class="form-label text-center" style="color:red">El correo electrónico ingresado no se encuentra registrado</label>
                      
                      <br><br>
                      <!-- <label for="inputEmail4" class="form-label" style="font-weight:bold;">Contraseña: </label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.5rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7; margin-bottom:0.2em; "> <img style="width:1rem; heigth:auto; margin-bottom:0.3rem;" src="imagenes/ojito.svg" alt=""></button>   

                        <input type="password" class="form-control" id="password" name="contrasenia" required> -->
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                        <button  style="width:9rem, max-heigth:auto; font-size:1.4rem;" type="submit" class="btn bton" name="ingreso" value="ingresar">Recuperar</button> <br>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    
                    </div>

                    <div class="col-md-1"></div>

                <?php    } ?>

            <div class="col-md-2"></div>
        </div>
    </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>




    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <?php include("plantillas/footer.php"); ?>