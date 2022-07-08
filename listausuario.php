<?php include("plantillas/encabezado.php"); ?>
<?php
$cedula_sesion= $_SESSION['usuario'][0];
$nombre_sesion= $_SESSION['usuario'][1];
$tipo_sesion= $_SESSION['usuario'][2];
$actualizacion=false;

if($tipo_sesion== null || $tipo_sesion=="" || $tipo_sesion==1){?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
    
    die();
}
?>  
<br>
<h3 class="text-center"  style="font-family: sans-serif; margin-top: 0.3rem;">Usuarios registrados</h3>
<br>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="table-responsive">
            <table id="example"class="table table-striped table-hover table-bordered">
            <thead style="background-color: #7FB3D5 ">
                <tr class="text-center">
                <th scope="col" class="asc">#</th>
                <th scope="col">Cédula</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Dirección</th>
                <th scope="col">Correo</th>
                </tr>
            </thead>
            <tbody style="background-color: #82E0AA ">
            <?php include("config/bd.php");
                $sql = "SELECT *FROM usuarios";
                $consultarusu = $conexion->prepare($sql);
                $consultarusu->execute();
                $count= $consultarusu->rowCount();
                if($count >0) {
                    $usuarioscli=$consultarusu->fetchAll();
                }
                $contador=0;
                foreach($usuarioscli as $usu):?>
                <tr>
                <th scope="row"><?php echo $contador=$contador+1?></th>
                <td>0<?php echo$usu['cedula']?></td>
                <td><?php echo $usu['nombres']?></td>
                <td><?php echo $usu['apellidos']?></td>
                <td><?php echo $usu['direccion']?></td>
                <td><?php echo $usu['correo']?></td>
                
                </tr>
                <?php endforeach;?>
                
            </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <br>
</div>
<br><br><br><br><br>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="tabla.js"></script>



<?php include("plantillas/footer.php"); ?>