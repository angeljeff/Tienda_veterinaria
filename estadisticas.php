<?php include("plantillas/encabezado.php"); ?>
 <?php
 $cedula_sesion= $_SESSION['usuario'][0];
 $nombre_sesion= $_SESSION['usuario'][1];
 $tipo_sesion= $_SESSION['usuario'][2];
 if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==1){?>
  <script>
    window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
    
  </script>
  <?php
    
     die();
 }

include("config/bd.php");
 
$sqlb = "SELECT nombre_producto, unidades_vendidas FROM productos where estado_producto=1 ORDER BY unidades_vendidas ASC ";
$consultarunproducto = $conexion->prepare($sqlb);
$consultarunproducto->execute();
$countq= $consultarunproducto->rowCount();
$datos=array();
if($countq >0) {
    $producto=$consultarunproducto->fetchAll();  
    $limite= sizeof($producto);
     foreach($producto as $pro):
        $tabla[]='{nombre:"'.$pro['nombre_producto'].'", cantidad:'.$pro['unidades_vendidas'].'},';
        
    endforeach;

}

?>

<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
<script>

am5.ready(function() {

var root = am5.Root.new("chartdiv");

root.setThemes([
  am5themes_Animated.new(root)
]);

var chart = root.container.children.push(
  am5percent.PieChart.new(root, {
    endAngle: 270
  })
);
var series = chart.series.push(
  am5percent.PieSeries.new(root, {
    valueField: "cantidad",
    categoryField: "nombre",
    endAngle: 270
  })
);

series.states.create("hidden", {
  endAngle: -90
});

// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data

series.data.setAll([
    <?php
    if($limite<10){
        for ($i=0; $i<$limite; $i++){
            echo $tabla[$i];
           }
    }else{
        for ($i=0; $i<10; $i++){
            echo $tabla[$i];
           } 
    }
    
?>
]);

series.appear(1000, 100);

}); 
</script>
<?php 
include("config/bd.php");
$sqlm = "SELECT *FROM factura where id_estado_factura=3 ";
$consultarfac = $conexion->prepare($sqlm);    
$consultarfac->execute();
$count= $consultarfac->rowCount();
if($count >0) {
    $pedidos=$consultarfac->fetchAll();
    $contador=0;
    foreach($pedidos as $usu):
      $contador++;


    endforeach;
    
}else{
  $contador=0;
}?>

<?php 
include("config/bd.php");
$dtz = new DateTimeZone("America/Guayaquil");
$fecha=new Datetime("now",$dtz);
$fechaa=$fecha->format("Y-m-d");


$sql = "SELECT *FROM factura where fecha=:fC and id_estado_factura=4 ";
$consultarfactura = $conexion->prepare($sql); 
$consultarfactura->bindParam(':fC',$fechaa);   
$consultarfactura->execute();
$countt= $consultarfactura->rowCount();
if($countt >0) {
    $pedido=$consultarfactura->fetchAll();
    $contador2=0;
    foreach($pedido as $usu):
      $contador2++;


    endforeach;
    
}else{
  $contador2=0;

    
}?>




<br><br>
<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-5">
    <div class="card">
      <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
        ÓRDENES PENDIENTES
      </div>
    </div>
    </div>
    <div class="col-md-2">
    <div class="card">
      <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
      <?php echo $contador ?>
      </div>
    </div>
    </div>
    <div class="col-md-2 justify-content-center">
    <a  href="reportes.php" class=" btn border border-dark text-center" style=" text-decoration:none; width:6.3rem; height:3.2rem; font-size: 1.5rem; font-family: Homer Simpson UI; background:#A9E2F3; color:black; margin-top:0.6rem;">VER</a> 

    </div>
    <div class="col-md-1"></div>
  </div>
</div>

<br>
<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-5">
    <div class="card">
      <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
        VENTAS DE HOY
      </div>
    </div>
    </div>
    <div class="col-md-2">
    <div class="card">
      <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
      <?php echo $contador2 ?>
      </div>
    </div>
    </div>
    <div class="col-md-2 justify-content-center">
    <a   href="reporte_ventas.php" target="_blank" rel="noopener noreferrer" class=" btn border border-dark text-center" style=" text-decoration:none; width:6.3rem; height:3.2rem; font-size: 1.5rem; font-family: Homer Simpson UI; background:#A9E2F3; color:black; margin-top:0.6rem;">VER</a> 

    </div>
    <div class="col-md-1"></div>
  </div>
</div>

<br><br>

<br>
<h3 class="text-center" style="font-family: sans-serif; margin-top: 0.3rem;">PRODUCTOS MÁS VENDIDOS</h3>

<div class="container">
    <div class="row">
        <div class="col-md-12 border border-dark" style="border-radius:0.3em; box-shadow: 1px 0.4px 4px 6px #D5E1DF; margin-top:0.5rem;">
        <div id="chartdiv"></div>
        
        </div>
        <br><br>
        <div class="col-md-12 text-center">
            <br>
        <br>

        </div>
    </div>
</div>

<br><br><br>


<?php include("plantillas/footer.php"); ?>
