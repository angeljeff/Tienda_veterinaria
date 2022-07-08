<?php
include("config/bd.php");
$_id=$_GET['id'];
    $estado=0;
    $eliminarr= $conexion->prepare("UPDATE productos SET  estado_producto=:estado WHERE id_producto=$_id ");
    $eliminarr->bindParam(':estado',$estado);
    $eliminarr->execute();

    if($eliminarr){?>
        <script>
          window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/productos.php";
          
        </script>
        <?php
       
    }
    ?>