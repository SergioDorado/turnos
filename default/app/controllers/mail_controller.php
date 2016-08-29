<?php


Load::models('mail');
class MailController extends AppController
{
     public function enviar()
      {
        Load::lib('email');
        $para_nombre = "Sergio";
        $asunto = "Mail de prueba"; //El asunto del correo
        $cuerpo = "Este es mi correo de prueba"; //Aquí va el contenido HTML 
        $para_correo = "sad_35842@hotmail.com"; //Correo destino

        //Email::sendContact($para_correo, $para_nombre, $asunto, $cuerpo);
        $mail = new mail();
        $mail->envmail();
      }
}
?>