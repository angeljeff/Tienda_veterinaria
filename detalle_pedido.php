<?php include("plantillas/encabezado.php"); ?>
<?php ob_start();?>
  <?php
 $cedula_sesion= $_SESSION['usuario'][0];
 $nombre_sesion= $_SESSION['usuario'][1];
 $tipo_sesion= $_SESSION['usuario'][2];
 $actualizacion=false;
 if($tipo_sesion== null || $tipo_sesion=="" ){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
     
     die();
 }?> 
  <?php
$_id=$_GET['id'];
$mostrarcomprobante=false;
$click=(isset($_POST['ver']))?$_POST['ver']:"";
switch($click){
    case "mostrar":
        $mostrarcomprobante=true;
    break;
    case "ocultar":
        $mostrarcomprobante=false;
    break;
}

?>
<br>
<div class="container">
<div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-4"></div>
    <div class="col-md-2">
        <form action="" method="post">
            <a  href="repor_pdf.php?id=<?php echo $_id?> " target="_blank" rel="noopener noreferrer" class="redirigir" style="text-decoration:none"><button class="btn  border border-secundary text-center "  style="width:10rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " > Visualizar en PDF </button></a>    
        </form>

        
    </div>
</div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-2">
        <a href="reportes.php" id="volver"><button class="btn  border border-secundary text-center "   style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " ><img style="width:1.1rem; heigth:auto" src="imagenes/volver.svg" alt="">  volver </button></a>   

        </div>
        <div class="col-lg-8">
        <h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">DETALLE DEL PEDIDO</h3>
        </div>

        
    </div>
</div>
<br><br>

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
                if($_id!=""|| $_id!=0 || $_id!=null ){

                    $total_final= 0;
                    $subtotal=0;
                    $iva=0;
                    $sqlx = "SELECT p.id_producto, p.id_pro_fac, p.cantidad, p.precio_p, p.total_pro, s.nombre_producto, s.imagen_po FROM prod_por_factura as p INNER JOIN productos as s ON p.id_producto= s.id_producto INNER JOIN factura as f ON p.id_factura= f.id_factura  where p.id_factura=$_id ";
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
            $sqlx = "SELECT cedula, imagen_comp FROM factura  where id_factura=$_id ";
            $consultarcedula = $conexion->prepare($sqlx);
            $consultarcedula->execute();
            $countv= $consultarcedula->rowCount();
            if($countv >0) {
                $usuariofactura=$consultarcedula->fetch();
                $_cedula=$usuariofactura['cedula'];
                $sqlma = "SELECT  *FROM usuarios where cedula=:cedu ";
                $cons = $conexion->prepare($sqlma);
                $cons->bindParam(':cedu',$_cedula);
                $cons->execute();
                $countc= $cons->rowCount();
                if($countc >0) {
                 $pago=$cons->fetch(); ?>
                 <div class="row">
                 <div class="col-lg-12">
                         <h4> Datos del cliente</h4>
                     </div>
                     <div class="col-md-12">
                     <div class="row">
                             <div class="col-12">
                             <strong><label for="inputCity" class="form-label">Cliente:</label></strong>
                             <input type="text"   class="form-control"  value="<?php echo$pago['nombres']?> <?php echo$pago['apellidos']?>" required  disabled>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-lg-6">
                             <div class="col-12">
                             <strong><label for="inputAddress" class="form-label"># Cedula</label></strong>
                             <input type="text"  class="form-control " value="0<?php echo$pago['cedula']?>"  required disabled>
                             </div>
                             </div>
                             <div class="col-lg-6">
                             <div class="col-12">
                             <strong><label for="inputAddress2" class="form-label">Correo electrónico</label></strong>
                             <input type="text"  class="form-control"  value="<?php echo$pago['correo']?>" required disabled>
                             </div>
                             </div>
                         </div>
                         </div>

                     </div>
                     <br><hr>
            



                 </div>
                    
            <?php    }
                    

               } ?>
        </div>
    </div>
    <br>

    <div class="row ">
        <div class="col-lg-4"></div>
        <div class="col-lg-3"></div>
        <div class="col-lg-5">
            <div class="row ">
                <div class="col-md-5 text-start">
                    <h4> Comprobante de pago</h4>
                </div>
                <div class="col-md-4 ">
                <form action="" method="POST">
                <?php if($mostrarcomprobante==false){ ?>
                    <button class="btn  border border-secundary text-center" name="ver" value="mostrar" style="width:5.6rem; font-size: 1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0rem " > <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""> Ver </button></a>  
                    <?php }else{ ?>
                     <button class="btn  border border-secundary text-center" name="ver" value="ocultar" style="width:6rem; font-size: 1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0rem " > <img style="width:1rem; heigth:auto" src="imagenes/ojito.svg" alt=""> ocultar </button></a>  
                    
                        <?php } ?>
                </form>
                </div>
                <div class="col-md-3">
                </div>

                
                <?php if($mostrarcomprobante==true){ ?>
                    <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 text-center">
                            <img src="imagenes/comprobantepago/<?php echo $usuariofactura['imagen_comp']?>" style="width:auto; height:25rem" alt=""> 
                        </div>
                        <div class="col-lg-8"></div>
                    </div>
                </div>
                <?php } ?>

                



            </div>
        </div>
    </div>
</div>

<script>
    $('.volver').on('click', function(e) {
        e.preventDefault();
        const href= $(this).attr('href')
        document.location.href= href;
        

    })
    

</script>
<script>
    $('.redirigir').on('click', function(e) {
        e.preventDefault();
        
        const href= $(this).attr('href',)
        window.open(href)
        /* document.location.href= href; */
        

    })
    



</script>

        
<?php ob_end_flush(); ?>

<br><br><br><br><br><br><br>








<?php include("plantillas/footer.php"); ?>
