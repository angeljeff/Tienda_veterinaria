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


<?php

$_nuevo= False;
$_listadopro= True;
$_actualización= False;


$click=(isset($_POST['navegacion']))?$_POST['navegacion']:"";
switch($click){
    case "nuevo":
        $_nuevo= True;
        $_listadopro= False;
        $_actualización= False;
        break;
    
    case "listado":
        $_nuevo= False;
        $_listadopro= True;
        $_actualización= False; 
        break;
    case "actualizar":
        $_nuevo= False;
        $_listadopro= False;
        $_actualización= True;
        include("config/bd.php");
        $id_producto=$_POST['editar']; 
        echo $id_producto; 
        $sqlb = "SELECT p.id_producto, p.nombre_producto, p.precio_pro, p.cantidad_disp, p.fecha_elaboracion, p.fecha_vencimiento, p.imagen_po, p.id_proveedores, p.id_sub_cat, s.nombre_sub_ca, c.nombre_cat, pro.nombre_pro, s.id_categoria FROM productos as p INNER JOIN sub_categorias as s ON p.id_sub_cat= s.id_sub_cat INNER JOIN categorias as c ON s.id_categoria=c.id_categoria INNER JOIN proveedores as pro ON p.id_proveedores=pro.id_proveedores where p.id_producto=$id_producto";
        $consultarunproducto = $conexion->prepare($sqlb);
        $consultarunproducto->execute();
        $countq= $consultarunproducto->rowCount();
        if($countq >0) {
            $producto=$consultarunproducto->fetch();
        }
        break;
    }
        ?>



<?php $veri=(isset($_POST['modificarbase']))?$_POST['modificarbase']:"";
switch($veri){
    case "agregar":
        if($_FILES['image']["name"]!=""){
            include("config/bd.php");

            $fecha= new DateTime();
            $nombrearchivo=$fecha->getTimestamp()."_".$_FILES["image"]["name"];
            echo $nombrearchivo;
            $iamgencompleta="imagenes/productos/".$nombrearchivo;
            $ima=$_FILES["image"]["tmp_name"];
            
            $estado=1; 
            $_nombrepro= $_POST['nombreproducto']; $_precio= $_POST['precio']; $_stock= $_POST['stock']; $elaboracion= $_POST['elaboracion']; $_vencimiento= $_POST['vencimiento']; $id_sub= $_POST['subcategoria'];$id_pro= $_POST['proveedor'];
            $insertar= $conexion->prepare("INSERT INTO productos (nombre_producto, precio_pro, cantidad_disp, fecha_elaboracion, fecha_vencimiento, id_proveedores, id_sub_cat, estado_producto, cedula, imagen_po) VALUES (:nomb, :precio, :cant, :fe, :fv, :pro, :sub, :est, :ced, :im);");
            $insertar->bindParam(':nomb',$_nombrepro);
            $insertar->bindParam(':precio',$_precio);
            $insertar->bindParam(':cant',$_stock);
            $insertar->bindParam(':fe',$elaboracion);
            $insertar->bindParam(':fv',$_vencimiento);
            $insertar->bindParam(':pro',$id_pro);
            $insertar->bindParam(':sub',$id_sub);
            $insertar->bindParam(':est', $estado);
            $insertar->bindParam(':ced',$cedula_sesion);
            $insertar->bindParam(':im',$nombrearchivo);
            if($ima!=""){
                move_uploaded_file($ima,"imagenes/productos/".$nombrearchivo);
            }
            $insertar->execute();
        
        }else{ ?>
            <script> Swal.fire("Necesita agregar una imagen"); </script>
   <?php    $_nuevo= True;
            $_listadopro= False;
            $_actualización= False;
            ?>
       <?php }
     
        break;  
    case "actualizarpro":
        include("config/bd.php");
        if($_FILES["image"]["name"]==""){
            $_nombrepro= $_POST['nombreproducto']; $_precio= $_POST['precio']; $_stock= $_POST['stock']; $id_pro= $_POST['proveedor']; $id_produ= $_POST['producto'];$fecha_e= $_POST['elaboracion'];$fecha_v= $_POST['vencimiento'];
            $insertar= $conexion->prepare("UPDATE productos SET  nombre_producto=:nomb, precio_pro=:precio, cantidad_disp=:cant, id_proveedores=:pro, fecha_elaboracion=:fe, fecha_vencimiento=:fv WHERE id_producto=$id_produ ");
            $insertar->bindParam(':nomb',$_nombrepro);
            $insertar->bindParam(':precio',$_precio);
            $insertar->bindParam(':cant',$_stock);
            $insertar->bindParam(':pro',$id_pro);
            $insertar->bindParam(':fe',$fecha_e);
            $insertar->bindParam(':fv',$fecha_v);
            $insertar->execute();
        }else{
            $fecha= new DateTime();
            $nombrearchivo2=$fecha->getTimestamp()."_".$_FILES["image"]["name"];
            $ima=$_FILES["image"]["tmp_name"];
            echo "recibi esta imagen".$nombrearchivo2;
            $_nombrepro= $_POST['nombreproducto']; $_precio= $_POST['precio']; $_stock= $_POST['stock']; $id_pro= $_POST['proveedor']; $id_produ= $_POST['producto'];$fecha_e= $_POST['elaboracion'];$fecha_v= $_POST['vencimiento'];
            $insertar= $conexion->prepare("UPDATE productos SET  nombre_producto=:nomb, precio_pro=:precio, cantidad_disp=:cant, id_proveedores=:pro, fecha_elaboracion=:fe, fecha_vencimiento=:fv, imagen_po=:im WHERE id_producto=$id_produ ");
            $insertar->bindParam(':nomb',$_nombrepro);
            $insertar->bindParam(':precio',$_precio);
            $insertar->bindParam(':cant',$_stock);
            $insertar->bindParam(':pro',$id_pro);
            $insertar->bindParam(':fe',$fecha_e);
            $insertar->bindParam(':fv',$fecha_v);
            if($ima!=""){
                move_uploaded_file($ima,"imagenes/productos/".$nombrearchivo2);
            }
            $culsultar= $conexion->prepare("SELECT imagen_po FROM productos where  id_producto=$id_produ ");
            $culsultar->execute();
            $countar= $culsultar->rowCount();
            if($countar >0) {
            $imagen=$culsultar->fetch();
            if(file_exists("imagenes/productos/".$imagen['imagen_po'])){
                unlink("imagenes/productos/".$imagen['imagen_po']);
            }
            }
            $insertar->bindParam(':im',$nombrearchivo2);
            $insertar->execute(); 

     
        } ?>
        <script>
        Swal.fire({

        icon: 'success',
        title: 'Producto actualizado correctamente',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
<?php
        $_nuevo= False;
        $_listadopro= True;
        $_actualización= False;
        break;

    }

 ?>



<br><br><br><br>    
<div class="container text-center">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form action="productos.php" method="POST">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <button type="submit" class="btn btn-outline-dark" style="width:10rem; heigth:auto ; background-color:#F2F5A9" name="navegacion" value="nuevo" >Nuevo producto</button>
        <button type="submit" class="btn btn-outline-dark" style="width:10rem; heigth:auto ; background-color:#81BEF7" name="navegacion" value="listado">Mis productos</button>
        </div>
        </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
<br>


<?php if($_nuevo==True){  ?>


<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        
        <div class="col-md-8 border border-secondary" style="box-shadow: 0px 2px 3px 6px #D5E1DF ;border-radius:0.3rem;">
            <br>
        <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">REGISTRO DE PRODUCTOS</h3>
            <br>
            <form class="row g-3 formulario" method="POST" action="productos.php" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-file">
                                <div class="form-file__action">
                                    <input type="file" name="image" id="image"/>
                                </div>
                                <div class="form-file__result" id="result-image">
                                    <img id="img-result" alt="" />
                                </div>
                            </div>  
                          </div>
                          <div class="col-md-6">
                          <div class="container d-block">
                            <br><br>
                                  <div class="col-md-12"> 
                                        <label for="inputAddress" class="form-label">Nombre Producto</label>
                                        <input type="text" minlenght="5" class="form-control " id="nombre" name="nombreproducto" placeholder="Ingrese el nombre del producto" required>
                                  </div><br>
                                  <div class="col-md-12">
                                        <div class="container">
                                        <div class="row">
                                        <div class="col-md-3">
                                            <label for="inputAddress" class="form-label"> Precio $</label>
                                        </div>
                                      <div class="col-md-9">
                                        <input type="number" min="1" step="0.01" class="form-control " id="precio" name="precio" placeholder="Ingrese precio del producto" required>
                                        </div>
                                        </div>     
                                  </div>
                          </div><br>
                          <div class="col-md-12">
                            <div class="container">
                            <div class="row">
                            <div class="col-md-3">
                                <label for="inputAddress" class="form-label"> stock</label>
                            </div>
                          <div class="col-md-9">
                            <input type="number" min="1" class="form-control " id="stock" name="stock" placeholder="Cantidad disponible" required>
                            </div>
                            </div>     
                      </div>
              </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label"> Fecha elaboración:</label>
                            <?php date_default_timezone_set('America/Bogota');
                            $fecha= new Datetime();
                            $fechaa=$fecha->format("Y-m-d");                           
                            ?>
                            <input type="date" id="start" name="elaboracion" value="" min="2019-01-01" max="<?php echo $fechaa; ?>" style="width: 15rem; font-size: 1.3rem;" >
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label"> Fecha vencimiento:</label>
                            <input type="date" id="start" name="vencimiento" value="" min="<?php echo $fechaa; ?>" max="2026-12-31" style="width: 15rem; font-size: 1.3rem;" >
                        </div>
                    </div>
                </div><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                        <?php include("config/bd.php");
                            $sqlm = "SELECT *FROM sub_categorias";
                            $consultarsub = $conexion->prepare($sqlm);
                            $consultarsub->execute();
                            $counta= $consultarsub->rowCount();
                            if($counta >0) {
                                $subcategorrias=$consultarsub->fetchAll();
                            }?>
                            <label for="country" class="form-label">Subcategoría</label>
                            <select class="form-select" id="country" name="subcategoria" required>
                            <?php foreach($subcategorrias as $scat):?>
                            <option name="opcion" value="<?php echo$scat['id_sub_cat']?>"><?php echo$scat['nombre_sub_ca']?></option>
                            <?php endforeach;?>
                            
                            </select>
                        </div>
                        <div class="col-md-6">
                        <?php include("config/bd.php");
                            $sql = "SELECT *FROM proveedores";
                            $consult = $conexion->prepare($sql);
                            $consult->execute();
                            $coun= $consult->rowCount();
                            if($coun >0) {
                                $proveedor=$consult->fetchAll();
                            }?>
                            <label for="country" class="form-label">Proveedores</label>
                            <select class="form-select" id="country" name="proveedor" required>
                            <?php foreach($proveedor as $pro):?>
                            <option name="opcion" value="<?php echo$pro['id_proveedores']?>"><?php echo$pro['nombre_pro']?></option>
                            <?php endforeach;?>
                            </select>
                        </div> 
                    </div>
                </div>
                <br>
                <!-- <div class="col-12">
                    <label for="country" class="form-label">Proveedores</label>
                    <select class="form-select" id="country" required>
                    <option value="">Choose...</option>
                    <option>United States</option>
                    </select>
                </div> --><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                        <button type="submit" class="btn bton" name="modificarbase" value="agregar">Agregar</button> 
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                </div>        
              </form>

        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<?php }elseif($_listadopro== True){  ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="table-responsive">
            <table id="example"class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th scope="col" >Imagen</th>
                <th scope="col" >Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Fecha elaboración</th>
                <th scope="col">Fecha vencimiento</th>
                <th scope="col">días a vencer</th>
                <th scope="col">Subcategoria</th>
                <th scope="col">Categoria</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Acciones</th>
                
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php"); 
                $sqlx = "SELECT p.id_producto, p.nombre_producto, p.precio_pro, p.cantidad_disp, p.fecha_elaboracion, p.fecha_vencimiento, p.imagen_po, p.id_proveedores, p.id_sub_cat, s.nombre_sub_ca, c.nombre_cat, pro.nombre_pro FROM productos as p INNER JOIN sub_categorias as s ON p.id_sub_cat= s.id_sub_cat INNER JOIN categorias as c ON s.id_categoria=c.id_categoria INNER JOIN proveedores as pro ON p.id_proveedores=pro.id_proveedores where p.estado_producto=1";
                $consultarproducto = $conexion->prepare($sqlx);
                $consultarproducto->execute();
                $countv= $consultarproducto->rowCount();
                if($countv >0) {
                    $product=$consultarproducto->fetchAll();
                }      
                foreach($product as $usu):
                    if($usu['fecha_vencimiento']!="0000-00-00"){
                        $dtz = new DateTimeZone("America/Guayaquil");
                        $fecha= new Datetime("now", $dtz);
                        $fechaa=$fecha->format("Y-m-d");
                        $fecha_vencimiento=$usu['fecha_vencimiento'];
                        $vencimiento=new Datetime($fecha_vencimiento,$dtz);
                        $diff = $vencimiento->diff($fecha); 
                        $dias=$diff->days;
                    }else{
                        $dias=0;
                    }
 ?>
                    
                    <tr>
                    <td ><img src="imagenes/productos/<?php echo $usu['imagen_po']?>" style="width:12rem; height:auto" alt=""> </td>
                    <td style="vertical-align:middle"><?php echo$usu['nombre_producto']?></td>
                    <td style="vertical-align:middle"><?php echo$usu['precio_pro']?></td>
                    <td style="vertical-align:middle"><?php echo $usu['cantidad_disp']?></td>
                    <td style="vertical-align:middle"><?php echo $usu['fecha_elaboracion']?></td>
                    <td style="vertical-align:middle"><?php echo $usu['fecha_vencimiento']?></td>
                    <?php
                    $dtz = new DateTimeZone("America/Guayaquil");
                    $fecha_vencimiento=$usu['fecha_vencimiento'];
                    $vencimiento=new Datetime($fecha_vencimiento,$dtz);
                    $fecha_actual= strtotime(date("Y-m-d H:i:00",time()));
                    $fec=$vencimiento->format('Y-m-d H:i:s');
                    $fecha_vence= strtotime($fec);
                    if($fecha_actual > $fecha_vence)
	                    { ?>
                    <td style="vertical-align:middle"><?php echo "-".$dias." "."días" ?></td>
                    <?php }else{ ?>
                    <td style="vertical-align:middle"><?php echo $dias." "."días" ?></td>
                    <?php } ?>
                    <td style="vertical-align:middle"><?php echo $usu['nombre_sub_ca']?></td>
                    <td style="vertical-align:middle"><?php echo $usu['nombre_cat']?></td>
                    <td style="vertical-align:middle"><?php echo $usu['nombre_pro']?></td>
                    <td class="text-center" style="vertical-align:middle">
                    <form action="" method="POST">
                    <input type="text" name="editar" value="<?php echo $usu['id_producto']?>" hidden>
                    <button type="submit" class="btn  border border-secundary text-center" name="navegacion" value="actualizar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>   
                    <a  href="eliminarproducto.php?id=<?php echo $usu['id_producto']?>" class="elimi" style="text-decoration:none"><button class="btn  border border-secundary text-center "  style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F78181; margin-top:0.4rem " > <img style="width:1rem; heigth:auto" src="imagenes/eliminar.svg" alt="">  Borrar </button></a>  
                    
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


   
<?php } elseif($_actualización== True){ ?>

    <div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 border border-secondary">
            <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">ACTUALIZAR PRODUCTO</h3>
            <br>
            <?php include("config/bd.php"); ?>
            <form class="row g-3 formulario" method="POST" action="productos.php" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-file">
                                <div class="form-file__action">
                                    <input type="file" name="image" id="image"/>
                                </div>
                                <div class="form-file__result" id="result-image">
                                    <img id="img-result" alt="" src="imagenes/productos/<?php echo $producto['imagen_po']?>"/>
                                </div>
                            </div>  
                          </div>
                          <div class="col-md-6">
                          <div class="container d-block">
                            <br><br>
                                  <div class="col-md-12"> 
                                        <label for="inputAddress" class="form-label">Nombre Producto</label>
                                        
                                        <input type="text" minlength="5" value="<?php echo $producto['nombre_producto']?>" class="form-control " id="nombre" name="nombreproducto" placeholder="Ingrese el nombre del producto" required>
                                  </div><br>
                                  <div class="col-md-12">
                                        <div class="container">
                                        <div class="row">
                                        <div class="col-md-3">
                                            <label for="inputAddress" class="form-label"> Precio $</label>
                                        </div>
                                      <div class="col-md-9">
                                        <input type="number" step="0.01" min="1" class="form-control " value="<?php echo $producto['precio_pro']?>" id="precio" name="precio" placeholder="Ingrese precio del producto" required>
                                        </div>
                                        </div>     
                                  </div>
                          </div><br>
                          <div class="col-md-12">
                            <div class="container">
                            <div class="row">
                            <div class="col-md-3">
                                <label for="inputAddress" class="form-label"> stock</label>
                            </div>
                          <div class="col-md-9">
                            <input type="number" class="form-control " min="1" id="stock" value="<?php echo $producto['cantidad_disp']?>" name="stock" placeholder="Cantidad disponible" required>
                            </div>
                            </div>     
                      </div>
              </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label"> Fecha elaboración:</label>
                            <?php date_default_timezone_set('America/Bogota');
                            $fecha= new Datetime();
                            $fechaa=$fecha->format("Y-m-d");                           
                            ?>
                            <input type="date" id="start" name="elaboracion" value="<?php echo $producto['fecha_elaboracion']?>" min="2019-01-01" max="<?php echo $fechaa; ?>" style="width: 15rem; font-size: 1.3rem;" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label"> Fecha vencimiento:</label>
                            <input type="date" id="start" name="vencimiento" value="<?php echo $producto['fecha_vencimiento']?>" min="<?php echo $fechaa; ?>" max="2026-12-31" style="width: 15rem; font-size: 1.3rem;" required>
                        </div>
                    </div>
                </div><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                        <?php include("config/bd.php");
                            $sqlm = "SELECT *FROM sub_categorias";
                            $consultarsub = $conexion->prepare($sqlm);
                            $consultarsub->execute();
                            $counta= $consultarsub->rowCount();
                            if($counta >0) {
                                $subcategorrias=$consultarsub->fetchAll();
                            }?>
                            <label for="country" class="form-label">Subcategoría</label>
                            <select disabled class="form-select" id="country" name="subcategoria" required>
                            <?php foreach($subcategorrias as $scat):?>
                            <option name="opcion" value="<?php echo$producto['id_sub_cat']?>"><?php echo $producto['nombre_sub_ca']?></option>
                            <?php endforeach;?>
                            
                            </select>
                        </div>
                        <div class="col-md-6">
                        <?php include("config/bd.php");
                            $sql = "SELECT *FROM proveedores";
                            $consult = $conexion->prepare($sql);
                            $consult->execute();
                            $coun= $consult->rowCount();
                            if($coun >0) {
                                $proveedor=$consult->fetchAll();
                            }?>
                            <label for="country" class="form-label">Proveedores</label>
                            <select class="form-select" id="country" name="proveedor" required>
                            <option name="opcion" value="<?php echo$producto['id_proveedores']?>"><?php echo$producto['nombre_pro']?></option>
                            <?php foreach($proveedor as $pro):
                                if($pro['id_proveedores']!= $producto['id_proveedores']){ ?>
                            <option name="opcion" value="<?php echo$pro['id_proveedores']?>"><?php echo$pro['nombre_pro']?></option>
                            <?php  } ?>
                            <?php endforeach;?>
                            </select>
                        </div> 
                    </div>
                </div>
                <br>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                        <input type="text" name="producto" value="<?php echo$producto['id_producto']?>" hidden >
                        <button type="submit" class="btn bton" name="modificarbase" value="actualizarpro">Actualizar</button> 
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                </div>        
              </form>

        </div>
        <div class="col-md-2"></div>
    </div>
</div>


<?php } ?>
<br><br><br><br><br><br>
<script>
    $('.elimi').on('click', function(e) {
        e.preventDefault();
        const href= $(this).attr('href')
        Swal.fire({
            title: 'Está seguro de borrar el producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, borrar'
        }).then((result) => {
            if (result.value ) {
                document.location.href= href;

                    
            }else{
                
            }
        })
    })
    
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="tabla.js"></script>
<script type="text/javascript" src="productos.js"></script>

<?php include("plantillas/footer.php"); ?>
