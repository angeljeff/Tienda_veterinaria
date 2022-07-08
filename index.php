
<?php include("plantillas/encabezado.php"); ?>
<?php include("config/bd.php");



 $_buscar=(isset($_POST['buscar']))?$_POST['buscar']:"";
switch($_buscar)  {
    case "busq":
        $_busc= $_POST['buscarr'];?>
        <script>
          window.location.href = "<?php echo $url;?>/buscador.php?nombre_producto=<?php echo $_busc;?>";
        </script>
        <?php
       
        break;
}                   
                      

$sqlm = "SELECT * FROM categorias";
$consultarcat = $conexion->prepare($sqlm);
$consultarcat->execute();
$count= $consultarcat->rowCount();
if($count >0) {
    $categorrias=$consultarcat->fetchAll();
    }?>
<?php include("config/bd.php");
$sqlmm = "SELECT * FROM sub_categorias";
$consultarsucat = $conexion->prepare($sqlmm);
$consultarsucat->execute();
$countt= $consultarsucat->rowCount();
if($countt >0) {
    $subcatego=$consultarsucat->fetchAll();
    }?>


  




    <nav class="navbar navbar-light bg-primary border border-light navbar-fixed-top">
        <div class="container-fluid ">
          
          <button class="navbar-toggler bg-white border border-secondary" style="border-radius: 0.6em;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="col-md-3">
          <form class="d-flex buscador" method="POST">
            <input  class="form-control me-2 border border-secondary" name="buscarr" type="text" placeholder="Producto" aria-label="Search">
            <button  type="submit" name="buscar" value="busq" class="btn btn-outline-success" >Buscar</button>

          </form>

        </div>
          <div class="offcanvas offcanvas-start"  tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title h1" id="offcanvasNavbarLabel">Categorías</h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item dropdown">
                <?php foreach($categorrias as $cat):?>
                  <?php
                  $b= strlen($cat['nombre_cat']);
                  $h=15;
                  $c=$h-$b;
                 
                 ?>
                  <a class="nav-link dropdown-toggle h3 ms-3" href="#" id="offcanvasNavbarDropdown"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo$cat['nombre_cat']?><?php echo str_repeat(" -", $c)?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                    <?php foreach($subcatego as $scat):?>
                  <?php if ($cat['id_categoria']==$scat['id_categoria']){?>

                    <li><a class="dropdown-item" href="consultacategoria.php?id=<?php echo $scat['id_sub_cat']?>"><?php echo$scat['nombre_sub_ca']?></a></li>
                    <?php } ?>
                    <?php endforeach;?> 
                </ul>


                 
                  
                  <?php endforeach;?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
        
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner mx-auto">
                <div class="carousel-item active" data-bs-interval="1000">
                  <img src="https://www.webooh.com/wp-content/uploads/2016/06/C%C3%B3mo-usar-Facebook-Messenger-en-tu-negocio-2.jpg" class="d-block w-100" alt="...">
                </div>
                <?php include("config/bd.php");
                $sql = "SELECT *FROM publicidad where estado=1";
                $consultarpu = $conexion->prepare($sql);
                $consultarpu->execute();
                $count= $consultarpu->rowCount();
                if($count >0) {
                    $publicidad=$consultarpu->fetchAll();
                }

                 foreach($publicidad as $pub):?>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="imagenes/publicidad/<?php echo $pub['imagen']?>" class="d-block w-100" alt="...">
                </div>
                 <?php endforeach;?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div> 

          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
      <div class="container" id="datos_buscador">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php include("config/bd.php"); 
          $sql = "SELECT p.id_producto, p.nombre_producto, p.precio_pro, p.cantidad_disp, p.fecha_elaboracion, p.fecha_vencimiento, p.imagen_po, p.id_proveedores, p.id_sub_cat, s.nombre_sub_ca, c.nombre_cat, pro.nombre_pro FROM productos as p INNER JOIN sub_categorias as s ON p.id_sub_cat= s.id_sub_cat INNER JOIN categorias as c ON s.id_categoria=c.id_categoria INNER JOIN proveedores as pro ON p.id_proveedores=pro.id_proveedores where p.estado_producto=1";
          $consultarproductos = $conexion->prepare($sql);
          $consultarproductos->execute();
          $county= $consultarproductos->rowCount();
          if($county >0) {
              $productt=$consultarproductos->fetchAll();
          }      
          foreach($productt as $pro):  ?>

          <div class="col">
            <div class="card shadow-sm img-prod" style="border-radius:1em" >
              <br>
              <h2 class="card-title text-center" style="margin-bottom: -1rem; font-size:1.5rem;"><?php echo $pro['nombre_producto']?></h2>
              <hr style="margin-top:1.5em">
              <img src="imagenes/productos/<?php echo $pro['imagen_po']?>" name="imagen_pro" alt="" style="width: 90%; max-height:18rem; height: 16rem; margin:auto; ">
              <div class="card-body">
                <hr style="">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6 d-flex">
                      <strong><p class="card-text"> Precio: </p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> $ <?php echo $pro['precio_pro']?></p>
                    </div>
                    <div class="col-md-6 d-flex">
                      <strong><p class="card-text"> Disponible: </p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['cantidad_disp']?></p>
                    </div>
                  </div>
                </div>
                <?php if( $pro['fecha_elaboracion']!="0000-00-00" and $pro['fecha_vencimiento']!="0000-00-00") { ?>
                <div class="container-fluid">
                  <div class="row">
                        
                    <div class="col-md-6 d-flex">
                      <strong><p class="card-text">Elab:</p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['fecha_elaboracion']?></p>
                    </div>
                    <div class="col-md-6 d-flex">
                      <strong><p class="card-text">Venc:</p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['fecha_vencimiento']?></p>
                    </div>
                  </div>
                  
                </div>
                <?php }?>

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12 d-flex">
                      <strong><p class="card-text"> Categoria: </p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['nombre_cat']?></p>
                    </div>
                    <div class="col-md-12 d-flex">
                      <strong><p class="card-text"> Subcategoria: </p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['nombre_sub_ca']?></p>
                    </div>
                    <div class="col-md-12 d-flex" style="height:3.4em">
                      <strong><p class="card-text"> proveedor: </p></strong>
                      <p class="card-text" style="margin-left: 0.5rem;"> <?php echo $pro['nombre_pro']?></p>
                    </div>
                    
                  </div>
                </div>
                <?php if( $pro['fecha_elaboracion']=="0000-00-00" and $pro['fecha_vencimiento']=="0000-00-00") { ?>
                <br>
                <?php }?> 
                <br>
                <div class="container">
                  <div class="row">
                  <form action="carrito.php" method="POST" class="d-flex justify-content-between">
                    <div class="col-md-5">
                      
                       <div class="d-flex justify-content-between">
                          <div>
                             <p class="text-dark" style="margin-top:0.25em">Cantidad</p>
                          </div>
                          <div class="input-group w-auto justify-content-start align-items-center">
                            <input type="text" name="idpro" value="<?php echo $pro['id_producto']?>" hidden>
                            <input type="text" name="precio_p" value="<?php echo $pro['precio_pro']?>" hidden>
            
                             
                            <input type="number" step="1" max="<?php echo $pro['cantidad_disp']?>" value="1" min="1" name="quantity" class="quantity-field border-1 text-center w-50 " style="margin-left: 2rem;">     
                          </div>
                       </div>
                    </div>
                    <div class="col-md-7">
                      <?php $a=0;
                     
                      if($actualizacion==True){
                       foreach($product as $pu):
                        if( $pro['id_producto']== $pu['id_producto']) { ?>
                      <button disabled type="submit" name="carrito" value="enviar"class="btn text-center border border-secondary" style="margin-left: 3rem; width: 8rem; font: condensed 120% sans-serif; background:  #A9E2F3;">Añadir Carrito</button>
                      <?php $a=1;
                       break;
                       
                       } endforeach;
                       }
                       if($a==0){ ?>
                      <button  type="submit" name="carrito"  value="enviar" class="btn text-center border border-secondary"  style="margin-left: 3rem; width: 8rem; font: condensed 120% sans-serif; background:  #A9E2F3;">Añadir Carrito</button>
                      <?php };?>
                      
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <?php endforeach;?>
      </div>

      <a href="chatbot.php" class="btn-flotante" style="
      	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	border-radius: 5px; /* Borde del boton */
	letter-spacing: 2px; /* Espacio entre letras */
	background-color: #5FC0DB; /* Color de fondo */
	padding: 18px 30px; /* Relleno del boton */
	position: fixed;
	bottom: 40px;
	right: 40px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;
  text-decoration:none;
  
      ">Chatbot</a>




    

<script>
  function agregarcarrito(){
    
     
    Swal.fire({
      position: 'top-center',
      icon: 'success',
      title: 'Your work has been saved',
      showConfirmButton: false,
      timer: 3000
    })
  }
</script>

<script>
    $('.agr').on('click', function(e) {
        e.preventDefault();
        const href= "<?php echo $url ?>/index.php"
        Swal.fire({
      position: 'top-center',
      icon: 'success',
      title: 'Your work has been saved',
      showConfirmButton: false,
      timer: 3000
    })
    })
    
</script>


    
<?php include("plantillas/footer.php");?>  