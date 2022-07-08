<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include("config/bd.php");
$cor= $_GET['id'];
$sqlz = "SELECT *FROM usuarios where cedula=:co";
$consultarusu = $conexion->prepare($sqlz);
$consultarusu->bindParam(':co',$cor);
$consultarusu->execute();
$coun= $consultarusu->rowCount();
if($coun >0) {
    $usua=$consultarusu->fetch();
    $aleatorio=rand(10000, 99999);
    $_correoe=$usua['correo'];
    $nuevacontra="PetPlanet".$_correoe."".$cor."".$aleatorio;
    include("config/bd.php");
 
    $actualizarusauri= $conexion->prepare("UPDATE usuarios SET contrasenia=:contra WHERE cedula= :cor");
    $actualizarusauri->bindParam(':cor',$cor);
    $actualizarusauri->bindParam(':contra',$nuevacontra);
    $actualizarusauri->execute();


}

//Load Composer's autoloader
require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output  SMTP::DEBUG_SERVER;
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'petplanet7sa@gmail.com';                     //SMTP username
    $mail->Password   = 'adqwaghuxrunmofs';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('petplanet7sa@gmail.com', 'PetPlanet');
    $mail->addAddress($_correoe);     //Add a recipient



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Recuperación de contraseña';
    $mail->Body    = 'Esta es su nueva contraseña <b>'.$nuevacontra.'</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->CharSet =  'UTF-8';
    $mail->send();
    echo "envié el correo"?>
    <script>
      window.location.href = "<?php echo $url="http://".$_SERVER['HTTP_HOST']."/TIENDA_VETERINARIA";?>/login.php";
      
    </script>
    <?php
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    
   
}