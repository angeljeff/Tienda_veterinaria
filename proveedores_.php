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
         $sqlb = "SELECT * FROM proveedores where id_proveedores=$id_producto";
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

        $_nombrepro= $_POST['nombreproveedor']; $_contacto= $_POST['contacto']; $_stock= $_POST['telefono'];  $id_sub= $_POST['subcategoria'];$id_pro= $_POST['correo'];
        $insertar= $conexion->prepare("INSERT INTO proveedores (nombre_pro, contacto, telefono_pro , id_categoria, correo) VALUES (:nomb, :precio, :cant,  :sub, :est);");
        $insertar->bindParam(':nomb',$_nombrepro);
        $insertar->bindParam(':precio',$_contacto);
        $insertar->bindParam(':cant',$_stock);
        $insertar->bindParam(':sub',$id_sub);
        $insertar->bindParam(':est', $id_pro);
        $insertar->execute();

      
         break;  
     case "actualizarpro":
         include("config/bd.php");

        $_nombrepro= $_POST['nombreproveedor']; $_precio= $_POST['contacto']; $_stock= $_POST['telefono']; $id_pro= $_POST['correo']; $id_produ= $_POST['producto'];
        $insertar= $conexion->prepare("UPDATE proveedores SET  nombre_pro=:nomb, contacto=:precio, telefono_pro=:cant, correo=:pro WHERE id_proveedores=$id_produ ");
        $insertar->bindParam(':nomb',$_nombrepro);
        $insertar->bindParam(':precio',$_precio);
        $insertar->bindParam(':cant',$_stock);
        $insertar->bindParam(':pro',$id_pro);
        $insertar->execute();
    ?>
         <script>
         Swal.fire({
 
         icon: 'success',
         title: 'Proveedores actualizado correctamente',
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
 
 
 
 <br>
 <div class="container text-center">
     <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
             <form action="proveedores_.php" method="POST">
         <div class="btn-group" role="group" aria-label="Basic mixed styles example">
         <button type="submit" class="btn btn-outline-dark" style="width:10rem; heigth:auto ; background-color:#F2F5A9" name="navegacion" value="nuevo" >Nuevo proveedor</button>
         <button type="submit" class="btn btn-outline-dark" style="width:10rem; heigth:auto ; background-color:#81BEF7" name="navegacion" value="listado">Mis proveedores</button>
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
         <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">REGISTRO DE PROVEEDORES</h3>
             <br>
             <form class="row g-3 formulario" method="POST" action="proveedores_.php" enctype="multipart/form-data">
                 <div class="container">
                     <div class="row">
                           <div class="col-md-12">
                           <div class="container d-block">
                             <br>
                                <div class="row">
                                <div class="col-md-1"></div>    
                                 <div class="col-md-10"> 
                                    <strong><label for="inputAddress" class="form-label">Nombre Proveedor:</label></strong>
                                    <input type="text" minlenght="5" class="form-control " id="nombre" name="nombreproveedor" placeholder="Ingrese el nombre del proveedor" required>
                                <br>
                                </div>
                                <div class="col-md-1"></div><br>
                                </div>
                                <div class="row">
                                <div class="col-md-1"></div>    
                                 <div class="col-md-10"> 
                                    <strong><label for="inputAddress" class="form-label">Persona contacto:</label></strong>
                                    <input type="text" minlenght="5" class="form-control " id="nombre" name="contacto" placeholder="Ingrese el nombre de la persona de contacto" required>
                                <br>
                                </div>
                                <div class="col-md-1"></div><br>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    
                                    <div class="col-md-10">
                                    <?php include("config/bd.php");
                                        $sqlm = "SELECT *FROM categorias";
                                        $consultarsub = $conexion->prepare($sqlm);
                                        $consultarsub->execute();
                                        $counta= $consultarsub->rowCount();
                                        if($counta >0) {
                                            $subcategorrias=$consultarsub->fetchAll();
                                        }?>
                                        <strong><label for="country" class="form-label">Productos que ofrece:</label></strong>
                                        <select class="form-select" id="country" name="subcategoria" required>
                                        <?php foreach($subcategorrias as $scat):?>
                                        <option name="opcion" value="<?php echo$scat['id_categoria']?>"><?php echo$scat['nombre_cat']?></option>
                                        <?php endforeach;?>
                                        
                                        </select>
                                        <br>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                             <strong><label for="inputAddress" class="form-label"> Telefóno:</label></strong>
                                             <input  type="text"  pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control " id="precio" name="telefono" placeholder="Ingrese el telefóno" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-10">
                                             <strong><label for="inputAddress" class="form-label"> Correo electrónico:</label></strong>
                                             <input type="email"  class="form-control " id="precio" name="correo" placeholder="Ingrese el correo" required>
                                             
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div><br>
                                    </div>
                                </div>
               </div>
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
 <br><br><br><br><br><br><br>
 <?php }elseif($_listadopro== True){  ?>
 
 
 <div class="container-fluid">
     <div class="row">
         <div class="col-md-1"></div>
         <div class="col-md-10">
             <div class="table-responsive">
             <table id="example"class="table table-striped table-hover table-bordered">
             <thead style="background-color: #7FB3D5 ">
                 <tr class="text-center">
                 
                 <th scope="col" >Proveedor</th>
                 <th scope="col">Contacto</th>
                 <th scope="col">Correo</th>
                 <th scope="col">Telefono</th>
                 <th scope="col">Acciones</th>
                 </tr>
             </thead>
             <tbody style="background-color: #82E0AA ">
             <?php include("config/bd.php"); 
                 $sqlx = "SELECT * FROM proveedores";
                 $consultarproducto = $conexion->prepare($sqlx);
                 $consultarproducto->execute();
                 $countv= $consultarproducto->rowCount();
                 if($countv >0) {
                     $product=$consultarproducto->fetchAll();
                 }      
                 foreach($product as $usu):  ?>
                     <tr>
                     <td style="vertical-align:middle"><?php echo$usu['nombre_pro']?></td>
                     <td style="vertical-align:middle"><?php echo$usu['contacto']?></td>
                     <td style="vertical-align:middle"><?php echo $usu['correo']?></td>
                     <td style="vertical-align:middle"><?php echo $usu['telefono_pro']?></td>
                     <td class="text-center" style="vertical-align:middle">
                     <form action="" method="POST">
                     <input type="text" name="editar" value="<?php echo $usu['id_proveedores']?>" hidden>
                     <button type="submit" class="btn  border border-secundary text-center" name="navegacion" value="actualizar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F9E79F  "> <img style="width:1rem; heigth:auto" src="imagenes/pencil-outline.svg" alt="">  Editar</button>   
                     <!-- <a  href="eliminarproducto.php?id=<?php echo $usu['id_producto']?>" class="elimi" style="text-decoration:none"><button class="btn  border border-secundary text-center "  style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F78181; margin-top:0.4rem " > <img style="width:1rem; heigth:auto" src="imagenes/eliminar.svg" alt="">  Borrar </button></a>   -->
                     
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
         <div class="col-md-8 border border-secondary" style="box-shadow: 0px 2px 3px 6px #D5E1DF ;border-radius:0.3rem;">
             <br>
         <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">ACTUALIZACIÓN DE PROVEEDOR</h3>
             <br>
             <form class="row g-3 formulario" method="POST" action="proveedores_.php" enctype="multipart/form-data">
                 <div class="container">
                     <div class="row">
                           <div class="col-md-12">
                           <div class="container d-block">
                             <br>
                                <div class="row">
                                <div class="col-md-1"></div>    
                                 <div class="col-md-10"> 
                                    <strong><label for="inputAddress" class="form-label">Nombre Proveedor:</label></strong>
                                    <input type="text" minlenght="5" class="form-control " id="nombre" value="<?php echo $producto['nombre_pro']?>" name="nombreproveedor" value="<?php echo $producto['nombre_producto']?>" placeholder="Ingrese el nombre del proveedor" required>
                                <br>
                                </div>
                                <div class="col-md-1"></div><br>
                                </div>
                                <div class="row">
                                <div class="col-md-1"></div>    
                                 <div class="col-md-10"> 
                                    <strong><label for="inputAddress" class="form-label">Persona contacto:</label></strong>
                                    <input type="text" minlenght="5" class="form-control " id="nombre" name="contacto" value="<?php echo $producto['contacto']?>" placeholder="Ingrese el nombre de la persona de contacto" required>
                                <br>
                                </div>
                                <div class="col-md-1"></div><br>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    
                                    <div class="col-md-10">
                                    <?php include("config/bd.php");
                                        $sqlm = "SELECT *FROM categorias";
                                        $consultarsub = $conexion->prepare($sqlm);
                                        $consultarsub->execute();
                                        $counta= $consultarsub->rowCount();
                                        if($counta >0) {
                                            $subcategorrias=$consultarsub->fetchAll();
                                        }?>
                                        <strong><label for="country" class="form-label">Productos que ofrece:</label></strong>
                                        <select disabled class="form-select" id="country" name="subcategoria" required>
                                        <?php foreach($subcategorrias as $scat):
                                            if($scat['id_categoria']==$producto['id_categoria']){?>
                                        <option name="opcion" value="<?php echo$scat['id_categoria']?>"><?php echo$scat['nombre_cat']?></option>
                                        <?php } endforeach;?>
                                        
                                        </select>
                                        <br>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                             <strong><label for="inputAddress" class="form-label"> Telefóno:</label></strong>
                                             <input type="text"  pattern="[0-9]{10}" minlength="10" maxlength="10"  class="form-control " value="<?php echo $producto['telefono_pro']?>" id="precio" name="telefono" placeholder="Ingrese el telefóno" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-10">
                                             <strong><label for="inputAddress" class="form-label"> Correo electrónico:</label></strong>
                                             <input type="email"  class="form-control " id="precio" value="<?php echo $producto['correo']?>"  name="correo" placeholder="Ingrese el correo" required>
                                             
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div><br>
                                    </div>
                                </div>
               </div>
                         </div>
                     </div>
                 </div>
                 <br><br>
                 <div class="container">
                     <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4 text-center">
                         <input type="text" name="producto" value="<?php echo $producto['id_proveedores']?>" hidden >
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
 <br><br><br><br><br><br><br><br>
 
 
 <?php } ?>

 
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
 
 <?php include("plantillas/footer.php"); ?>