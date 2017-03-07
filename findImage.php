<?php

include "functions.php";

if (isset($_REQUEST['picID'])) {
    $xmlDom = new DOMDocument();
    $xmlDom->appendChild($xmlDom->createElement("location"));
    $xmlRoot = $xmlDom->documentElement;

    $picID = findImage($_REQUEST['picID']);

    if ($picID != "") {
        $picID = "http://" . $_SERVER['HTTP_HOST'] . str_replace('findImage.php', $picID, $_SERVER['PHP_SELF']);

//        $picID = "self: " . $_SERVER['PHP_SELF'] . " , req: " . $currentPage;
    }

    $xmlTxt = $xmlDom->createTextNode($picID);
    $xmlRoot->appendChild($xmlTxt);

    header('Content-type:  text/xml');
    echo $xmlDom->saveXML();
}

?>