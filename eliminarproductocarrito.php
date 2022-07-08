
<?php
include("config/bd.php");
$_id=$_GET['id'];      
        
$eliminar= $conexion->prepare("DELETE FROM prod_por_factura where id_pro_fac=$_id;");
$eliminar->execute();

if($eliminar){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/carrito.php";
      
    </script>
    <?php
   
}
?>