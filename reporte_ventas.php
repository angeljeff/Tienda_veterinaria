<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{


// Cabecera de página
function Header()
{
$dtz = new DateTimeZone("America/Guayaquil");
$fecha=new Datetime("now",$dtz);
$fechaa=$fecha->format("Y-m-d");
$this->SetFont('Arial','B',16);
// Movernos a la derecha
$this->Cell(60);
// Título
$this->Cell(70,10,'Reporte de Pedidos'." ".$fechaa,0,0,'C');
// Salto de línea
$this->Ln(12);
$this->Cell(60);
$this->Cell(70,10,'Veterinaria PetPlanet ',0,0,'C');
$this->Ln(12);

       
  
}




// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página') .$this->PageNo().'/{nb}',0,0,'C');
} 
}



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
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
    $TOTAL=0;
    foreach($pedido as $usu):
        $_id=$usu['id_factura'];
    
    
        include("config/bd.php");
          $pdf->Ln(5);
          $pdf->Cell(60);
          $pdf->SetFont('Arial','B',16);
          $pdf->Cell(70,10,'Listado de productos ',0,1,'C');
          $pdf->Cell(70,10,'Producto',1,0,'C',0);
          $pdf->Cell(38,10,'Cantidad',1,0,'C',0);
          $pdf->Cell(36,10,'precio',1,0,'C',0);
          $pdf->Cell(36,10,'total',1,1,'C',0);
    
          $total_final= 0;
          $subtotal=0;
          $iva=0;
          $sqlx = "SELECT p.id_producto, p.id_pro_fac, p.cantidad, p.precio_p, p.total_pro, s.nombre_producto, s.imagen_po FROM prod_por_factura as p INNER JOIN productos as s ON p.id_producto= s.id_producto INNER JOIN factura as f ON p.id_factura= f.id_factura  where p.id_factura=$_id ";
          $consultarproducto = $conexion->prepare($sqlx);
          $consultarproducto->execute();
          $countv= $consultarproducto->rowCount();
          if($countv >0) {
              $product=$consultarproducto->fetchAll(); 
              $limite= sizeof($product);
              foreach($product as $usu): 
                $pdf->SetFont('Arial','',14);
                $pdf->Cell(70,10,$usu['nombre_producto'],1,0,'C',0);
                $pdf->Cell(38,10,$usu['cantidad'],1,0,'C',0);
                $pdf->Cell(36,10,"$".$usu['precio_p'],1,0,'C',0);
                $pdf->Cell(36,10,"$".$usu['total_pro'],1,1,'C',0);
                  
                $subtotal= $subtotal+$usu['total_pro']; 
                $tabla[]= [$usu['id_producto'],$usu['cantidad']];
             
    
              endforeach;
              $iva=0.12*$subtotal;
              $total_final=$iva+$subtotal;
    
             $pdf->Ln(6);
             $pdf->SetFont('Arial','B',15);
             $pdf->Cell(155,10,'SubTotal: ',0,0,'R',0);
             $pdf->SetFont('Arial','',15);
             $pdf->Cell(25,10,"$".$subtotal,0,1,'R',0);
             $pdf->SetFont('Arial','B',15);
             $pdf->Cell(155,10,'Iva(12%): ',0,0,'R',0);
             $pdf->SetFont('Arial','',15);
             $pdf->Cell(25,10,"$".$iva,0,1,'R',0);
             $pdf->SetFont('Arial','B',15);
             $pdf->Cell(155,10,'Total: ',0,0,'R',0);
             $pdf->SetFont('Arial','',15);
             $pdf->Cell(25,10,"$".$total_final,0,1,'R',0);
             $TOTAL=$TOTAL+$total_final;
          }


    endforeach;
      $pdf->Ln(7);
      $pdf->SetFont('Arial','B',20);
      $pdf->Cell(135,10,'Total de ventas: ',1,0,'S',0);
      $pdf->Cell(45,10,"$".$TOTAL,1,1,'R',0);

}
  



	$pdf->Output();
?>