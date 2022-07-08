<?php include("plantillas/encabezado.php");
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
if ($tipo_sesion==1){ ?>
<br>
<h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">MIS PEDIDOS</h3>
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <br>
            <?php include("config/bd.php");
                $sqlm = "SELECT f.id_factura, f.imagen_comp,f.comentario, f.total_factura, f.cedula, f.id_estado_factura , f.id_pago, esf.descripcion FROM factura as f INNER JOIN  estado_factura as esf on f.id_estado_factura = esf.id_estado_factura where f.cedula=:ced ";
                $consultarfac = $conexion->prepare($sqlm);
                $consultarfac->bindParam(':ced',$cedula_sesion);    
                $consultarfac->execute();
                $count= $consultarfac->rowCount();
                if($count >0) {
                    $pedidos=$consultarfac->fetchAll();?>
            <div class="table-responsive">
            <table id="example" class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">ID</th>
                <th  scope="col">Comprobante</th>
                <th  scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Detalle</th>
                <th scope="col">Observaciones</th>
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">

                    <?php foreach($pedidos as $ped):
                        if($ped['id_estado_factura']==3 || $ped['id_estado_factura']==4 || $ped['id_estado_factura']==5){?>
                       <tr class="text-center">
                       <td style="vertical-align:middle"><?php echo$ped['id_factura']?></td>
                       <td ><img src="imagenes/comprobantepago/<?php echo $ped['imagen_comp']?>" style="width:12rem; height:auto" alt=""> </td>
                       <td style="vertical-align:middle">$ <?php  echo$ped['total_factura']?></td>
                       <td style="vertical-align:middle"><?php echo$ped['descripcion']?></td>
                       <td class="text-center" style="vertical-align:middle">
                           <form action="" method="GET">
                           <a  href="detalle_pedido.php?id=<?php echo $ped['id_factura']?>" class="redirigir" style="text-decoration:none"><button class="btn  border border-secundary text-center "  style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " > <img style="width:1.2rem; heigth:auto" src="imagenes/ojito.svg" alt=""> Ver </button></a>  
                           
                           </form>
                        </td>
                        <td class="text-center" style="vertical-align:middle"><?php echo$ped['comentario']?></td>
                        
                   
                       </tr>
                       <?php } endforeach;?>
             

      
            </tbody>
            </table>
            </div>
            <?php } else{?>
            <h5 class="text-center"> NO HAS REALIZADO NINGÚN PEDIDO </h5>
            <br>
            <div class="col-lg-12 text-center">
                <a href="panelcliente.php" id="volver"><button class="btn  border border-secundary text-center "   style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " ><img style="width:1.1rem; heigth:auto" src="imagenes/volver.svg" alt="">  volver </button></a>   

            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <?php } ?>

        </div>
        <div class="col-md-2"></div>

        </div>
    </div>
    <br>
</div>
<?php } ?>
<?php
if ($tipo_sesion==2){ ?>
 <?php

$click=(isset($_POST['accion']))?$_POST['accion']:"";
switch($click){
    case "aprobar":
        $estado=4;
        $_idf= $_POST['factura'];
        $actualizar= $conexion->prepare("UPDATE factura SET  id_estado_factura=:estado WHERE id_factura=$_idf ");
        $actualizar->bindParam(':estado',$estado);
        $actualizar->execute(); ?>
        <script>
        window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/correo_pedido.php?id=<?php echo $_idf?>";
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Pedido actualizado',
            showConfirmButton: false,
            timer: 2100
         })
        </script>
    <?php
    break;
    case "rechazar":
        $estado=5;
        $_idf= $_POST['factura']; $_comentario= $_POST['observacion'];
        $actualizar= $conexion->prepare("UPDATE factura SET  id_estado_factura=:estado, comentario=:coment WHERE id_factura=$_idf ");
        $actualizar->bindParam(':estado',$estado);
        $actualizar->bindParam(':coment',$_comentario);
        $actualizar->execute();?>
        <script>
        window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/correo_pedido.php?id=<?php echo $_idf?>";
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'El Pedido ha sido rechazado',
            showConfirmButton: false,
            timer: 2100
         })
        </script>
    <?php
        
    break;
}

?>
<br><br>
<h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">PEDIDOS RECIBIDOS</h3>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <br>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th  scope="col">ID</th>
                <th  scope="col">Comprobante</th>
                <th  scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Detalle</th>
                <th scope="col">Acciones</th>
                <th scope="col">Observación</th>
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                $sqlm = "SELECT f.id_factura, f.imagen_comp,f.comentario, f.total_factura, f.cedula, f.id_estado_factura , f.id_pago, esf.descripcion, f.id_estado_factura FROM factura as f INNER JOIN  estado_factura as esf on f.id_estado_factura = esf.id_estado_factura where f.id_estado_factura!=2 and f.id_estado_factura!=1 ";
                $consultarfac = $conexion->prepare($sqlm);  
                $consultarfac->execute();
                $count= $consultarfac->rowCount();
                if($count >0) {
                    $pedidos=$consultarfac->fetchAll();
                }
                 foreach($pedidos as $ped):?>
                <tr class="text-center">
                <td style="vertical-align:middle"><?php echo$ped['id_factura']?></td>
                <td ><img src="imagenes/comprobantepago/<?php echo $ped['imagen_comp']?>" style="width:12rem; height:auto" alt=""> </td>
                <td style="vertical-align:middle">$ <?php  echo$ped['total_factura']?></td>
                <td style="vertical-align:middle"><?php echo$ped['descripcion']?></td>
                <td class="text-center" style="vertical-align:middle">
                    <form action="" method="post">
                    <a  href="detalle_pedido.php?id=<?php echo $ped['id_factura']?>" class="redirigir" style="text-decoration:none"><button class="btn  border border-secundary text-center "  style="width:6.3rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " > <img style="width:1.1rem; heigth:auto" src="imagenes/ojito.svg" alt=""> Ver </button></a>    
                    </form>
                    </td>
                    <?php
                    $id_pedi= $ped['id_estado_factura'];
                    if($id_pedi==3){ ?>
                        <td class="text-center" style="vertical-align:middle">
                        <form action="reportes.php" method="POST">
                        <input type="text" name="factura" value="<?php echo $ped['id_factura']?>" hidden>
                        <button  type="submit" class="btn  border border-secundary text-center " name="accion" value="aprobar"  style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " >  Aprobar </button>   
                        <button type="button" class="btn  border border-secundary text-center" name="accio" value="rechaza"  data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $ped['id_factura']?>" style="width:6.5rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F78181; margin-top:0.4rem " >  Rechazar </button>    
                        </form>
                        <!-- inicia el modal -->
                        <div class="modal" tabindex="-1" id="exampleModal<?php echo $ped['id_factura']?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center">Rechazar pedido</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="reportes.php" method="POST">
                                    <strong><label for="inputAddress" class="form-label text-center"> Indica el motivo de rechazo del pedido</label></strong>
                                    <input type="text" name="factura" value="<?php echo $ped['id_factura']?>" hidden>
                                    <textarea name="observacion" class="form-control "rows="5" cols="10" required></textarea>
                                    
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn" name="accion" value="rechazar" style="background:#F78181">Rechazar</button>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- finaliza el modal -->
                        

                        </td>

                    <?php }elseif($id_pedi==4){ ?>
                            <td class="text-center" style="vertical-align:middle">
                            <button disabled class="btn  border border-secundary text-center "   style="width:12rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#81DAF5; margin-top:0.4rem " >  Aprobó este pedido  </button>    
                            </td>
                        

                    <?php }elseif($id_pedi==5){ ?>
                        <td class="text-center" style="vertical-align:middle">
                            <button disabled class="btn  border border-secundary text-center "   style="width:12rem; font-size: 1.1rem; font-family: Homer Simpson UI; background:#F78181; margin-top:0.4rem " > Rechazó este pedido  </button>    
                            </td>

                    <?php }?>
                <td class="text-center" style="vertical-align:middle"><?php echo$ped['comentario']?></td>
                
                </tr>
                <?php endforeach;?>
      
            </tbody>
            </table>
            </div>

        </div>
        <div class="col-md-1"></div>

        </div>
    </div>
    <br>
</div>
<br><br>
<?php } ?>






<script>
    $('.redirigir').on('click', function(e) {
        e.preventDefault();
        const href= $(this).attr('href')
        document.location.href= href;
        

    })
    



</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="tabla.js"></script>

<?php include("plantillas/footer.php"); ?>