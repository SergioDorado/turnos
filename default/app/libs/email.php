<?php



class Email {
    
       public static function send($para_correo, $para_nombre, $asunto, $cuerpo, $de_correo=null, $de_nombre=null) {
        //Carga las librería PHPMailer
        Load::lib('phpmailer');
        //instancia de PHPMailer
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
        $mail->Host =  'smtp.live.com';//Config::get('config.correo.host');
        $mail->Port = 25; //Config::get('config.correo.port');
        $mail->Username = 'sad_35842@hotmail.com' ;//Config::get('config.correo.username');
        $mail->Password = '';//Config::get('config.correo.password');
        if ($de_correo != null && $de_nombre != null) {
            $mail->AddReplyTo($de_correo, $de_nombre);
            $mail->From = $de_correo;
            $mail->FromName = $de_nombre;
        } else {
            $mail->AddReplyTo('sad_35842@hotmail.com'/*Config::get('config.correo.from_mail')*/,'Sergio' /*Config::get('config.correo.from_name')*/);
            $mail->From ='sad_35842@hotmail.com' ;//Config::get('config.correo.from_mail');
            $mail->FromName = 'Sergio' ;//Config::get('config.correo.from_name');
        }
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        $mail->WordWrap = 50; // set word wrap
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($para_correo, $para_nombre);
        $mail->IsHTML(true); // send as HTML
        $mail->SetLanguage('es');
        //Enviamos el correo
        $exito = $mail->Send();
        $intentos = 2;
        //esto se realizara siempre y cuando la variable $exito contenga como valor false
        while ((!$exito) && $intentos < 1) {
            sleep(5);
            $exito = $mail->Send();
            $intentos = $intentos + 1;
        }
        $mail->SmtpClose();
        return $exito;
    }
    
    public static function sendContact($de_correo, $de_nombre, $asunto, $cuerpo) {
        //Carga las librería PHPMailer
        Load::lib('phpmailer');
        //instancia de PHPMailer
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
        $mail->Host = 'smtp.gmail.com';//Config::get('config.correo.host');
        $mail->Port = 587; //Config::get('config.correo.port');
        $mail->Username = 'sergio1256@gmail.com';//Config::get('config.correo.username');
        $mail->Password = '34914417';//Config::get('config.correo.password');
        
        $mail->AddReplyTo($de_correo, $de_nombre);
        $mail->From = $de_correo;
        $mail->FromName = $de_nombre;        
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        $mail->WordWrap = 50; // set word wrap
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress(Config::get('config.sitio.email'), Config::get('config.sitio.nombre'));
        $mail->IsHTML(true); // send as HTML
        $mail->SetLanguage('es');
        //Enviamos el correo
        $exito = $mail->Send();
        $intentos = 2;
        //esto se realizara siempre y cuando la variable $exito contenga como valor false
        while ((!$exito) && $intentos < 1) {
            sleep(5);
            $exito = $mail->Send();
            $intentos = $intentos + 1;
        }
        $mail->SmtpClose();
        return $exito;
    }
}
?>