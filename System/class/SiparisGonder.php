<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 17.10.2014
 * Time: 15:33
 */

class SiparisGonder {

    private $CustomerMail;
    private $MessageToAdmin;
    private $MessageToCustomer;

    public function __construct(){

        $this->MessageToAdmin = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $this->MessageToCustomer = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';

    }

    public function Domain(Siparis $Siparis){

        $this->CustomerMail = $Siparis->Mail();

        $this->MessageToAdmin .= "<br />";
        $this->MessageToAdmin .= "<b> # Alan Adı siparişi bildirimi #</b><br />";
        $this->MessageToAdmin .= "<b> Adı Soyadı : </b>" . $Siparis->Name() . "<br />";
        $this->MessageToAdmin .= "<b> Telefonu : </b>" . $Siparis->Phone() . "<br />";
        $this->MessageToAdmin .= "<b> E-Posta Adresi : </b>" . $Siparis->Mail() . "<br />";
        $this->MessageToAdmin .= "<b> Alan Adı : </b>" . $Siparis->Domain() . "<br />";
        $this->MessageToAdmin .= "<br />";

        $this->MessageToCustomer .= "<br />";
        $this->MessageToCustomer .= "Sayın " . $Siparis->Name() . ",<br />";
        $this->MessageToCustomer .= $Siparis->Domain() . " isimli Alan Adı siparişiniz alınmıştır.<br />";
        $this->MessageToCustomer .= "En kısa süre içerisinde size geri dönüş yapılacaktır.<br />";
        $this->MessageToCustomer .= "<br />";

    }

    public function Hosting(Siparis $Siparis){

        $this->CustomerMail = $Siparis->Mail();

        $this->MessageToAdmin .= "<br />";
        $this->MessageToAdmin .= "<b> # Hosting siparişi bildirimi #</b><br />";
        $this->MessageToAdmin .= "<b> Adı Soyadı : </b>" . $Siparis->Name() . "<br />";
        $this->MessageToAdmin .= "<b> Telefonu : </b>" . $Siparis->Phone() . "<br />";
        $this->MessageToAdmin .= "<b> E-Posta Adresi : </b>" . $Siparis->Mail() . "<br />";
        $this->MessageToAdmin .= "<b> Hosting Planı : </b>" . $Siparis->Plan() . " - " . $Siparis->Price() . "<br />";
        $this->MessageToAdmin .= "<br />";

        $this->MessageToCustomer .= "<br />";
        $this->MessageToCustomer .= "Sayın " . $Siparis->Name() . ",<br />";
        $this->MessageToCustomer .= $Siparis->Plan() . " - " . $Siparis->Price() . " isimli Hosting Pakedi siparişiniz alınmıştır.<br />";
        $this->MessageToCustomer .= "En kısa süre içerisinde size geri dönüş yapılacaktır.<br />";
        $this->MessageToCustomer .= "<br />";

    }

    public function Send(){

        require_once 'config.inc';
        require_once 'class.smtp.php';
        require_once 'SMTP.PHP';

        $SentToAdmin = FALSE;
        $SentToCustomer = FALSE;

        /*
         *
         * Test Of SMTP Connection By Musa ATALAY
         *
         * $Server = new SMTP;

        $Server->do_debug = SMTP::DEBUG_CONNECTION;

        try{

            if($Server->connect(SETTINGS::$SMTP_HOST, SETTINGS::$SMTP_PORT)){

                if($Server->hello("159.146.37.70")){

                    if($Server->authenticate(SETTINGS::$SMTP_USER, SETTINGS::$SMTP_PASSWORD)){

                        exit("Connected OK!");

                    } else {
                        throw new Exception('Authentication failed: ' . $Server->getLastReply());
                    }

                } else {
                    throw new Exception('HELO failed: '. $Server->getLastReply());
                }

            } else {
                throw new Exception('Connect failed');
            }

        }catch (Exception $Err){

            echo 'SMTP error: '. $Err->getMessage(), "\n";

            $Server->quit(true);

        }*/

        $SMTP = new PHPMailer;

        $SMTP->SMTPKeepAlive = true;
        $SMTP->isSMTP();
        $SMTP->SMTPDebug = 0;
        $SMTP->Host     = trim(SETTINGS::$SMTP_HOST);
        $SMTP->SMTPAuth = true;
        $SMTP->Username = trim(SETTINGS::$SMTP_USER);
        $SMTP->Password = trim(SETTINGS::$SMTP_PASSWORD);
        $SMTP->SMTPSecure = SETTINGS::$SECURE;
        $SMTP->Port = trim(SETTINGS::$SMTP_PORT);

        $SMTP->IsHTML(SETTINGS::$IS_HTML);
        $SMTP->setLanguage('tr', './class/');
        $SMTP->SMTPKeepAlive = true;
        $SMTP->ContentType = "text/html";
        $SMTP->CharSet = "utf-8";
        $SMTP->From     = trim(SETTINGS::$SENDER_MAIL);
        $SMTP->Sender   = trim(SETTINGS::$SENDER_MAIL);
        $SMTP->FromName = trim(SETTINGS::$TITLE);
        $SMTP->setFrom(trim(SETTINGS::$SENDER_MAIL), "Akasya Bilişim");
        $SMTP->addReplyTo(trim(SETTINGS::$SENDER_MAIL),"Akasya Bilişim");

        $SMTP->Subject  = "Siparis Bildirimi";
        $SMTP->WordWrap = 50;

        $SMTP->Body = $this->MessageToAdmin;
        $SMTP->msgHTML($this->MessageToAdmin);
        $SMTP->AltBody = $this->MessageToAdmin;

        $SMTP->addAddress(trim(SETTINGS::$ADMIN_MAIL));

        if($SMTP->Send()){

            $SentToAdmin = TRUE;

        }

        $SMTP->ClearAddresses();
        $SMTP->ClearAttachments();


        $SMTP->Body = $this->MessageToCustomer;
        $SMTP->AltBody = $this->MessageToCustomer;

        $SMTP->addAddress(trim($this->CustomerMail));

        if($SMTP->Send()){

            $SentToCustomer = TRUE;

        }

        $SMTP->ClearAddresses();
        $SMTP->ClearAttachments();


        header("Content-Type: application/json; charset=utf-8");

        if($SentToAdmin){

             if($SentToCustomer){

                 exit(json_encode(array(
                     "response" => $SentToAdmin
                 )));

             }else{

                 exit(json_encode(array(
                     "response" => $SentToAdmin,
                     "ErrNo" => 2,
                     "message" => $SMTP->ErrorInfo
                 )));

             }

        }else{

            exit(json_encode(array(
                "response" => $SentToAdmin,
                "ErrNo" => 1,
                "message" => $SMTP->ErrorInfo
            )));

        }

    }

}

?>