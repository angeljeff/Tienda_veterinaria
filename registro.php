<?php include("plantillas/encabezado.php"); 
$cedula_sesion= $_SESSION ['usuario'][0];
if($cedula_sesion!= null || $cedula_sesion!=""){?>
  <script>
    window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/index.php";
    
  </script>
  <?php
    
    die();
}
?>
<br>


<?php 
$mostrartodo=false;
$clicke=(isset($_POST['registro_usuario']))?$_POST['registro_usuario']:"";
switch($clicke){
  case "registr":
    $_nombre= $_POST['nombres']; $_apellidos= $_POST['apellidos'];$_cedula= $_POST['cedulausuario']; $_direccion= $_POST['direccion']; $_correo= $_POST['correo']; $_contrasenia= $_POST['contrasenia'];$_tipo= 1;


    function validarCI($strCedula)
{
//aqui explico la logica de la validacion de una cedula de ecuador
//El decimo Digito es un resultante de un calculo
//Se trabaja con los 9 digitos de la cedula
//Cada digito de posicion impar se lo duplica, si este es mayor que 9 se resta 9
//Se suman todos los resultados de posicion impar
//Ahora se suman todos los digitos de posicion par
//se suman los dos resultados
//se resta de la decena inmediata superior
//este es el decimo digito
//si la suma nos resulta 10, el decimo digito es cero

if(is_null($strCedula) || empty($strCedula)){//compruebo si que el numero enviado es vacio o null
echo "Por Favor Ingrese la Cedula";
}else{//caso contrario sigo el proceso
if(is_numeric($strCedula)){
$total_caracteres=strlen($strCedula);// se suma el total de caracteres
if($total_caracteres==10){//compruebo que tenga 10 digitos la cedula
$nro_region=substr($strCedula, 0,2);//extraigo los dos primeros caracteres de izq a der
if($nro_region>=1 && $nro_region<=24){// compruebo a que region pertenece esta cedula//
$ult_digito=substr($strCedula, -1,1);//extraigo el ultimo digito de la cedula
//extraigo los valores pares//
$valor2=substr($strCedula, 1, 1);
$valor4=substr($strCedula, 3, 1);
$valor6=substr($strCedula, 5, 1);
$valor8=substr($strCedula, 7, 1);
$suma_pares=($valor2 + $valor4 + $valor6 + $valor8);
//extraigo los valores impares//
$valor1=substr($strCedula, 0, 1);
$valor1=($valor1 * 2);
if($valor1>9){ $valor1=($valor1 - 9); }else{ }
$valor3=substr($strCedula, 2, 1);
$valor3=($valor3 * 2);
if($valor3>9){ $valor3=($valor3 - 9); }else{ }
$valor5=substr($strCedula, 4, 1);
$valor5=($valor5 * 2);
if($valor5>9){ $valor5=($valor5 - 9); }else{ }
$valor7=substr($strCedula, 6, 1);
$valor7=($valor7 * 2);
if($valor7>9){ $valor7=($valor7 - 9); }else{ }
$valor9=substr($strCedula, 8, 1);
$valor9=($valor9 * 2);
if($valor9>9){ $valor9=($valor9 - 9); }else{ }

$suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
$suma=($suma_pares + $suma_impares);
$dis=substr($suma, 0,1);//extraigo el primer numero de la suma
$dis=(($dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
$digito=($dis - $suma);
if($digito==10){ $digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
if ($digito==$ult_digito){//comparo los digitos final y ultimo
  
  $_correo= $_POST['correo']; $_cedula= $_POST['cedulausuario'];
  include("config/bd.php");
  $cons= $conexion->prepare("SELECT *FROM usuarios where correo=:co or cedula=:ced");
  $cons->bindParam(':co',$_correo);
  $cons->bindParam(':ced',$_cedula);
  $cons->execute();
  $countax= $cons->rowCount();
    if($countax >0){
      $ima=$cons->fetch();
    ?>
        <script>
          swal.fire("usuario o correo ya se encuentra registrado");
        </script>
  
<?php }else{
      "entre aqui a else";
      include("config/bd.php");
      $_nombre= $_POST['nombres']; $_apellidos= $_POST['apellidos'];$_cedula= $_POST['cedulausuario']; $_direccion= $_POST['direccion']; $_correo= $_POST['correo']; $_contrasenia= $_POST['contrasenia'];$_tipo= 1;
      $insertar= $conexion->prepare("INSERT INTO usuarios (cedula, nombres, apellidos, direccion, correo, contrasenia, tipo_usuario) VALUES (:cedul, :nombre, :apellido, :direccion, :correo, :contrasenia, :tipo);");
      $insertar->bindParam(':cedul',$_cedula);
      $insertar->bindParam(':nombre',$_nombre);
      $insertar->bindParam(':apellido',$_apellidos);
      $insertar->bindParam(':direccion',$_direccion);
      $insertar->bindParam(':correo',$_correo);
      $insertar->bindParam(':contrasenia',$_contrasenia);
      $insertar->bindParam(':tipo',$_tipo);
      $insertar->execute(); ?>
      <script>

    const href= "login.php"
    Swal.fire({
        title: 'usuario registrado exitosamente',

        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ok'
    }).then((result) => {
        if (result.value ) {
            document.location.href= href;

                
        }else{
            
        }
    })





</script>
     
      
<?php                

  }
   
}else{
  $mostrartodo=true;
  ?>
  <script>
    swal.fire("Ingrese una cedula valida");
  </script>

<?php
}
}else{
  $mostrartodo=true;
  ?>
  <script>
    swal.fire("Ingrese una cedula valida");
  </script>

<?php

}


}else{
  $mostrartodo=true;
  ?>
  <script>
    swal.fire("Ingrese una cedula valida");
  </script>

<?php
}
}else{
  $mostrartodo=true;
  ?>
  <script>
    swal.fire("Ingrese una cedula valida");
  </script>

<?php
}
}
}
validarCI($_POST['cedulausuario']);
    
      
/* 
      $_correo= $_POST['correo']; $_cedula= $_POST['cedulausuario'];
      include("config/bd.php");
      $cons= $conexion->prepare("SELECT *FROM usuarios where correo=:co or cedula=:ced");
      $cons->bindParam(':co',$_correo);
      $cons->bindParam(':ced',$_cedula);
      $cons->execute();
      $countax= $cons->rowCount();
        if($countax >0){
          $ima=$cons->fetch();
        ?>
            <script>
              swal.fire("usuario o correo ya se encuentra registrado");
            </script>
      
    <?php }else{
          "entre aqui a else";
          include("config/bd.php");
          $_nombre= $_POST['nombres']; $_apellidos= $_POST['apellidos'];$_cedula= $_POST['cedulausuario']; $_direccion= $_POST['direccion']; $_correo= $_POST['correo']; $_contrasenia= $_POST['contrasenia'];$_tipo= 1;
          $insertar= $conexion->prepare("INSERT INTO usuarios (cedula, nombres, apellidos, direccion, correo, contrasenia, tipo_usuario) VALUES (:cedul, :nombre, :apellido, :direccion, :correo, :contrasenia, :tipo);");
          $insertar->bindParam(':cedul',$_cedula);
          $insertar->bindParam(':nombre',$_nombre);
          $insertar->bindParam(':apellido',$_apellidos);
          $insertar->bindParam(':direccion',$_direccion);
          $insertar->bindParam(':correo',$_correo);
          $insertar->bindParam(':contrasenia',$_contrasenia);
          $insertar->bindParam(':tipo',$_tipo);
          $insertar->execute(); ?>
          <script>

        const href= "login.php"
        Swal.fire({
            title: 'usuario registrado exitosamente',

            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ok'
        }).then((result) => {
            if (result.value ) {
                document.location.href= href;

                    
            }else{
                
            }
        })
  
    



</script>
         
          
 <?php                
  
      }
        */
        
        

        

    

  break;
} ?>

  <?php if($mostrartodo==true){ ?>

 
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 border border-secondary" style="border-radius:0.3rem; border-style: solid;box-shadow: 0px 2px 3px 6px #D5E1DF ;">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-weight:bold; ">REGISTRO DE USUARIO</h3>
                <br>
                <form  method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="inputAddress" class="form-label" style="font-weight:bold;">Nombres:</label>
                      <input type="text" minlength="5" class="form-control " id="nombres" name="nombres" placeholder="Ingrese sus nombres completos" required>
                    </div>
                    <div class="col-md-12">
                      <label for="inputAddress2" class="form-label" style="font-weight:bold;">Apellidos:</label>
                      <input type="text" minlength="5" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="col-md-6">
                      <label for="inputCity" class="form-label" style="font-weight:bold;">Número de cédula:</label>
                        <input type="text"  pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="cedulausuario" name="cedulausuario" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">  
                    </div>
                    <div class="col-md-6">
                      <label for="inputState" class="form-label" style="font-weight:bold;">Dirección</label>
                      <input type="text"  minlength="10" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                        <input type="email" minlength="10" class="form-control" id="correo" name="correo" required>
                      </div>
                      <div class="col-md-6">
                        <label for="inputPassword4" class="form-label" style="font-weight:bold;">Contraseña:</label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.4rem; margin-bottom: 0.3rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7 "> <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""></button>   
                        <input type="password" minlength="8" class="form-control" id="password" name="contrasenia" required>
                      </div>
                      <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                      <button type="submit" style="margin-top:2rem;" class="btn bton" id="registrar" name="registro_usuario"  value="registr">Registrarse</button> 
                   
                    </div>
                    <div class="col-md-4"></div>
                    </div>        
                  </form>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>


 <?php }else{?>
  <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 border border-secondary" style="border-radius:0.3rem; border-style: solid;box-shadow: 0px 2px 3px 6px #D5E1DF ;">
                <br>
                <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem; font-weight:bold; ">REGISTRO DE USUARIO</h3>
                <br>
                <form  method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="inputAddress" class="form-label" style="font-weight:bold;">Nombres:</label>
                      <input type="text" minlength="5" class="form-control " id="nombres" name="nombres" value="<?php echo $_nombre ?>" placeholder="Ingrese sus nombres completos" required>
                    </div>
                    <div class="col-md-12">
                      <label for="inputAddress2" class="form-label" style="font-weight:bold;">Apellidos:</label>
                      <input type="text" minlength="5" class="form-control" id="apellidos" name="apellidos" value="<?php echo $_apellidos ?>" placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="col-md-6">
                      <label for="inputCity" class="form-label" style="font-weight:bold;">Número de cédula:</label>
                        <input type="text"  pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="cedulausuario"  value="<?php echo $_cedula ?>"name="cedulausuario" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">  
                    </div>
                    <div class="col-md-6">
                      <label for="inputState" class="form-label" style="font-weight:bold;">Dirección</label>
                      <input type="text"  minlength="10" class="form-control" id="direccion" name="direccion"value="<?php echo $_direccion ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label" style="font-weight:bold;">Correo electrónico:</label>
                        <input type="email" minlength="10" class="form-control" id="correo" name="correo" value="<?php echo $_correo ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label for="inputPassword4" class="form-label" style="font-weight:bold;">Contraseña:</label>
                        <button type="button" class="btn  text-center"  onclick="mostrarContrasena()" style="width:2.4rem; margin-bottom: 0.3rem; font-size: 1rem; font-family: Homer Simpson UI; background:#E0F8F7 "> <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""></button>   
                        <input type="password" minlength="8" class="form-control" id="password" value="<?php echo $_contrasenia ?>"  name="contrasenia" required>
                      </div>
                      <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                      <button type="submit"  style="margin-top:2rem;" class="btn bton" id="registrar" name="registro_usuario"  value="registr">Registrarse</button> 
                   
                    </div>
                    <div class="col-md-4"></div>
                    </div>        
                  </form>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

  <?php }?>

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

<br><br><br><br><br><br><br><br><br><br>


<?php include("plantillas/footer.php"); ?>
   