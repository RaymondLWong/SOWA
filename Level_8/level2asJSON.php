<?php

include "../common/functions.php";

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
    $queryString = http_build_query($args);

    $url = getISSHost() . '/search.asmx/lookupAll?' . $queryString;
    $xmlResult = file_get_contents($url);

    $xml = new DOMDocument();
    $xml->loadXML($xmlResult, LIBXML_NOBLANKS);

    $xslt = new XSLTProcessor();
    $xslDoc = new DOMDocument();
    $xslDoc->load('XML2JSON.xsl', LIBXML_NOCDATA);
    $xslt->importStylesheet($xslDoc);

    header('Content-Type: application/json');
    echo $xslt->transformToXML($xml);
}
?>