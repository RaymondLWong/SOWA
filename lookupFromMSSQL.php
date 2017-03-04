<?php

// static only version, revert history for search version that appends XML
if ( true /* !empty($_POST) */) {

    $_POST['searchTerm'] = 'desc';
    $client = new SoapClient('http://localhost:64153/search.asmx?WSDL');

    $xmlResult = $client->lookup($_POST)->lookupResult->any;

    $xmlDom = new DOMDocument();
    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);

    header('Content-type: text/xml');
    echo $xmlDom->saveXML(); // TODO: redirect or fix return as XML
}
?>