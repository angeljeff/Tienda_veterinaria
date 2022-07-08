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
<br><br><br><br>
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
<br><br><br><br>

<?php include("plantillas/footer.php"); ?>
