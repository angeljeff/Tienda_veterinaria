
<?php include("plantillas/encabezado.php"); ?>
<?php
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;
if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==2){?>
    <script>
      window.location.href = "<?php echo $url;?>/login.php";
    </script>
    <?php
   
    die();
}
else{

    include("config/bd.php");
    $sqlm = "SELECT *FROM factura where cedula=$cedula_sesion and id_estado_factura=1";
    $consultarcat = $conexion->prepare($sqlm);
    $consultarcat->execute();
    $count= $consultarcat->rowCount();

    if($count >0) {
        $categorriasss=$consultarcat->fetch();
        $actualizacion=True;

    }
    else{
        $ced=$cedula_sesion; $est=1; $pag=1;
        include("config/bd.php");
        $insertarpro= $conexion->prepare("INSERT INTO factura (cedula, id_estado_factura, id_pago) VALUES (:pro, :est, :p);");
        $insertarpro->bindParam(':pro',$ced);
        $insertarpro->bindParam(':est',$est);
        $insertarpro->bindParam(':p',$pag);
        $insertarpro->execute();
        $sqlm = "SELECT *FROM factura where cedula=$cedula_sesion and id_estado_factura=1";
        $consultarcat = $conexion->prepare($sqlm);
        $consultarcat->execute();
        $count= $consultarcat->rowCount();
        if($count >0) {
            
            $categorrias=$consultarcat->fetch();
            $cantidad= $_POST['quantity']; $precio= $_POST['precio_p']; $id_pro= $_POST['idpro']; $fact=$categorrias['id_factura'];
            $total=$cantidad*$precio;
            $insertarp= $conexion->prepare("INSERT INTO prod_por_factura (cantidad, precio_p, total_pro, id_producto, id_factura ) VALUES (:pro, :est, :t ,:id, :ifa);");
            $insertarp->bindParam(':pro',$cantidad);
            $insertarp->bindParam(':est',$precio);
            $insertarp->bindParam(':t',$total);
            $insertarp->bindParam(':id',$id_pro);
            $insertarp->bindParam(':ifa',$fact);
            $insertarp->execute();?>
            <script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Producto agregado',
                showConfirmButton: true,
                 showCancelButton: true,
                 
                
              confirmButtonText: 'Seguir comprando'
                }).then((result) => {
                    if (result.isConfirmed ) {
                        document.location.href="<?php echo $url ?>/index.php";
        
                            
                    }else{
                        document.location.href="<?php echo $url ?>/carrito.php";
                        
                    }
                })
            </script>
            <?php
            
            
    
        }
    
    }
    


}




if((isset($_POST['carrito']))!="" and $actualizacion==True){
    ?>
    <script>
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Producto agregado',
        showConfirmButton: true,
         showCancelButton: true,
         
        
      confirmButtonText: 'Seguir comprando'
        }).then((result) => {
            if (result.isConfirmed ) {
                document.location.href="<?php echo $url ?>/index.php";

                    
            }else{
                document.location.href="<?php echo $url ?>/carrito.php";
                
            }
        })
    </script>
     <?php 
    $sqlm = "SELECT *FROM factura where cedula=$cedula_sesion and id_estado_factura=1";
    $consultarcat = $conexion->prepare($sqlm);
    $consultarcat->execute();
    $count= $consultarcat->rowCount();
    if($count >0) {
        $categorrias=$consultarcat->fetch();
        $cantidad= $_POST['quantity']; $precio= $_POST['precio_p']; $id_pro= $_POST['idpro']; $fact=$categorrias['id_factura'];
        $total=$cantidad*$precio;
        $insertarp= $conexion->prepare("INSERT INTO prod_por_factura (cantidad, precio_p, total_pro, id_producto, id_factura ) VALUES (:pro, :est, :t ,:id, :ifa);");
        $insertarp->bindParam(':pro',$cantidad);
        $insertarp->bindParam(':est',$precio);
        $insertarp->bindParam(':t',$total);
        $insertarp->bindParam(':id',$id_pro);
        $insertarp->bindParam(':ifa',$fact);
        $insertarp->execute();

    } 


  
   
}
else{
    
}

$click=(isset($_POST['accion']))?$_POST['accion']:"";
switch($click){
    case "borrar":
        $id=$_POST['eliminar'];
        $eliminar= $conexion->prepare("DELETE FROM prod_por_factura where id_pro_fac=$id;");
        $eliminar->execute();

    break;
    case "cancelar":
        $idc=$categorriasss['id_factura'];
        $estado=2;
        $eliminar= $conexion->prepare("UPDATE factura SET id_estado_factura=:esta WHERE id_factura=$idc");
        $eliminar->bindParam(':esta',$estado);
        $eliminar->execute(); ?>
        <script>
            document.location.href="<?php echo $url ?>/index.php";
        </script>
    <?php

    break;
    case "pedido":?>
        <script>
            document.location.href="<?php echo $url ?>/orden-compra.php";
        </script>
    <?php
        
    
    break;

    }

?>
<br>
<h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">CARRITO DE COMPRAS</h3>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="table-responsive">
            <table id="example"class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th scope="col">Imagen</th>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
                <th scope="col">Total</th>
                <th scope="col">Accion</th>

                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                if (isset($categorriasss['id_factura'])) {
                    $idfac=$categorriasss['id_factura'];

                }else{
                    $idfac=$categorrias['id_factura'];
                }
                
                $sqlx = "SELECT p.id_producto, p.id_pro_fac, p.cantidad, p.precio_p, p.total_pro, s.nombre_producto, s.imagen_po FROM prod_por_factura as p INNER JOIN productos as s ON p.id_producto= s.id_producto INNER JOIN factura as f ON p.id_factura= f.id_factura  where p.id_factura=$idfac and f.id_estado_factura=1";
                $consultarproducto = $conexion->prepare($sqlx);
                $consultarproducto->execute();
                $countv= $consultarproducto->rowCount();
                if($countv >0) {
                    $product=$consultarproducto->fetchAll();
                    foreach($product as $usu):  ?>
                        <tr>
                        <td class="text-center"><img src="imagenes/productos/<?php echo $usu['imagen_po']?>" style="width:10rem; height:auto" alt=""> </td>
                        <td style="vertical-align:middle"><?php echo$usu['nombre_producto']?></td>
                        <td style="vertical-align:middle"><?php echo$usu['cantidad']?></td>
                        <td style="vertical-align:middle">$ <?php echo $usu['precio_p']?></td>
                        <td style="vertical-align:middle">$ <?php echo $usu['total_pro']?></td>

                        <td class="text-center" style="vertical-align:middle">
                        <form action="" method="POST">
                        <input type="text" name="eliminar" value="<?php echo $usu['id_pro_fac']?>" hidden>
                        <a  href="eliminarproductocarrito.php?id=<?php echo $usu['id_pro_fac']?>" class="elimi" style="text-decoration:none"><button class="btn  border border-secundary text-center" name="accio" value="borrar" id="borrar" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F78181; margin-top:0.4rem " > <img style="width:1rem; heigth:auto" src="imagenes/eliminar.svg" alt="">  Borrar </button></a>


                        </form>
                        </td>

                        </tr>

                    <?php endforeach;
                }    ?>


            </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <div class="container">
             <div class="row">
                 <div class="col-md-4">
                     <form action="" method="POST">
                     
                        <input type="text" name="eliminartodo" value="<?php echo $idfac?>" hidden>
                    <button type="submit" class="btn bton" style="font-size:1.3rem !important;  background:#F78181; "name="accion" value="cancelar">  Cancelar Todo   </button>
                    </form>
                 </div>
                 <div class="col-md-5"></div>
                 <div class="col-md-3 ">
                 <form action="" method="POST">
                 <?php if($countv >0){ ?>
                    <a href="orden-compra.php?id=<?php echo $idfac?>"><button type="button" class="btn bton" style="font-size:1.3rem !important; background:#04B45F;"name="accion" >Continuar Pedido</button></a>
                    <?php }else{ ?>
                    <button disabled type="submit" class="btn bton" style="font-size:1.3rem !important; background:#04B45F;" name="accion" >Continuar Pedido</button>
                    
                    <?php } ?>
                </form>
                 </div>
             </div>
         </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br>
</div>

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
            confirmButtonText: 'si'
        }).then((result) => {
            if (result.value ) {
                document.location.href= href;

                    
            }else{
                
            }
        })
    })
    
</script>