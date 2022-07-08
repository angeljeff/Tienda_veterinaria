<?php include("plantillas/encabezado.php"); 
 session_destroy();
 unset($_SESSION['usuario']);?>
 <script>
     document.location.href="<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA" ?>/index.php";
 </script>
