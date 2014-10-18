<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 17.10.2014
 * Time: 15:45
 */

    ob_start();

    require_once 'class/Siparis.php';
    require_once 'class/SiparisGonder.php';

    $Siparis = new Siparis(@$_REQUEST);

    $SiparisGonder = new SiparisGonder();

    if($Siparis->isDomain()){

        $SiparisGonder->Domain($Siparis);

    }

    if($Siparis->isHosting()){

        $SiparisGonder->Hosting($Siparis);

    }

    $SiparisGonder->Send();

?>