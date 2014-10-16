<?php
/**
 * Created by PhpStorm.
 * User: musaatalay
 * Date: 16.10.2014
 * Time: 13:16
 */

    require_once 'class/whois.php';

    $Domain = str_replace(array("http://","www."), NULL, strtolower(@$_REQUEST["domain_name"]));

    //$Domain = "google.com";

    $Whois = new Phois\Whois\Whois($Domain);

    //echo $Whois->info();

    header("Content-Type: application/json; charset=utf-8");

    $Avaible = FALSE;

    if ($Whois->isAvailable()) {

        $Avaible = TRUE;

    }

    echo json_encode(array(
        "available" => $Avaible
    ));

?>