<?php include("plantillas/encabezado.php"); ?>
<?php $_actualizar= False ?>
<?php $_actualizars= False; 
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;
if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==1){?>
    <script>
        document.location.href="<?php echo $url ?>/login.php";
    </script>
<?php
   
    die();
}?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['registro_cat']))
            {
                registrar_categoria();          
            }
            function registrar_categoria() {
              include("config/bd.php");
              $_nombre_cat= $_POST['categoria']; 
              $insertarcat= $conexion->prepare("INSERT INTO categorias (nombre_cat ) VALUES (:cate);");
              $insertarcat->bindParam(':cate',$_nombre_cat);  
              $insertarcat->execute();
            }?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['registro_sucat']))
            {
                registrar_subcategoria();          
            }
            function registrar_subcategoria() {
              include("config/bd.php");
              $_nombre_subcat= $_POST['subcategoria']; $_id_subcat= $_POST['valorid'];
              $insertarsucat= $conexion->prepare("INSERT INTO sub_categorias (nombre_sub_ca, id_categoria ) VALUES (:scate, :ic);");
              $insertarsucat->bindParam(':scate',$_nombre_subcat);
              $insertarsucat->bindParam(':ic',$_id_subcat); 
              $insertarsucat->execute();
            }?>

<?php include("config/bd.php"); ?>
<?php $accionn=(isset($_POST['editarcat']))?$_POST['editarcat']:""; ?>
<?php 
if(isset($_GET['editarcat']));
    $consultarc= $conexion->prepare("SELECT *FROM categorias WHERE  id_categoria= :id ");  
    $consultarc->bindParam(':id',$accionn);                   
    $consultarc->execute();
    $_count = $consultarc->rowCount();
    if($_count > 0 ){
    $_datcat= $consultarc->fetch();
    $_actualizar= True;
    }else{        
        }
         ?>

<?php include("config/bd.php"); ?>
<?php $accionnn=(isset($_POST['editarsub']))?$_POST['editarsub']:""; ?>
<?php 
if(isset($_GET['editarsub']));
    $consultarsu= $conexion->prepare("SELECT cat.nombre_cat, sub.id_sub_cat, sub.nombre_sub_ca FROM sub_categorias AS sub INNER JOIN categorias AS cat ON sub.id_categoria= cat.id_categoria WHERE  id_sub_cat= :idi ");  
    $consultarsu->bindParam(':idi',$accionnn);                   
    $consultarsu->execute();
    $_countt = $consultarsu->rowCount();
    if($_countt > 0 ){
    $_subcu= $consultarsu->fetch();
    $_actualizars= True;
    }else{        
        }
         ?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actu_sub']))
 {   
     actualizar_sub();
    
 }?>

<?php function actualizar_sub() {  
        include("config/bd.php");
        $_nombresub= $_POST['subcategoria']; $_ib= $_POST['codigo']; 
        $actualizarst= $conexion->prepare("UPDATE sub_categorias SET nombre_sub_ca=:nomb WHERE id_sub_cat= :iid");
        $actualizarst->bindParam(':iid',$_ib);
        $actualizarst->bindParam(':nomb',$_nombresub);
        $actualizarst->execute();
             }?>





<?php include("config/bd.php"); ?>
<?php
$presentar=False;
$nc= False;
$click=(isset($_POST['versubcat']))?$_POST['versubcat']:"";
switch($click){
    case "ver":
        $presentar=True;
        $nc=True;
        break;
    case "sub":
        $presentar=False;
        $nc=False;
        break;
       
}

 

if(isset($_GET['editarcat']));
    $consultarc= $conexion->prepare("SELECT *FROM categorias WHERE  id_categoria= :id ");  
    $consultarc->bindParam(':id',$accionn);                   
    $consultarc->execute();
    $_count = $consultarc->rowCount();
    if($_count > 0 ){
    $_datcat= $consultarc->fetch();
    $_actualizar= True;
    }else{  
           
        }
         ?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['actu_cat']))
 {   
     actualizar_cat();
    
 }?>

<?php function actualizar_cat() {  
        include("config/bd.php");
        $_nombrec= $_POST['categoria']; $_id= $_POST['cod']; 
        $actualizarct= $conexion->prepare("UPDATE categorias SET nombre_cat=:nombre WHERE id_categoria= :id");
        $actualizarct->bindParam(':id',$_id);
        $actualizarct->bindParam(':nombre',$_nombrec);
        $actualizarct->execute();
             }?>
<br><br><br><br><br>
<h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">Mis categorías</h3>
<br>

<div class="container-fluid">
    <div class="row">
    
    <div class="col-md-3 text-center ms-3">
    <col-md-12 class="text-center">
    <?php if($_actualizar== False){ ?>
       <label for="" style="padding:0.4rem; font-size:1.5rem; font-family:Garamond (serif); background-color:#A9D0F5; border-radius:3%">Añadir nueva categoría</label></col-md-12>
        <?php }else {?>
       <label for="" style="padding:0.4rem; font-size:1.5rem; font-family:Garamond (serif); background-color:#A9D0F5; border-radius:3%">Está actualizando una categoría</label></col-md-12>
            <?php }?> 
        <br><br><br>
        
        <form class="row g-4 border border-primary border-2" style="background-color:#82E0AA; border-radius:0.3em; " method="POST">
        <br>
        <div class="col-md-12">
        <?php if($_actualizar== False){ ?>
            <input type="text" class="form-control"  name="categoria" placeholder="Ingrese el nombre de la categoría" required> 
            <?php }else {?>
        <input type="text" class="form-control "  name="cod" placeholder="Ingrese el nombre del proveedor" value="<?=$_datcat['id_categoria'] ?>" hidden> 
        
        <input type="text" class="form-control"  name="categoria" placeholder="Ingrese el nombre de la categoría" value="<?=$_datcat['nombre_cat'] ?>"required> 
            <?php }?> 
        </div>

        <div class="col-md-4"></div>
        <div class="col-md-4 text-center">
        <?php if($_actualizar== False){ ?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; " name="registro_cat">Agregar</button> 
            <?php }else {?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; "name="actu_cat">Actualizar</button> 
            <?php }?> 
        </div>
        <div class="col-md-4"></div> 
        <br>       
        </form>
        </div>
        <div class="col-md-5">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">Categorías</th>
                
                <th scope="col">acciones</th>
                
                
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                $sqlm = "SELECT *FROM categorias";
                $consultarcat = $conexion->prepare($sqlm);
                $consultarcat->execute();
                $count= $consultarcat->rowCount();
                if($count >0) {
                    $categorrias=$consultarcat->fetchAll();
                }
                 foreach($categorrias as $cat):?>
                <tr>
                <td ><?php echo$cat['nombre_cat']?></td>
                <td class="text-center">
                <form action="" method="POST">
                <input type="text" name="visualizar" value="<?php echo $cat['id_categoria']?>" hidden>
                <button type="submit" class="btn  border border-secundary text-center" name="versubcat" value="ver" style="width:12rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81BEF7  "> <img style="width:1rem; heigth:auto" src="imagenes/iconojo.svg" alt="">  Ver subcategorías</button>   
                <button type="submit" class="btn  border border-secundary text-center" name="editarcat" value="<?php echo$cat['id_categoria']?>" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>   
                <?php if($nc== True){ ?>
                <button type="submit" class="btn  border border-secundary text-center" name="versubcat" value="sub" style="width:6.5rem; font-size: 1rem; font-family: Homer Simpson UI; background:#01DFD7 "> <img style="width:1rem; heigth:auto" src="imagenes/nuevo.svg" alt=""> SUB</button>   
                <?php }?> 
                </form>
                </td>
                </tr>
                <?php endforeach;?>
      
            </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-3 text-center">
        <?php if($presentar== False){ ?>
            <col-md-12 class="text-center">
    <?php if($_actualizars== False){ ?>
       <label for="" style="padding:0.4rem; font-size:1.5rem; font-family:Garamond (serif); background-color:#A9D0F5; border-radius:3%">Añadir nueva subcategoría</label></col-md-12>
        <?php }else {?>
       <label for="" style="padding:0.4rem; font-size:1.5rem; font-family:Garamond (serif); background-color:#A9D0F5; border-radius:3%">Está actualizando una subcategoría</label></col-md-12>
            <?php }?> 
        <br><br><br>
        
        <form class="row g-4 border border-primary border-2" style="background-color:#82E0AA; border-radius:0.3em; " method="POST">
        <br>
        <div class="col-md-12">
        <?php if($_actualizars== False){ ?>
            <?php include("config/bd.php");
                $sqlm = "SELECT *FROM categorias";
                $consultarcat = $conexion->prepare($sqlm);
                $consultarcat->execute();
                $count= $consultarcat->rowCount();
                if($count >0) {
                    $categorrias=$consultarcat->fetchAll();
                }?>
                <select class="form-select" id="country" name="valorid" required>
                <?php foreach($categorrias as $cat):?>
                            
                            <option name="opcion" value="<?php echo$cat['id_categoria']?>"><?php echo$cat['nombre_cat']?></option>

                            <?php endforeach;?>
                            </select>
                            <br>
            <input type="text" class="form-control"  name="subcategoria" placeholder="Ingrese el nombre de la subcategoría" required> 
            <?php }else {?>
            <select disabled class="form-select" id="country" name="valorid" required>
                            <option name="opcion" value=""><?php echo $_subcu['nombre_cat']?></option>
                            </select>
        <br>
        <input type="text" class="form-control "  name="codigo" placeholder="Ingrese el nombre del subcategoria" value="<?=$_subcu['id_sub_cat'] ?>" hidden> 
        
        <input type="text" class="form-control"  name="subcategoria" placeholder="Ingrese el nombre de la subcategoría" value="<?=$_subcu['nombre_sub_ca'] ?>"required> 
            <?php }?> 
        </div>

        <div class="col-md-4"></div>
        <div class="col-md-4 text-center">
        <?php if($_actualizars== False){ ?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; " name="registro_sucat">Agregar</button> 
            <?php }else {?>
        <button type="submit" class="btn bton" style="font-size:1.3rem !important; "name="actu_sub">Actualizar</button> 
            <?php }?> 
        </div>
            <?php }else {?>
            <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">Sub-Categorías</th>
                
                <th scope="col">acciones</th>
                
                
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">

           <?php include("config/bd.php");
            
            $dato=(isset($_POST['visualizar']))?$_POST['visualizar']:"";
            if(isset($_GET['visualizar']));
            include("config/bd.php");
            $sqlm2 = "SELECT *FROM sub_categorias WHERE  id_categoria= :idd";
            $consultarsubcat = $conexion->prepare($sqlm2);
            $consultarsubcat->bindParam(':idd',$dato);
            $consultarsubcat->execute();
            $counta= $consultarsubcat->rowCount();
            if($counta >0) {
                $csubategorrias= $consultarsubcat->fetchAll();
                foreach($csubategorrias as $subcat):?>
                    <tr>
                    <td ><?php echo $subcat['nombre_sub_ca']?></td>
                    <td class="text-center">
                    <form action="" method="POST">  
                    <button type="submit" class="btn  border border-secundary text-center" name="editarsub" value="<?php echo $subcat['id_sub_cat']?>" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>   
                    </form>
                    </td>
                    </tr>
                    <?php endforeach;?>
     
                <?php }
                else{
                   
                }
                ?>

            </tbody>
            </table>
            </div>
         
            <?php }?> 
            
        </div>
        <div class="col-md-1"></div>
      
    </div>
    <br>
</div>
<br><br><br><br><br><br>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="tabla.js"></script>







<?php include("plantillas/footer.php"); ?>