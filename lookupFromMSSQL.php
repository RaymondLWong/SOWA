<?php

// static only version, revert history for search version that appends XML
if ( true /* !empty($_POST) */) {

    $args = array(
        'title' => 'title',
        'desc' => 'desc',
        'loc' => 'loc',
        'addr' => 'addr',
        'type' => 'House',
        'minBeds' => 1,
        'maxBeds' => 4,
        'minCost' => 1,
        'maxCost' => 10 * 1000,
        'limit' => 25,
        'offset' => 0
    );

    $client = new SoapClient(getISSHost() . '/search.asmx?WSDL');

    $xmlResult = $client->lookupAll($args)->lookupAllResult->any;

    $xmlDom = new DOMDocument();
    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);

    header('Content-type: text/xml');
    echo $xmlDom->saveXML(); // TODO: redirect or fix return as XML
}
?>