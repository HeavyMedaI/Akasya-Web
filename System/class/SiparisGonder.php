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
        $this->MessageToAdmin .= "<b> Alan Adı siparişi bildirimi :</b><br />";
        $this->MessageToAdmin .= "<b> Adı Soyadı :</b>" . $Siparis->Name() . " " . $Siparis->Surname() . "<br />";
        $this->MessageToAdmin .= "<b> Telefonu :</b>" . $Siparis->Phone() . "<br />";
        $this->MessageToAdmin .= "<b> E-Posta Adresi :</b>" . $Siparis->Mail() . "<br />";
        $this->MessageToAdmin .= "<b> Alan Adı :</b>" . $Siparis->Domain() . "<br />";
        $this->MessageToAdmin .= "<br />";

    }

    public function Hosting(Siparis $Siparis){

        $this->CustomerMail = $Siparis->Mail();

    }

    public function Send(){

        require_once 'config.inc';
        require_once 'SMTP.PHP';

        $SentToAdmin = FALSE;
        $SentToCustomer = FALSE;

        $SMTP = new SMTP;
        $SMTP->ContentType = "text/html";
        $SMTP->CharSet = "utf-8";
        $SMTP->From     = trim($Settings->sender_mail);
        $SMTP->Sender   = trim($Settings->sender_mail);
        $SMTP->addReplyTo(trim($Settings->sender_mail),"Siparis Bildirimi");
        $SMTP->FromName = trim($Settings->title);
        $SMTP->Host     = trim($Settings->smtp_host);
        $SMTP->Port = trim($Settings->smtp_port);
        $SMTP->SMTPAuth = TRUE;
        $SMTP->Username = trim($Settings->smtp_user);
        $SMTP->Password = trim($Settings->smtp_password);
        $SMTP->WordWrap = 50;
        $SMTP->Subject  = "Siparis Bildirimi";

        $SMTP->IsHTML($Settings->isHTML);

        $SMTP->Body = $this->MessageToAdmin;
        $SMTP->AltBody = $this->MessageToAdmin;

        $SMTP->AddAddress(trim($Settings->admin_mail));

        if($SMTP->Send()){

            $SentToAdmin = TRUE;

        }

        $SMTP->ClearAddresses();
        $SMTP->ClearAttachments();

        /*
         *   Mail To Customer

        $SMTP->Body = $this->MessageToCustomer;
        $SMTP->AltBody = $this->MessageToCustomer;

        $SMTP->AddAddress(trim($this->CustomerMail));

        $SMTP->Send();

        $SMTP->ClearAddresses();
        $SMTP->ClearAttachments();

        */

        header("Content-Type: application/json; charset=utf-8");

        if($SentToAdmin){

             exit(json_encode(array(
                 "response" => $SentToAdmin
             )));

        }else{

            exit(json_encode(array(
                "response" => $SentToAdmin,
                "message" => $SMTP->ErrorInfo
            )));

        }

    }

}

?>