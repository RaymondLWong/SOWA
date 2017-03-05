<?php
include "functions.php";
header('Content-type:  text/xml');

$rootNode = "listings";

function showError($msg) {
    $rootNode = "listings";
    die ('<' . $rootNode . '><error>' . $msg . '</error></' . $rootNode . '>');
}

if (
    isset($_REQUEST['title']) &&
    isset($_REQUEST['desc']) &&
    isset($_REQUEST['loc']) &&
    isset($_REQUEST['addr']) &&
    isset($_REQUEST['type']) &&
    isset($_REQUEST['minBeds']) &&
    isset($_REQUEST['maxBeds']) &&
    isset($_REQUEST['minCost']) &&
    isset($_REQUEST['maxCost']) &&
    isset($_REQUEST['limit']) &&
    isset($_REQUEST['offset'])
) {
    $title = trim($_REQUEST['title']);
    if ( preg_match("/[^a-zA-Z0-9 \-']|^$/",$title) )die ('<' . $rootNode . '/>');
} else {
    showError("incompatible search term");
}

$typeOfHousing = getHousingAsStr($_REQUEST['type']);

$args = array(
    'title' => $_REQUEST['title'],
    'desc' => $_REQUEST['desc'],
    'loc' => $_REQUEST['loc'],
    'addr' => $_REQUEST['addr'],
    'type' => $typeOfHousing,
    'minBeds' => $_REQUEST['minBeds'],
    'maxBeds' => $_REQUEST['maxBeds'],
    'minCost' => $_REQUEST['minCost'],
    'maxCost' => $_REQUEST['maxCost'],
    'limit' => $_REQUEST['limit'],
    'offset' => $_REQUEST['offset']
);
$queryString = http_build_query($args);

$client = new SoapClient('http://localhost:64153/search.asmx?WSDL');
$xmlResult = $client->lookupAll($args)->lookupAllResult->any;
$xmlDomFromPHP = new DOMDocument();
$xmlDomFromPHP->loadXML($xmlResult, LIBXML_NOBLANKS);

$url = 'http://localhost/SOWA/search.php?' . $queryString;
$xmlDomFromCSharp = new DOMDocument();
$xmlDomFromCSharp->load($url);

$xmlRoot1 = $xmlDomFromPHP->documentElement;
foreach ($xmlDomFromCSharp->documentElement->childNodes as $node2 ) {
    $node1 = $xmlDomFromPHP->importNode($node2,true);
    $xmlRoot1->appendChild($node1);
}

echo $xmlDomFromPHP->saveXML();
?>