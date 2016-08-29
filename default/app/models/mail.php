<?php

class mail extends ActiveRecord
{

    public function envmail()
    {
        Load::lib('phpmailerlib');
        $correo = new PHPMailer();
        $correo->IsSMTP();
        $correo->SMTPAuth = true;
        $correo->SMTPSecure = 'tls';
        $correo->Host = 'smtp.gmail.com';
        $correo->Port= 587;
        $correo->Username = 'sergio1256@gmail.com';
        $correo->Password='34914417';
        //$correo->SetFrom=('sad_35842@hotmail.com', 'Primermail');
        $correo->From('sergio1256@gmail.com');
        $correo->FromName('Matriculacion salud jujuy');
        $correo->AddAddress('sergio1256@gmail.com');
        $correo->Subject='Primer mail PHP';
        $correo->MsgHTML("Mensaje Html!!!");
        
        if(!$correo->Send())
          {
            echo "Hubo un error: " . $correo->ErrorInfo;
          } else {
            echo "Mensaje enviado con exito.";
                }
   
    }
}

