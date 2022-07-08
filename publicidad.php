<?php include("plantillas/encabezado.php"); ?>
 <?php
 $cedula_sesion= $_SESSION['usuario'][0];
 $nombre_sesion= $_SESSION['usuario'][1];
 $tipo_sesion= $_SESSION['usuario'][2];
 if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==1){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
     
     die();
 }?>


<?php




$click=(isset($_POST['ima']))?$_POST['ima']:"";
switch($click){
    case "agregaima":
        if($_FILES['image']["name"]!=""){
            agregar_imagen();
            
        }else{
            
            echo "agrega un imagen porfavor";
        }
        break;
    case "activar":
        include("config/bd.php");
        
        $_estado= 1; $_id= $_POST['estado']; 
        $actualizarest= $conexion->prepare("UPDATE publicidad SET estado=:es WHERE id_publicidad= :id");
        $actualizarest->bindParam(':id',$_id);
        $actualizarest->bindParam(':es',$_estado);
        $actualizarest->execute();
        break;
    
        case "inactivar":
            include("config/bd.php");
            
            
            $_estado= 0; $_id= $_POST['estad'];
            echo "entre a INACTIVAR $_id";
            $actualizarest= $conexion->prepare("UPDATE publicidad SET estado=:es WHERE id_publicidad= :id");
            $actualizarest->bindParam(':id',$_id);
            $actualizarest->bindParam(':es',$_estado);
            $actualizarest->execute();
            break;
}

function agregar_imagen(){
    $fecha= new DateTime();
    $nombrearchivo=$fecha->getTimestamp()."_".$_FILES["image"]["name"];
    echo $nombrearchivo;
    $iamgencompleta="imagenes/publicidad/".$nombrearchivo;
    $estado=1;
    $cedula_sesin= "0930492731";
    $ima=$_FILES["image"]["tmp_name"];
    include("config/bd.php");
    $insertarpu= $conexion->prepare("INSERT INTO publicidad (imagen, estado, cedula ) VALUES (:imagenn, :es, :ced);");
    $insertarpu->bindParam(':imagenn',$nombrearchivo);
    if($ima!=""){
        move_uploaded_file($ima,"imagenes/publicidad/".$nombrearchivo);
    }
    $insertarpu->bindParam(':es',$estado);
    $insertarpu->bindParam(':ced', $cedula_sesin);
    $insertarpu->execute();   

}

?>


<br><br><br>
<h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">MI PUBLICIDAD</h3>
<br>
<div class="container-fluid">
    <div class="row">
    <div class="col-md-6">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-7">
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-file" >
                <div class="form-file__action">
                    <input type="file" name="image" id="image" />

                </div>
                <div class="form-file__result" id="result-image">
                    <img id="img-result" alt="" />
                </div>
                </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-8">

                    <button type="submit" class="btn bton" style="font-size:1.3rem !important; "name="ima" value="agregaima">Agregar publicidad</button>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            </form>
            </div>
            <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="container">
            <div class="row">
                <div class="col-md-11">
                <div class="table-responsive">
            <table id="example"class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">Todas mis publicidades</th>
                
                <th scope="col">acciones</th>
                
                
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                $sql = "SELECT *FROM publicidad";
                $consultarpu = $conexion->prepare($sql);
                $consultarpu->execute();
                $count= $consultarpu->rowCount();
                if($count >0) {
                    $publicidad=$consultarpu->fetchAll();
                }

                 foreach($publicidad as $pub):?>
                <tr class="text-center">
                
                <td ><img src="imagenes/publicidad/<?php echo $pub['imagen']?>" style="width:12rem; height:auto" alt=""> </td>
                <td class="text-center"><form method="POST">
                <?php if($pub['estado']== 1){ ?>
                <input type="text" name="estad" value="<?php echo $pub['id_publicidad']?>" hidden>
                <button type="submit" class="btn  border border-secundary text-center" name="ima" value="inactivar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#FA5858  "> inactivar</button>   
                </form>
                <?php }else {?>
                <form method="POST">
                <input type="text" name="estado" value="<?php echo $pub['id_publicidad']?>" hidden>
                <button type="submit" class="btn  border border-secundary text-center" name="ima" value="activar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#2E9AFE  "> activar</button>   
                </form></td>
                <?php }?> 
                
                
                </tr>
                <?php endforeach;?>
                
            </tbody>
            </table>
        </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
 

    </div>
</div>
</div>

<br><br><br><br><br><br>







<?php include("plantillas/footer.php"); ?>