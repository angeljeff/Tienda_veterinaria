
<?php include "plantillas/header.php";?>


 <?php 
/*
SELECT p.id_produccion, p.id_animal, p.fecha_produccion, count(p.fecha_produccion) as contador, SUM(p.litros_diarios) as suma FROM `produccion` as p inner join animal as a on p.id_animal=a.id_animal where a.estado=1 and a.estado_ani=1 group by p.fecha_produccion ;
        include "../db_conn.php";
        $fecha_actual = date("2022-05-01");
        for($i=0; $i<100; $i++){
          $_idanimal=rand(8, 10);
          $fecha=date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
          $fecha_actual=$fecha;
          $_litros= rand(10, 50);
          $insertar= $conexion->prepare("INSERT INTO produccion (id_animal, fecha_produccion, litros_diarios) VALUES (:id, :fecha, :lit);");
          $insertar->bindParam(':id',$_idanimal);
          $insertar->bindParam(':fecha',$fecha);
          $insertar->bindParam(':lit',$_litros);
          $insertar->execute();

        } */
?> 
<?php 
include "../db_conn.php";
$consulta= $conexion->prepare("SELECT p.id_produccion, p.id_animal, p.fecha_produccion, count(p.fecha_produccion) as contador, SUM(p.litros_diarios) as suma FROM `produccion` as p inner join animal as a on p.id_animal=a.id_animal group by p.fecha_produccion") ;
$consulta->execute();
$count= $consulta->rowCount();
if($count >0) {
    $produccion=$consulta->fetchAll();
    $cuenta_dias=0; $suma_litros=0; $suma_dias=0; $sumamultixy=0; $sumax2=0; $sumaz=0; $multixz=0; $sumamultixz=0;
    $multiyz=0; $sumamultiyz=0; $z2; $sumaz2=0;
    foreach($produccion as $p):
      $cuenta_dias++;
      $suma_dias=$suma_dias+$cuenta_dias;
      $sumaz=$sumaz+ $p['contador'];
      $suma_litros=$suma_litros+ $p['suma'];
      $multixy=$cuenta_dias * $p['suma'];
      $sumamultixy=$sumamultixy + $multixy;
      $multixz=$cuenta_dias * $p['contador'];
      $sumamultixz=$sumamultixz + $multixz;
      $x2=$cuenta_dias*$cuenta_dias;
      $sumax2=$sumax2+$x2;
      $multiyz=$p['suma'] * $p['contador'];
      $sumamultiyz=$sumamultiyz + $multiyz;
      $z2=$p['contador']*$p['contador'];
      $sumaz2= $sumaz2+$z2;
      $ultimafecha=$p['fecha_produccion'];
/*       $cuenta_dias++;
      $suma_litros=$suma_litros+ $p['suma'];
      $suma_dias=$suma_dias+$p['contador'];
      $multixy=$p['contador'] * $p['suma'];
      $sumamultixy=$sumamultixy + $multixy;
      $x2=$p['contador']*$p['contador'];
      $sumax2=$sumax2+$x2;
      $ultimafecha=$p['fecha_produccion'];
      echo $multixy;echo "<br>"; */
/*       $cuenta_dias++;
      $suma_litros=$suma_litros+ $p['suma'];
      $suma_dias=$suma_dias+$cuenta_dias;
      $multixy=$cuenta_dias * $p['suma'];
      $sumamultixy=$sumamultixy + $multixy;
      $x2=$cuenta_dias*$cuenta_dias;
      $sumax2=$sumax2+$x2;
      $ultimafecha=$p['fecha_produccion'];
      echo $multixy;echo "<br>"; */

/*       echo $p['id_produccion']." ";
      echo $p['id_animal']." ";
      echo $p['fecha_produccion']." ";
      echo $p['contador']." ";
      echo $p['suma']." ";
      echo "<br>"; */

    endforeach;
    $a11=$suma_dias;
     echo $a11;echo "<br>"; 
    $a12=$sumaz;
     echo $a12;echo "<br>"; 
    $a13=$cuenta_dias;
     echo $cuenta_dias;echo "<br>"; 
    $b1=$suma_litros;
     echo $b1;echo "<br>"; 
    $a21=$sumax2;
     echo $a21;echo "<br>"; 
    $a22=$sumamultixz;
     echo $a22;echo "<br>"; 
    $a23=$suma_dias;
     echo $a23;echo "<br>"; 
    $b2=$sumamultixy;
     echo $b2;echo "<br>"; 
    $a31=$sumamultixz;
     echo $a31;echo "<br>"; 
    $a32=$sumaz2;
     echo $a32;echo "<br>"; 
    $a33=$sumaz;
    echo $a33;echo "<br>";
    $b3=$sumamultiyz;
     echo $b3;echo "<br>"; 
/*     $D=($a11*$a22*$a33)+($a12*$a23*$a31)+($a13*$a21*$a32)-($a11*$a23*$a32)-($a12*$a21*$a33)-($a13*$a22*$a31);
    $DX=($b1*$a22*$a33)+($a12*$a23*$b3)+($a13*$b2*$a32)-($b1*$a23*$a32)-($a12*$b2*$a33)-($a13*$a22*$b3);
    $DY=($a11*$b2*$a33)+($b1*$a23*$a31)+($a13*$a21*$b3)-($a11*$a23*$b3)-($b1*$a21*$a33)-($a13*$b2*$a31);
    $DZ=($a11*$a22*$b3)+($a12*$b2*$a31)+($b1*$a21*$a32)-($a11*$b2*$a32)-($a12*$a21*$b3)-($b1*$a22*$a31);
    $A=$DX/$D;
    $B=$DY/$D;
    $C=$DZ/$D;
     echo $A." ".$B." ".$C; */ 
     $A=0;
     $B=10;
     $C=0;

/*     $sumaxpory=$suma_litros*$suma_dias;
    $multiplicacionconN1= $cuenta_dias*$sumamultixy;
    $resultadonumerador=$multiplicacionconN1 - $sumaxpory;
    $sumaxal_2=$suma_dias*$suma_dias;
    $multiplicacionconN2= $cuenta_dias*$sumax2;
    $resultadodenominador=$multiplicacionconN2 - $sumaxal_2;
    $valorm=$resultadonumerador/$resultadodenominador;
    $promediox=$suma_dias/$cuenta_dias;
    $promedioy=$suma_litros/$cuenta_dias;
    $mporx=$valorm*$promediox;
    $valorb=$promedioy-$mporx;
    echo "rrwul".$sumaxpory;
    echo "  numerador".$resultadonumerador;
    echo "  numerador".$resultadonumerador;
    echo "  numerador".$sumaxal_2;
    echo "  denonumerador".$resultadodenominador;
    echo "  m".$valorm;
    echo "  b".$valorb; */

    $contadorgenerar=$cuenta_dias;
    $fecha_actual = date("Y-m-d");
    $ult_FECHA=date("$ultimafecha");
    $dtz = new DateTimeZone("America/Guayaquil");
    $fecha= new Datetime("now", $dtz);
    $ULTIMAFE=new Datetime($ult_FECHA,$dtz);
    $diff = $fecha->diff($ULTIMAFE); 
    $dias=$diff->days;
    $contadoracumulado=$contadorgenerar+$dias;
    include "../db_conn.php";
    $consultar= $conexion->prepare("SELECT * FROM animal  where estado=1 and estado_ani=1 and etapa_desarrollo='Lechera'") ;
    $consultar->execute();
    $counta= $consultar->rowCount();
    for($j=0; $j<15;$j++){
      $value=$contadoracumulado++;
      echo "   ".$value. "<br>";
     
      $fecha_predecir=date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
      $fecha_actual=$fecha_predecir;
      /* $y=$valorb +($valorm * $value); */
       $y= ($A * $value) + ($B * $counta) + $C;
      $tabladiaria[]='{date:"'.$fecha_predecir.'", steps:'.$y.'},';
    }  



/*     echo "  fecha".$fecha_actual;
    echo "  ultimafecha".$ult_FECHA;
    echo "  DIAS".$dias; */
      
    
    
/*     echo "es el con".$cuenta_dias;
    echo "suma final".$suma_litros;
    echo "suma dias final".$suma_dias;
    echo "suma multixy".$sumamultixy;
    echo "suma x2".$sumax2; */
}else{
  echo "no traje nada";
}

?> 


<!-- Styles -->
<style>
#chartdivdiaria {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdivdiaria");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

root.dateFormatter.setAll({
 
  dateFields: ["valueX"]
});

var data = [
  {
    date: "2022-07-19",
    steps: 56
  },
  {
    date: "2022-07-20",
    steps: 68
  },
  {
    date: "2022-07-21",
    steps: 34
  },
  {
    date: "2022-07-22",
    steps: 87
  },
  {
    date: "2022-07-23",
    steps: 86
  },
  {
    date: "2022-07-24",
    steps: 56
  },
  {
    date: "2022-07-25",
    steps: 28
  },
  {
    date: "2022-07-26",
    steps: 29
  },
  {
    date: "2022-07-27",
    steps: 69
  },
  {
    date: "2022-07-28",
    steps: 87
  },
  {
    date: "2022-07-29",
    steps: 78
  },
  {
    date: "2022-07-30",
    steps: 76
  },
  {
    date: "2022-07-31",
    steps: 74
  },
  {
    date: "2022-08-01",
    steps: 87
  },
  {
    date: "2022-08-02",
    steps: 78
  },
  {
    date: "2022-08-03",
    steps: 98
  },
  {
    date: "2022-08-04",
    steps: 89
  },
  {
    date: "2022-08-05",
    steps: 98
  },
  {
    date: "2022-08-06",
    steps: 83
  },
  {
    date: "2022-08-07",
    steps: 67
  },
  {
    date: "2022-08-08",
    steps: 45
  },

 
];

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
  am5xy.XYChart.new(root, {
    focusable: true,
    panX: true,
    panY: false,
    wheelX: "panX",
    wheelY: "none"
  })
);

var easing = am5.ease.linear;

// hide zoomout button
chart.zoomOutButton.set("forceHidden", true);

// add label
chart.plotContainer.children.push(
  am5.Label.new(root, { text: "", x: 100, y: 50 })
);

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  minGridDistance: 50,
  strokeOpacity: 0.2
});
xRenderer.grid.template.set("forceHidden", true);

var xAxis = chart.xAxes.push(
  am5xy.DateAxis.new(root, {
    maxDeviation: 0.49,
    snapTooltip: false,
    baseInterval: {
      timeUnit: "day",
      count: 1
    },
    renderer: xRenderer,
    tooltip: am5.Tooltip.new(root, {})
  })
);

var yRenderer = am5xy.AxisRendererY.new(root, { inside: true });
yRenderer.grid.template.set("forceHidden", true);

var yAxis = chart.yAxes.push(
  am5xy.ValueAxis.new(root, {
    maxDeviation: 0,
    renderer: yRenderer
  })
);

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(
  am5xy.ColumnSeries.new(root, {
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "steps",
    valueXField: "date",
    tooltip: am5.Tooltip.new(root, {
      pointerOrientation: "vertical",
      labelText: "{valueY}"
    })
  })
);

series.columns.template.setAll({
  cornerRadiusTL: 15,
  cornerRadiusTR: 15,
  maxWidth: 30,
  strokeOpacity: 0
});

series.columns.template.adapters.add("fill", function (fill, target) {
  if (target.dataItem.get("valueY") < 6000) {
    return am5.color(0xdadada);
  }
  return fill;
});

// Set up data processor to parse string dates
// https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
series.data.processor = am5.DataProcessor.new(root, {
  dateFormat: "yyyy-MM-dd",
  dateFields: ["date"]
});

/* series.data.setAll([
    <?php
/*     for ($i=0; $i<15; $i++){
        echo $tabladiaria[$i];
       }  */  
?>
]); */

series.data.setAll([
    <?php
        for ($i=0; $i<15; $i++){
            echo $tabladiaria[$i];
           }

    
?>
]);

// do not allow tooltip  to move horizontally
series.get("tooltip").adapters.add("x", function (x) {
  return chart.plotContainer.toGlobal({
    x: chart.plotContainer.width() / 2,
    y: 0
  }).x;
});

// add ranges
/* var goalRange = yAxis.createAxisRange(yAxis.makeDataItem({
  value: 3000
}));

goalRange.get("grid").setAll({
  forceHidden: false,
  strokeOpacity: 0.2
}); */

/* var goalLabel = goalRange.get("label");

goalLabel.setAll({
  centerY: am5.p100,
  centerX: am5.p100,
  text: "Litros"
});

// put to other side
goalLabel.adapters.add("x", function (x) {
  return chart.plotContainer.width();
});

var goalRange2 = yAxis.createAxisRange(yAxis.makeDataItem({
  value: 12000
}));

goalRange2.get("grid").setAll({
  forceHidden: false,
  strokeOpacity: 0.2
});

var goalLabel2 = goalRange2.get("label");

goalLabel2.setAll({
  centerY: am5.p100,
  centerX: am5.p100,
  text: "2 x Goal"
});

// put to other side
goalLabel2.adapters.add("x", function (x) {
  return chart.plotContainer.width();
});

// reposition when width changes
chart.plotContainer.onPrivate("width", function () {
  goalLabel.markDirtyPosition();
  goalLabel2.markDirtyPosition();
}); */

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  alwaysShow: true,
  behavior: "none",
  positionX: 0.5 // make it always be at the center
}));
cursor.lineY.set("visible", false);

// zoom to last 11 days
series.events.on("datavalidated", function () {
  var toTime =
    series.dataItems[series.dataItems.length - 1].get("valueX") +
    am5.time.getDuration("day", 1);
  var fromTime = series.dataItems[series.dataItems.length - 11].get("valueX");

  xAxis.zoomToValues(fromTime, toTime);
});

// when plot are is released, round zoom to nearest days
chart.plotContainer.events.on("globalpointerup", function () {
  var dayDuration = am5.time.getDuration("day", 1);

  var firstTime = am5.time
    .round(new Date(series.dataItems[0].get("valueX")), "day", 1)
    .getTime();
  var lastTime =
    series.dataItems[series.dataItems.length - 1].get("valueX") + dayDuration;
  var totalTime = lastTime - firstTime;
  var days = totalTime / dayDuration;

  var roundedStart =
    firstTime + Math.round(days * xAxis.get("start")) * dayDuration;
  var roundedEnd =
    firstTime + Math.round(days * xAxis.get("end")) * dayDuration;

  xAxis.zoomToValues(roundedStart, roundedEnd);
});

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 50);

}); // end am5.ready()
</script>

<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
                        PREDICCIÓN DIARIA
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <div class="col-md-12"><br>
             <div class="card">
                <div class="card-body text-center" style="border-radius:3%; font-family: sans-serif; margin-top: 0.3rem; font-size:1.3rem;">
                <div id="chartdivdiaria"></div>
             </div>
            </div>
        </div>
    </div>
</div>



<?php include "plantillas/pie_pagina.php";?>