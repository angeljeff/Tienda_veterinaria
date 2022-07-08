<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    
// Cabecera de página
function Header()
{
    $_id=$_GET['id'];
	
    // Arial bold 15
    $this->SetFont('Arial','B',16);
    // Movernos a la derecha
    $this->Cell(60);
    // Título
    $this->Cell(70,10,'Reporte del Pedido ',0,0,'C');
    // Salto de línea
    $this->Ln(12);
    $this->Cell(70,10,'Veterinaria PetPlanet ',0,0,'S');
    $this->Ln(12);

/*     $this->Cell(80,10,'Nombre',1,0,'C',0);
	$this->Cell(50,10,'Precio',1,0,'C',0);
	$this->Cell(50,10,'Stock',1,1,'C',0); */


    include("config/bd.php");
    
    $sqlx = "SELECT cedula, imagen_comp,fecha FROM factura  where id_factura=$_id ";
    $consultarcedula = $conexion->prepare($sqlx);
    $consultarcedula->execute();
    $countv= $consultarcedula->rowCount();
    if($countv >0) {
        $usuariofactura=$consultarcedula->fetch();
        $_cedula=$usuariofactura['cedula'];
        $sqlma = "SELECT  *FROM usuarios where cedula=:cedu ";
        $cons = $conexion->prepare($sqlma);
        $cons->bindParam(':cedu',$_cedula);
        $cons->execute();
        $countc= $cons->rowCount();
        if($countc >0) {
         $pago=$cons->fetch();
         $nombre_completo=$pago['nombres']." ".$pago['apellidos'];
         $this->SetFont('Arial','B',15);
         $this->Cell(30,10,'Fecha:',0,0,'C',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,$usuariofactura['fecha'],0,1,'S',0);
         $this->SetFont('Arial','B',15);
         $this->Cell(30,10,'Cliente:',0,0,'C',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,$nombre_completo,0,1,'S',0);
         $this->SetFont('Arial','B',15);
         $this->Cell(30,10,utf8_decode('Cédula:'),0,0,'C',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,"0".$pago['cedula'],0,1,'S',0);
         $this->SetFont('Arial','B',15);
         $this->Cell(30,10,'Correo:',0,0,'C',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,$pago['correo'],0,1,'S',0);
         
      }  }
      $this->Ln(5);
      $this->Cell(60);
      $this->SetFont('Arial','B',16);
      $this->Cell(70,10,'Listado de productos ',0,1,'C');
      $this->Cell(70,10,'Producto',1,0,'C',0);
      $this->Cell(38,10,'Cantidad',1,0,'C',0);
      $this->Cell(36,10,'precio',1,0,'C',0);
      $this->Cell(36,10,'total',1,1,'C',0);

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
            $this->SetFont('Arial','',14);
            $this->Cell(70,10,$usu['nombre_producto'],1,0,'C',0);
            $this->Cell(38,10,$usu['cantidad'],1,0,'C',0);
            $this->Cell(36,10,"$".$usu['precio_p'],1,0,'C',0);
            $this->Cell(36,10,"$".$usu['total_pro'],1,1,'C',0);
              
            $subtotal= $subtotal+$usu['total_pro']; 
         /*  $tabla[]='{id:"'.$usu['id_producto'].'", cantidad:'.$usu['cantidad'].'},'; */
         $tabla[]= [$usu['id_producto'],$usu['cantidad']];
         

          endforeach;
          $iva=0.12*$subtotal;
          $total_final=$iva+$subtotal;

         $this->Ln(6);
         $this->SetFont('Arial','B',15);
         $this->Cell(160,10,'SubTotal: ',0,0,'R',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,"$".$subtotal,0,1,'S',0);
         $this->SetFont('Arial','B',15);
         $this->Cell(160,10,'Iva(12%): ',0,0,'R',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,"$".$iva,0,1,'S',0);
         $this->SetFont('Arial','B',15);
         $this->Cell(160,10,'Total: ',0,0,'R',0);
         $this->SetFont('Arial','',15);
         $this->Cell(80,10,"$".$total_final,0,1,'S',0);
      }


      
  
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

include("config/bd.php");
/* $consulta = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $consulta); */

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);

/* while ($row=$resultado->fetch_assoc()) {
	$pdf->Cell(80,10,$row['nombre'],1,0,'C',0);
	$pdf->Cell(50,10,$row['precio'],1,0,'C',0);
	$pdf->Cell(50,10,$row['stock'],1,1,'C',0);

}  */


	$pdf->Output();
?>