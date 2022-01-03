<?php

    require './bibliotecas/phpMailer/Exception.php';
    require './bibliotecas/phpMailer/OAuth.php';
    require './bibliotecas/phpMailer/PHPMailer.php';
    require './bibliotecas/phpMailer/POP3.php';
    require './bibliotecas/phpMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;


    class Mensagem{
        private $email;
        private $assunto;
        private $mensagem;
        public function __get($attr){
            return $this->$attr;
        }
        public function __set($attr,$value){
            $this->$attr = $value;
        }
        public function mensagemValida(){
            $caracter = strpos($this->email,'@');
            if(!$caracter || empty($this->email)){
                return false;
            }
            if(empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;
        }

    }

    $mensagem = new Mensagem();
    $mensagem->__set('email',$_POST['email']);
    $mensagem->__set('assunto',$_POST['assunto']);
    $mensagem->__set('mensagem',$_POST['mensagem']);


    if(!$mensagem->mensagemValida()){
        echo 'Mensagem Inválida';
        die();
    }
    
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'testweb6663@gmail.com';                     //SMTP username
        $mail->Password   = 'Lennon1940';                               //SMTP password
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('testweb6663@gmail.com', 'Mailer');
        $mail->addAddress($mensagem->__get('email'));     //Add a recipient
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');

        $mail->send();
        header('Location:index.php?acao=true');
    }catch (Exception $e){
        echo 'Não foi possivel enviar esse email, tente novamnte mais tarde.<br>';
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>