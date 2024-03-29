<?php
include "../common/functions.php";

$rootNode = "listings";

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

// TODO: add some validation in case of odd values?
// half because 2x databases will be queried
// MS SQL requires the limit to be greater than 0, or it'll throw an error
$limit = intval($_REQUEST['limit'] / 2);
$limit = ($limit >= 2) ? $limit : 1;

$args = array(
    'title' => $_REQUEST['title'],
    'desc' => $_REQUEST['desc'],
    'loc' => $_REQUEST['loc'],
    'addr' => $_REQUEST['addr'],
    'type' => $_REQUEST['type'],
    'minBeds' => $_REQUEST['minBeds'],
    'maxBeds' => $_REQUEST['maxBeds'],
    'minCost' => $_REQUEST['minCost'],
    'maxCost' => $_REQUEST['maxCost'],
    'limit' => $limit,
    'offset' => $_REQUEST['offset']
);
$queryString = http_build_query($args);

$url = getISSHost() . '/search.asmx/lookupAll?' . $queryString;
$xmlResult = file_get_contents($url);
$xmlDomFromPHP = new DOMDocument();
$xmlDomFromPHP->loadXML($xmlResult, LIBXML_NOBLANKS);

$url = getLevelFromHost(0, 3) . 'search.php?' . $queryString;
$xmlDomFromCSharp = new DOMDocument();
$xmlDomFromCSharp->load($url);

// if the XML from both web services are valid, combine them and return the result
if (validateXML($rootNode, $xmlDomFromPHP) && validateXML($rootNode, $xmlDomFromCSharp)) {
    $xmlRoot1 = $xmlDomFromPHP->documentElement;
    foreach ($xmlDomFromCSharp->documentElement->childNodes as $node2 ) {
        $node1 = $xmlDomFromPHP->importNode($node2,true);
        $xmlRoot1->appendChild($node1);
    }

    header('Content-type:  text/xml');
    echo $xmlDomFromPHP->saveXML();
} else {
    showError("Invalid XML");
}

?>