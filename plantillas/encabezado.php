<?php if( !headers_sent() && '' == session_id() ) {
session_start();
}
error_reporting(0);
$datoscarrito=false;
$general=true; 
$cliente=false;
$administrador=false;
$actualizacion=false;
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
if($tipo_sesion== null || $tipo_sesion==""){
  $general=true; 
  $cliente=false;
  $administrador=false;
} elseif($tipo_sesion==1){
  $general=false; 
  $cliente=true;
  $administrador=false;
  $datoscarrito=True;
}else{
  $general=false; 
  $cliente=false;
  $administrador=True;
  $datoscarrito=True;
} 


if($datoscarrito==True){
    include("config/bd.php");
    $sqlh = "SELECT *FROM factura where cedula=$cedula_sesion and id_estado_factura=1";
    $con = $conexion->prepare($sqlh);
    $con->execute();
    $countw= $con->rowCount();

    if($countw >0) {
        $fac=$con->fetch();

        $idfac=$fac['id_factura'];
        $sqlx = "SELECT p.id_producto, p.cantidad, p.precio_p, p.total_pro, s.nombre_producto FROM prod_por_factura as p INNER JOIN productos as s ON p.id_producto= s.id_producto INNER JOIN factura as f ON p.id_factura= f.id_factura  where p.id_factura=$idfac";
        $consultarproduc = $conexion->prepare($sqlx);
        $consultarproduc->execute();
        $countv= $consultarproduc->rowCount();
        if($countv >0) {
            $product=$consultarproduc->fetchAll();
            $actualizacion=True;
          }
      
    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/principal.css">
    <link rel="stylesheet" type="text/css" href="css/productos.css">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.11.5/css/dataTables.bootstrap5.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="validar_cedula.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway+Dots" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <title>veterinaria</title>
  </head>
  <body>
    <?php if ($general==True){ ?>
      <header>
        <div class="container-fluid mt-2 p-1 border border-secondary encabezado">
            <div class="row">
            <?php $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA"?>
                <div class="col-md-2">
                  <a href="<?php echo $url;?>/index.php"><img  src="imagenes/logo.png" class="img-fluid" alt=""> </div></a>
                <div class="col-md-7 slogan" >
                  <p class="text-center" >"Protección para las mascotas, Tranquilidad para los humanos"</p>
                </div>
                  <div class="col-md-3">
                  <div class="container-fluid d-flex">
            <!--  <a href="chatbot.php"> <img class="carrito" src="imagenes/conversacion.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.1rem; margin-right: 0.3rem;margin-top:0.5rem "></a>-->
                    <a href="login.php"> <img class="carrito" src="imagenes/shoppingcart_80945.svg" alt="carrito" style="max-width: auto; max-height: 3.1rem; height: 3.1rem; margin-top:0.5rem "></a>
                    
                  
                    
                    
                    <!-- <a href="login.php"> <img class="carrito" src="imagenes/shoppingcart_80945.svg" alt="carrito" style="max-width: auto; max-height: 3.1rem; margin-top: 0.5rem;"></a> -->

                    <a href="login.php"> <img class="carrito" src="imagenes/user_icon_150670.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.1rem; margin-left: 0.5rem; margin-top:0.5rem "></a>
                    <a href="login.php" style="margin-top: 1.2rem; color:black; margin-left: 0.2rem;"><h5>Ingresar </h5></a>
                    <a href="<?php echo $url;?>/registro.php" style="margin-top: 1.2rem; color:black; margin-left: 0.6rem; "><h5>Registrar </h5></a>
                  </div>

                 </div>
                
            </div>
        </div>
      </header>
    <?php }?>
    <?php if ($cliente==True){ ?>
      <header>
      <div class="container-fluid mt-2 p-1 border border-secondary encabezado">
          <div class="row">
          <?php $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA"?>
              <div class="col-md-2">
                <a href="<?php echo $url;?>/index.php"><img  src="https://d500.epimg.net/cincodias/imagenes/2019/10/02/lifestyle/1570029081_071016_1570029510_rrss_normal.jpg" class="img-fluid" alt=""> </div></a>
              <div class="col-md-7 slogan">
                <p class="text-center" >"Protección para las mascotas, Tranquilidad para los humanos"</p>
              </div>
                <div class="col-md-3">
                <div class="container-fluid d-flex">
                  <?php if($actualizacion==false){ ?>
                    <a href="carrito_.php" title="Mi carrito"> <img class="carrito" src="imagenes/shoppingcart_80945.svg" alt="carrito" style="max-width: auto; max-height: 3.1rem; height: 3.1rem;margin-top:0.5rem "></a>

                    <?php } else{ ?>
                  <a href="chatbot.php"> <img class="carrito" src="imagenes/conversacion.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.1rem; margin-right: 0.3rem;margin-top:0.4rem "></a>
                    
                      <a href="<?php echo $url;?>/carrito.php" title="Mi carrito"> <img class="carrito" src="imagenes/coche.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.3rem; margin-left: 0.6rem;margin-top: 0.4rem; "></a>
           
                  
                  <?php } ?>
                  <a href="<?php echo $url;?>/panelcliente.php" title="panel administración"> <img class="carrito" src="imagenes/user_icon_150670.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.1rem; margin-left: 0.5rem; margin-top:0.4rem   "></a>
                  <a href="<?php echo $url;?>/misdatos.php" style="margin-top: 1rem; color:black; margin-left: 0.2rem;"><h4><?php echo $nombre_sesion ?></h4></a>
                  <a href="<?php echo $url;?>/cerrar-sesion.php" style="margin-top: 1rem; color:black; margin-left: 0.6rem; "><h4>Salir</h4></a>
                </div>

               </div>
              
          </div>
      </div>
    </header>

    <?php }?>
    <?php if ($administrador==True){ ?>
      <header>
      <div class="container-fluid mt-2 p-1 border border-secondary encabezado">
          <div class="row">
          <?php $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA"?>
              <div class="col-md-2">
                <a href="<?php echo $url;?>/index.php"><img  src="https://d500.epimg.net/cincodias/imagenes/2019/10/02/lifestyle/1570029081_071016_1570029510_rrss_normal.jpg" class="img-fluid" alt=""> </div></a>
              <div class="col-md-7 slogan">
                <p class="text-center">"Protección para las mascotas, Tranquilidad para los humanos"</p>
              </div>
                <div class="col-md-3">
                <div class="container-fluid d-flex">
                  <a href="<?php echo $url;?>/panelusuario.php" title="panel de administración"> <img class="carrito" src="imagenes/user_icon_150670.svg" alt="carrito" style="max-width: auto; max-height: 4rem; height: 3.1rem; margin-left:0.5rem;  "></a>
                  <a href="<?php echo $url;?>/misdatos.php" style="margin-top: 1rem; color:black; margin-left: 0.2rem;"><h4><?php echo $nombre_sesion ?></h4></a>
                  <a href="<?php echo $url;?>/cerrar-sesion.php" style="margin-top: 1rem; color:black; margin-left:0.6rem  "><h4>Salir </h4></a>
                </div>

               </div>
              
          </div>
      </div>
    </header>

    <?php }?>