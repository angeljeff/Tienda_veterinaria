<?php include("plantillas/encabezado.php"); ?>  
<?php
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;
if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==2){?>
  <script>
    window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
    
  </script>
  <?php
   
    die();
}?>

<h3  class="text-center" style="font-family: sans-serif; margin-top: 2rem;">PANEL DE CONTROL</h3>
      
      <div class="container" >
      <?php $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA"?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4"  >
          <div class="col" >
            <div class="card shadow-sm w-75 tarjeta" style="border-radius: 8%;" >
              <img src="imagenes/ordenador-portatil.png" alt="" style="width: 70%;margin:auto; max-height:18rem; height: 15rem; border-radius: 3%; ">
  
              <div class="card-body tarjeta">
                <h3 class="card-title text-center" style="margin-bottom: -1rem;">Mis datos </h3>
                <hr>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6 d-flex">
                      <br>
                    </div>
                    <div class="col-md-6 d-flex">
                     <br>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12 text-center">
                    <a href="<?php echo $url;?>/misdatos.php"><button type="button" class="btn text-center border border-secondary" style=" width: 6rem; font: condensed 120% sans-serif; background:  #A9E2F3;">IR</button></a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col" >
            <div class="card shadow-sm w-75 tarjeta" style="border-radius: 8%;" >
           <img src="imagenes/documento.png" alt="" style="width: 70%;margin:auto; max-height:18rem; height: 15rem; border-radius: 3%;">
  
              <div class="card-body tarjeta">
                <h3 class="card-title text-center" style="margin-bottom: -1rem;">Mis pedidos </h3>
                <hr>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6 d-flex">
                      <br>
                    </div>
                    <div class="col-md-6 d-flex">
                     <br>
                    </div>
                  </div>
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12 text-center">
                    <a href="<?php echo $url;?>/reportes.php"><button type="button" class="btn text-center border border-secondary" style=" width: 6rem; font: condensed 120% sans-serif; background:  #A9E2F3;">IR</button></a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>


    
        </div>
      </div>
      <br><br><br><br>

<?php include("plantillas/footer.php"); ?>