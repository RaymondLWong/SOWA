<?php
header('Content-type: text/xml');

if ( true /* isset($_POST['searchTerm']) */) {
    $_POST['searchTerm'] = 'desc';
    $client = new SoapClient('http://localhost:64153/search.asmx?WSDL');

    $xmlResult = $client->lookup($_POST)->lookupResult->any;

    $xmlDom = new DOMDocument();
    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);

    echo $xmlDom->saveXML();
}
?>