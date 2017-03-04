<?php
header('Content-type:  text/xml');

$rootNode = "listings";

function showError($msg) {
    $rootNode = "listings";
    die ('<' . $rootNode . '><error>' . $msg . '</error></' . $rootNode . '>');
}

if ( isset($_REQUEST['name']) ) {
    $nq = trim($_REQUEST['name']);
    if ( preg_match("/[^a-zA-Z0-9 \-']|^$/",$nq) )die ('<' . $rootNode . '/>');
} else {
    showError("incompatible search term");
}

$args = array('searchTerm'=>$nq);
$client = new SoapClient('http://localhost:64153/search.asmx?WSDL');
$xmlResult = $client->lookup($_POST)->lookupResult->any;
$xmlDomFromPHP = new DOMDocument();
$xmlDomFromPHP->loadXML($xmlResult, LIBXML_NOBLANKS);

$url = 'http://localhost/SOWA/search.php?name=' . $nq;
$xmlDomFromCSharp = new DOMDocument();
$xmlDomFromCSharp->load($url);

$xmlRoot1 = $xmlDomFromPHP->documentElement;
foreach ($xmlDomFromCSharp->documentElement->childNodes as $node2 ) {
    $node1 = $xmlDomFromPHP->importNode($node2,true);
    $xmlRoot1->appendChild($node1);
}

echo $xmlDomFromPHP->saveXML();
?>