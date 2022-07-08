<?php include("plantillas/encabezado.php"); ?>
<?php
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;

if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==1){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
    
    die();
}
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['registro_pago']))
    {
        registrar_pago();       
    }

    function registrar_pago() {
        include("config/bd.php");
        $cedula_sesin="0930492731";
        $_banco= $_POST['valorid']; $_tipocu= $_POST['valorc'];$_ncuenta= $_POST['cuenta']; $_cedtitular= $_POST['titular']; $_nombret= $_POST['nombretitular']; 
        $insertar= $conexion->prepare("INSERT INTO pago (id_banco, tipo_cuenta, numero_cuenta, titular_cuenta, cedula_titular, cedula) VALUES (:idb, :tipo, :num, :titul, :ced, :c);");
        $insertar->bindParam(':idb',$_banco);
        $insertar->bindParam(':tipo',$_tipocu);
        $insertar->bindParam(':num',$_ncuenta);
        $insertar->bindParam(':titul',$_nombret);
        $insertar->bindParam(':ced',$_cedtitular);
        $insertar->bindParam(':c',$cedula_sesin);
        $insertar->execute();
        
    }?>

<?php 
$presentar=False;
$click=(isset($_POST['editarpro']))?$_POST['editarpro']:"";
switch($click){
    case "editar":
        include("config/bd.php");
        $_idpago=$_POST['visualizar'];
        $consultarpago= $conexion->prepare(" SELECT p.id_pago, p.tipo_cuenta, p.titular_cuenta, p.cedula_titular, p.id_banco, b.nombre_banco, p.numero_cuenta FROM pago AS p INNER JOIN bancos AS b ON p.id_banco= b.id_banco WHERE p.id_pago=:id");  
        $consultarpago->bindParam(':id',$_idpago);                   
        $consultarpago->execute();
        $_count = $consultarpago->rowCount();
        
        if($_count > 0 ){
            $presentar=True; 
        $_pago_= $consultarpago->fetch();
        
        }else{  
        
            }
       
        break;
    case "sub":
      
        break;       
}

?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actualizapro']))
 {   
     actualizar_pago();
    
 }?>

<?php function actualizar_pago() {  
        include("config/bd.php");
        $_idpago= $_POST['pagoo'];$_ncuenta= $_POST['cuenta']; $_cedtitular= $_POST['titular']; $_nombret= $_POST['nombretitular'];
        $actualizarct= $conexion->prepare("UPDATE pago SET numero_cuenta=:numero, titular_cuenta=:tit, cedula_titular=:ced WHERE id_pago= :id");
        $actualizarct->bindParam(':id',$_idpago);
        $actualizarct->bindParam(':tit',$_nombret);
        $actualizarct->bindParam(':numero',$_ncuenta);
        $actualizarct->bindParam(':ced',$_cedtitular);
        $actualizarct->execute();
             }?>



<br><br><br><br><br>
<h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">Mis Datos de Pago</h3>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 border border-secondary" style="box-shadow: 0px 4px 3px 7px #D5E1DF ; border-radius:0.3em;">
                    <br>
                    <form class="row g-3" method="POST">
                    <div class="col-6">
                    <?php if($presentar==False){ ?>
                    <?php include("config/bd.php");
                        $sqlmm = "SELECT *FROM bancos";
                        $conban = $conexion->prepare($sqlmm);
                        $conban->execute();
                        $countt= $conban->rowCount();
                        if($countt >0) {
                            $banco=$conban->fetchAll();
                        }?>
                        <label for="inputCity" class="form-label">banco:</label>
                        
                        <select class="form-select" id="country" name="valorid" required>
                        <?php foreach($banco as $ban):?>       
                            <option name="opcion" value="<?php echo$ban['id_banco']?>"><?php echo$ban['nombre_banco']?></option>
                            <?php endforeach;?>
                            </select>
                              
                    </div>
                    <div class="col-6">
                    <label for="inputCity" class="form-label">.</label>
                    <select class="form-select" id="country" name="valorc" required>           
                            <option name="opcion" value="ahorros">Ahorros</option>
                            <option name="opcion" value="corriente">Corriente</option>
                            </select>
                            
                    </div>
                    <div class="col-md-6">
                    <label for="inputCity" class="form-label">Número de cuenta</label>
                    <input type="number" class="form-control" id="cedula" name="cuenta" required>
                    </div>
                    <div class="col-md-6">
                    <label for="inputState" class="form-label">cedula titular</label>
                    <input type="number" class="form-control" id="direccion" name="titular" required>
                    </div>
                    <div class="col-md-12">
                        <label for="inputEmail4" class="form-label">Titular de la cuenta:</label>
                        <input type="text" class="form-control" id="correo" name="nombretitular" required>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                    <button type="submit" class="btn bton" name="registro_pago">Agregar</button> 
                    </div>
                    <div class="col-md-4"></div>
                    
                    <?php }else {?>
                        
                        <label for="inputCity" class="form-label">banco:</label>
                        
                        <select disabled class="form-select" id="country" name="valorid" required>
                             
                            <option  name="opcion" value=""><?php echo$_pago_['nombre_banco']?></option>
                           
                            </select>
                              
                    </div>
                    <div class="col-6">
                    <label for="inputCity" class="form-label">.</label>
                    <select disabled class="form-select" id="country" name="valorc" required>           
                            <option name="opcion" value="<?php echo$_pago_['tipo_cuenta']?>"><?php echo$_pago_['tipo_cuenta']?></option>
                            
                            </select>
                            
                    </div>
                    <div class="col-md-6">
                    <label for="inputCity" class="form-label">Número de cuenta</label>
                    <input type="number" class="form-control" id="cedula" name="cuenta" value="<?php echo$_pago_['numero_cuenta']?>" required>
                    </div>
                    <div class="col-md-6">
                    <label for="inputState" class="form-label">cedula titular</label>
                    <input type="number" class="form-control" id="direccion" name="titular" value="<?php echo$_pago_['cedula_titular']?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="inputEmail4" class="form-label">Titular de la cuenta:</label>
                        <input type="text" class="form-control" id="correo" name="nombretitular" value="<?php echo$_pago_['titular_cuenta']?>" required>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                    <input type="text" name="pagoo" value="<?php echo $_pago_['id_pago']?>" hidden>   
                    <button type="submit" class="btn bton" name="actualizapro">Actualizar</button> 
                    </div>
                    <div class="col-md-4"></div>

                        <?php }?> 
                    </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                    <div class="table-responsive">
                <table id="example" class="table table-striped table-hover table-bordered">
                <thead style="background-color: #7FB3D5 ">
                    <tr class="text-center">
                    <th  scope="col">Banco</th>
                    <th  scope="col">tipo</th>
                    <th  scope="col">numero cuenta</th>
                    
                    <th scope="col">acciones</th>
                    
                    
                    </tr>
                </thead>
                <tbody style="background-color: #82E0AA ">
                <?php include("config/bd.php");
                    $sqlma = "SELECT p.id_pago, p.tipo_cuenta, p.titular_cuenta, p.cedula_titular, p.id_banco, b.nombre_banco, p.numero_cuenta FROM pago AS p INNER JOIN bancos AS b ON p.id_banco= b.id_banco ";
                    $cons = $conexion->prepare($sqlma);
                    $cons->execute();
                    $countc= $cons->rowCount();
                    if($countc >0) {
                        $pago=$cons->fetchAll();
                    }
                    foreach($pago as $p):?>
                    <tr>
                    <td ><?php echo$p['nombre_banco']?></td>
                    <td ><?php echo$p['tipo_cuenta']?></td>
                    <td ><?php echo$p['numero_cuenta']?></td>
                    <td class="text-center">
                    <form action="" method="POST">
                    <input type="text" name="visualizar" value="<?php echo $p['id_pago']?>" hidden>   
                    <button type="submit" class="btn  border border-secundary text-center" name="editarpro" value="editar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>    
                    </form>
                    </td>
                    </tr>
                    <?php endforeach;?>
        
                </tbody>
                </table>
            </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br>



<?php include("plantillas/footer.php"); ?>