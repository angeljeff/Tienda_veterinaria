<?php include("plantillas/encabezado.php"); 
 ob_start();
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;

if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==2){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
    
    die();
}
?>


<?php include("config/bd.php"); 

?>

<br><br>
<h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">ORDEN DE COMPRA</h3>
<br>
<div class="container">
    <div class="row">
        <div class="col md-6 ">
            <div class="row">
                <div class="col-lg-12">
                    <h4> Detalle de los productos</h4>
                </div>
                <div class="col-lg-12">
                <div class="table-responsive">
                <table id="example"class="table table-striped table-hover table-bordered">
                <thead style="background-color: #7FB3D5 ">
                    <tr class="text-center">
                    <th scope="col" >producto</th>
                    <th scope="col">cantidad</th>
                    <th scope="col">precio</th>
                    <th scope="col">total</th>

                    </tr>
                </thead>
                <tbody style="background-color: #82E0AA ">
                <?php include("config/bd.php");
                $sql = "SELECT id_factura FROM factura where cedula=:ced and id_estado_factura=1";
                $consultarf = $conexion->prepare($sql);
                $consultarf->bindParam(':ced',$cedula_sesion);
                $consultarf->execute();
                $countb= $consultarf->rowCount();
                if($countb >0) {
                    $productc=$consultarf->fetch(); 
                    $idfac= $productc['id_factura'];
                    $total_final= 0;
                    $subtotal=0;
                    $iva=0;
                    $sqlx = "SELECT p.id_producto, p.id_pro_fac, p.cantidad, p.precio_p, p.total_pro, s.nombre_producto, s.imagen_po FROM prod_por_factura as p INNER JOIN productos as s ON p.id_producto= s.id_producto INNER JOIN factura as f ON p.id_factura= f.id_factura  where p.id_factura=$idfac and f.id_estado_factura=1";
                    $consultarproducto = $conexion->prepare($sqlx);
                    $consultarproducto->execute();
                    $countv= $consultarproducto->rowCount();
                    if($countv >0) {
                        $product=$consultarproducto->fetchAll(); 
                        $limite= sizeof($product);

                        foreach($product as $usu):  ?>
                            <tr>
                            
                            <td style="vertical-align:middle"><?php echo$usu['nombre_producto']?></td>
                            <td class="text-center" style="vertical-align:middle"><?php echo$usu['cantidad']?></td>
                            <td class="text-center" style="vertical-align:middle">$ <?php echo $usu['precio_p']?></td>
                            <td class="text-center" style="vertical-align:middle">$ <?php echo $usu['total_pro']?></td>

                            </tr>
                        <?php  $subtotal= $subtotal+$usu['total_pro']; 
                       /*  $tabla[]='{id:"'.$usu['id_producto'].'", cantidad:'.$usu['cantidad'].'},'; */
                       $tabla[]= [$usu['id_producto'],$usu['cantidad']];
                       ?>

                        <?php endforeach;
                    $iva=0.12*$subtotal;
                    $total_final=$subtotal+$iva;
                    }else{?>
                        <script>
                          window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/index.php";
                          
                        </script>
                        <?php
                        

                    }  
                }
                else{?>
                    <script>
                      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/index.php";
                      
                    </script>
                    <?php
                    
              
                    die();
                  }  ?>


                </tbody>
                </table>
            </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-8 text-end">
                    <strong><label style="font-size:1.2rem;"> SubTotal</label></strong>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2 text-center">
                    <label style="font-size:1.2rem;"> $ <?php echo  $subtotal; ?></label>
                    </div>
                    <div class="col-md-8 text-end">
                    <strong><label style="font-size:1.2rem;"> Iva(12%)</label></strong>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2 text-center">
                    <label style="font-size:1.2rem;"> $ <?php echo  $iva; ?></label>
                    </div>
                    <div class="col-md-8 text-end">
                    <strong><label style="font-size:1.2rem;"> Total</label></strong>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2 text-center">
                    <label style="font-size:1.2rem;"> $ <?php echo  $total_final; ?></label>
                    </div>
                </div>
            </div>

            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col md-4 ">
        <?php include("config/bd.php");
            $sqlma = "SELECT p.id_pago, p.tipo_cuenta, p.titular_cuenta, p.cedula_titular, p.id_banco, b.nombre_banco, p.numero_cuenta FROM pago AS p INNER JOIN bancos AS b ON p.id_banco= b.id_banco ";
            $cons = $conexion->prepare($sqlma);
            $cons->execute();
            $countc= $cons->rowCount();
            if($countc >0) {
                $pago=$cons->fetchAll();
               
            }
            ?>
            <div class="row">
            <div class="col-lg-12">
                    <h4> Datos para el pago</h4>
                </div>
            <?php foreach($pago as $p):?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="col-12">
                        <strong><label for="inputAddress" class="form-label">Banco</label></strong>
                        <input type="text"  class="form-control " value="<?php echo$p['nombre_banco']?>"  required disabled>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="col-12">
                        <strong><label for="inputAddress2" class="form-label">Tipo cuenta</label></strong>
                        <input type="text"  class="form-control"  value="<?php echo$p['tipo_cuenta']?>" required disabled>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="col-12">
                        <strong><label for="inputAddress" class="form-label"> Número cuenta</label></strong>
                        <input type="text" minlength="5" class="form-control " value="<?php echo$p['numero_cuenta']?>"   required disabled>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="col-12">
                        <strong><label for="inputAddress2" class="form-label">Cedula titular</label></strong>
                        <input type="text"  class="form-control"   value="<?php echo$p['cedula_titular']?>"  disabled>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <strong><label for="inputCity" class="form-label">Titular de la cuenta</label></strong>
                        <input type="text"   class="form-control"  value="<?php echo$p['titular_cuenta']?>" required  disabled>


                        </div>
                    </div>

       
                <br>
                </div>
                <br><hr>
                <?php endforeach;?>
                <br>
 <?php 
$clicke=(isset($_POST['solicitar']))?$_POST['solicitar']:"";
switch($clicke){
    case "pedido":
        if($_FILES['image']["name"]!=""){ 
            $fecha= new DateTime();
            $nombrearchivo=$fecha->getTimestamp()."_".$_FILES["image"]["name"];
            $ima=$_FILES["image"]["tmp_name"];
            include("config/bd.php");
            $estado_f=3;
             date_default_timezone_set('America/Bogota');
            $fecha= new Datetime();
            $fechaa=$fecha->format("Y-m-d");                           
            
            $insertarpub= $conexion->prepare("UPDATE factura set imagen_comp=:imag , total_factura=:tot, id_estado_factura=:id_es, fecha=:fe where id_factura=:id_facr");
            $insertarpub->bindParam(':id_facr',$idfac);
            $insertarpub->bindParam(':imag',$nombrearchivo);
            $insertarpub->bindParam(':fe',$fechaa);
            if($ima!=""){
                move_uploaded_file($ima,"imagenes/comprobantepago/".$nombrearchivo);
               
               
            }
            $insertarpub->bindParam(':tot', $total_final);
            $insertarpub->bindParam(':id_es',$estado_f);
            $insertarpub->execute();
            for ($i=0; $i<$limite; $i++){
                $id_pro=$tabla[$i][0];
                $canti=$tabla[$i][1];
                $consultarp= $conexion->prepare("SELECT *FROM productos WHERE  id_producto= :id "); 
                $consultarp->bindParam(':id',$id_pro);                   
                $consultarp->execute();
                $_count = $consultarp->rowCount();
                if($_count > 0 ){
                    $_datusuario= $consultarp->fetch();
                    $nuevo_stock=$_datusuario['cantidad_disp'] - $canti;
                    $ventas=$_datusuario['unidades_vendidas'] + $canti;
                    $datopro= $conexion->prepare("UPDATE productos SET cantidad_disp=:c, unidades_vendidas=:u WHERE id_producto= :id");
                    $datopro->bindParam(':id',$id_pro);
                    $datopro->bindParam(':c',$nuevo_stock);
                    $datopro->bindParam(':u',$ventas);
                    $datopro->execute();?>
                    <script> 
                    Swal.fire({
                    title: 'pedido realizado con éxito',
                    text: "********",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK'
                    }).then((result) => {
                    if (result.isConfirmed) {}
                        window.location.href = "<?php echo $url;?>/reportes.php";
                    })
                     </script>
                    
                    <?php    
                }

                
                
               }

            

        }
        else{ ?>
            <script>
          
            Swal.fire("Necesita subir el comprobante de pago");
      
    </script>
        <?php 
        }

        break;
    
    }  
    ?>

            </div>
            
        </div>
    </div>
    <br>

    <div class="row ">
    <form action="orden-compra.php" method="POST" enctype="multipart/form-data">
        <div class="row  ">
        <div class="col-12 text-end">
        
            <h4> Sube el comprobante de pago</h4><br>
        </div>
        <div class="col-12 form-file  align-items-end">

                <input  type="file" name="image">
        </div>
        <div class="col-12 text-center">
        <button type="submit" class="btn bton" name="solicitar" value="pedido">Realizar pedido </button> 

        </div>

        </div>
    </form>
    </div>
</div>


<?php ob_end_flush(); ?>
<?php include("plantillas/footer.php"); ?>