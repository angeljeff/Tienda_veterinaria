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
}?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['registro_pro']))
            {
                registrar_proveedor();
                
            }

            function registrar_proveedor() {
              include("config/bd.php");
              $_nombre_pro= $_POST['proveedor']; 
              $insertarpro= $conexion->prepare("INSERT INTO proveedores (nombre_pro ) VALUES (:pro);");
              $insertarpro->bindParam(':pro',$_nombre_pro);  
              $insertarpro->execute();
            }?>

<?php include("config/bd.php");
$_actualizar= False ?>
<?php $accion=(isset($_POST['editarpro']))?$_POST['editarpro']:""; ?>
<?php {
if(isset($_GET['editarpro']));
    $consultarp= $conexion->prepare("SELECT *FROM proveedores WHERE  id_proveedores= :id "); 
    $consultarp->bindParam(':id',$accion);                   
    $consultarp->execute();
    $_count = $consultarp->rowCount();
    if($_count > 0 ){
    $_datusuario= $consultarp->fetch();
    $_actualizar= True;
    }else{       
        }
        } ?>
<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actu_pro']))
 {   
     actualizar_pro();
    
 }?>

<?php function actualizar_pro() {  
            include("config/bd.php");
            $_nombrepro= $_POST['proveedor']; $_id= $_POST['prove']; 
            $actualizarpro= $conexion->prepare("UPDATE proveedores SET nombre_pro=:nombre WHERE id_proveedores= :id");
            $actualizarpro->bindParam(':id',$_id);
            $actualizarpro->bindParam(':nombre',$_nombrepro);
            $actualizarpro->execute();

               }?>


<br>
<h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">Mis proveedores</h3>
<br>

<div class="container-fluid">
    <div class="row">
    <div class="col-md-1"> </div>
        <div class="col-md-3">
        <br><br>
        <form class="row g-4 border border-primary border-2" style="background-color:#82E0AA; border-radius:0.4em; " method="POST">
        <br>
        <div class="col-md-12">
        <?php if($_actualizar== False){ ?>
            <input type="text" class="form-control"  name="proveedor" placeholder="Ingrese el nombre del proveedor" required> 
            <?php }else {?>
        <input type="text" class="form-control "  name="prove" placeholder="Ingrese el nombre del proveedor" value="<?=$_datusuario['id_proveedores'] ?>" hidden> 
        
        <input type="text" class="form-control"  name="proveedor" placeholder="Ingrese el nombre del proveedor" value="<?=$_datusuario['nombre_pro'] ?>"required> 
            <?php }?> 
        </div>

        <div class="col-md-4"></div>
        <div class="col-md-4 text-center">
        <?php if($_actualizar== False){ ?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; " name="registro_pro">Agregar</button> 
            <?php }else {?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; "name="actu_pro">Actualizar</button> 
            <?php }?> 
        </div>
        <div class="col-md-4"></div> 
        <br>       
        </form>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">Proveedores</th>
                
                <th scope="col">acciones</th>
                
                
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                $sqlm = "SELECT *FROM proveedores";
                $consultarcat = $conexion->prepare($sqlm);
                $consultarcat->execute();
                $count= $consultarcat->rowCount();
                if($count >0) {
                    $categorrias=$consultarcat->fetchAll();
                }
                 foreach($categorrias as $cat):?>
                <tr>
                <td ><?php echo$cat['nombre_pro']?></td>
                <td class="text-center">
                <form action="" method="POST">
                <input type="text" name="visualizar" value="<?php echo $cat['id_proveedores']?>" hidden>   
                <button type="submit" class="btn  border border-secundary text-center" name="editarpro" value="<?php echo$cat['id_proveedores']?>" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>    
                </form>
                </td>
                </tr>
                <?php endforeach;?>
      
            </tbody>
            </table>
            </div>

        </div>
        <div class="col-md-1"></div>
      
    </div>
    <br>
</div>
<br><br><br><br><br>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="tabla.js"></script>



<?php include("plantillas/footer.php"); ?>