<?php include("plantillas/encabezado.php"); 
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;

if($tipo_sesion== null || $tipo_sesion==""){?>
  <script>
    window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
    
  </script>
  <?php
    
    die();
}
?>

<?php  $_actualiza= False ?>

<?php $accion=(isset($_POST['editar']))?$_POST['editar']:""; ?>
<?php if($accion=="actualizar"){
    $_actualiza= True;
    

} ?>
<?php include("config/bd.php");
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actualiza_usu']))
 {   
      include("config/bd.php");
      if(isset($_GET['actualiza_usu']));
      $_nombre= $_POST['nombres']; $_apellidos= $_POST['apellidos']; $_direccion= $_POST['direccion']; $_correo= $_POST['correo']; $_contrasenia= $_POST['contrasenia'];
      $actualizar= $conexion->prepare("UPDATE usuarios SET nombres=:nombre,  apellidos=:apellido, direccion=:direccion, correo = :correo, contrasenia=:contrasenia WHERE cedula=:cedula");
      $actualizar->bindParam(':cedula',$cedula_sesion);
      $actualizar->bindParam(':nombre',$_nombre);
      $actualizar->bindParam(':apellido',$_apellidos);
      $actualizar->bindParam(':direccion',$_direccion);
      $actualizar->bindParam(':correo',$_correo);
      $actualizar->bindParam(':contrasenia',$_contrasenia);
      $actualizar->execute();
    
 }

      if(isset($_GET['actualiza_usu'])) ;
          $consultar= $conexion->prepare("SELECT *FROM usuarios WHERE cedula = :cedula ");
           
            $consultar->bindParam(':cedula', $cedula_sesion);
            $consultar->execute();
            $_count = $consultar->rowCount();
            if($_count > 0 ){
                $_datusuario= $consultar->fetch();
                  
              }else{
              } ?>



<?php function presentar_mensaje() {  ?>
            <div class="alert alert-success alert-dismissible">
            <strong>Success!</strong> Indicates a successful or positive action.
            <button href="#"  class="close" data-dismiss="alert" aria-label="close" style="margin-left: 22rem; background: #ABEBC6;">X 
            </button>
            </div>
            <br>
            <?php   }?>

<br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 border border-secondary" style="border-radius:0.3em; box-shadow: 0px 4px 3px 7px #D5E1DF ;">
            

            <?php if($_actualiza== False){ ?>
                <br>
                <h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;font-weight:bold">Mi Información Personal</h3>
                
                <?php }else {?>
                    <br>
                    <h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">Actualiza tus Datos </h3>
                    <?php }?>
                <br>
                <form class="row g-3" method="POST">
                
                

                    <div class="col-12 labels">
                      <label for="inputAddress" class="form-label" style="font-weight:bold">Nombres</label>
                      <?php if($_actualiza== False){ ?>
                        <input type="text" class="form-control " id="nombres" name="nombres" value="<?=$_datusuario['nombres'] ?>" placeholder="Ingrese sus nombres completos" required disabled>
                      <?php }else {?>
                      <input type="text" minlength="5"  class="form-control" id="apellidos" name="nombres" value="<?=$_datusuario['nombres'] ?>" placeholder="Ingrese sus apellidos" required>
                    <?php }?>
                    </div>
                    <div class="col-12 labels">
                      <label for="inputAddress2" class="form-label" style="font-weight:bold">Apellidos</label>
                      <?php if($_actualiza== False){ ?>
                      <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?=$_datusuario['apellidos'] ?>" placeholder="Ingrese sus apellidos" required disabled>
                      <?php }else {?>
                      <input type="text" minlength="5" class="form-control" id="apellidos" name="apellidos" value="<?=$_datusuario['apellidos'] ?>"  placeholder="Ingrese sus apellidos" required>
                    <?php }?>
                    </div>
                    <div class="col-md-6">
                      <label for="inputCity" class="form-label" style="font-weight:bold">Número de cédula</label>
                      <?php if($_actualiza== False){ ?>
                        <input type="text" class="form-control" id="cedula" name="cedula" value="<?=$_datusuario['cedula'] ?>" required disabled>
                      <?php }else {?>
                        <input type="text" class="form-control" id="cedula" name="cedula" value="<?=$_datusuario['cedula'] ?>" required disabled>
                    <?php }?>
                    </div>
                    <div class="col-md-6">
                      <label for="inputState" class="form-label" style="font-weight:bold">Dirección</label>
                      <?php if($_actualiza== False){ ?>
                      <input type="text" class="form-control" id="direccion" name="direccion" value="<?=$_datusuario['direccion'] ?>" required disabled>
                      <?php }else {?>
                      <input type="text" minlength="8" class="form-control" id="direccion" name="direccion" value="<?=$_datusuario['direccion'] ?>" required>
                        
                    <?php }?>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label" style="font-weight:bold">Correo Electrónico</label>
                        <?php if($_actualiza== False){ ?>
                          <input type="email" minlength="5" class="form-control" id="correo" name="correo" value="<?=$_datusuario['correo'] ?>" required disabled>
                      <?php }else {?>
                        <input type="email" minlength="5" class="form-control" id="correo" name="correo" value="<?=$_datusuario['correo'] ?>" required>
                    <?php }?>
                      </div>
                      <div class="col-md-6">
                        <label for="inputPassword4" class="form-label" style="font-weight:bold">Contraseña</label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.5rem; margin-bottom: 0.3rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7 "> <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""></button>   

                        <?php if($_actualiza== False){ ?>
                        <input type="password" class="form-control" id="password" name="contrasenia" value="<?=$_datusuario['contrasenia'] ?>" required disabled>
                          
                        <?php }else {?>
                        <input type="password" minlength="8" class="form-control" id="password" name="contrasenia" value="<?=$_datusuario['contrasenia'] ?>" required>
                    <?php }?>
                      </div>
                      <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                    <?php if($_actualiza== False){ ?>
                        <br>
                      <?php }else {?>

                      <button type="submit" class="btn bton" name="actualiza_usu">Actualizar</button> 
                    <?php }?> 
                    </div>
                    <div class="col-md-4"></div>        
                  </form>

            </div>
            <div class="col-md-2">
            <?php if($_actualiza== False){ ?>
                <form method="POST">
                <button type="submit" class="btn  border border-secundary edutar" name="editar" value="actualizar" style="width:14rem; font-size: 1.2rem; font-family: Homer Simpson UI; background:#4DA6DD ; "> <img style="width:2rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">Editar información</button>   
                </form>
                <?php }else {?>
                   <br>
                    <?php }?>
            
        </div>
        </div>
    </div>
    <div class="col-md-12">
                  <br><br><br><br><br><br><br><br><br>
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
    <?php include("plantillas/footer.php"); ?>
    </div>

   