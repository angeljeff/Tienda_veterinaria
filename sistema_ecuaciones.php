


<?php
include "../db_conn.php"; 
/*         $id_animal=10;
        $fecha_actual = date("2018-02-01");
        for($i=0; $i<1550;$i++){
            $fecha_predecir=date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
            $fecha_actual=$fecha_predecir;
            if($i < 200){
                $litros=rand(20,70);
            }
            if($i >= 200 && $i < 600){
                $litros=rand(35,70);
            }
            if($i >= 600 && $i < 1000){
                $litros=rand(40,70);
            }
            if($i >= 1000 && $i <= 1550){
                $litros=rand(45,70);
            }
             $insertar= $conexion->prepare("INSERT INTO produccion (id_animal, fecha_produccion, litros_diarios) VALUES (:id, :fecha, :lit);");
            $insertar->bindParam(':id',$id_animal);
            $insertar->bindParam(':fecha',$fecha_predecir);
            $insertar->bindParam(':lit',$litros);
            $insertar->execute(); 

        } */
 


$a11=2;
$a12=3;
$a13=4;
$b1=20;
$a21=3;
$a22=-5;
$a23=-1;
$b2=-10;
$a31=-1;
$a32=2;
$a33=-3;
$b3=-6;
$D=($a11*$a22*$a33)+($a12*$a23*$a31)+($a13*$a21*$a32)-($a11*$a23*$a32)-($a12*$a21*$a33)-($a13*$a22*$a31);
$DX=($b1*$a22*$a33)+($a12*$a23*$b3)+($a13*$b2*$a32)-($b1*$a23*$a32)-($a12*$b2*$a33)-($a13*$a22*$b3);
$DY=($a11*$b2*$a33)+($b1*$a23*$a31)+($a13*$a21*$b3)-($a11*$a23*$b3)-($b1*$a21*$a33)-($a13*$b2*$a31);
$DZ=($a11*$a22*$b3)+($a12*$b2*$a31)+($b1*$a21*$a32)-($a11*$b2*$a32)-($a12*$a21*$b3)-($b1*$a22*$a31);
$X=$DX/$D;
$Y=$DY/$D;
$Z=$DZ/$D;
?>


<?php

echo "<br>X=".$X;
?>


<?php

echo "<br>Y=".$Y;
?>


<?php

echo "<br>Z=".$Z;
?>

