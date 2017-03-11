<?php

include "functions.php";

if (isset($_REQUEST['propID'])) {
    $propID = $_REQUEST['propID'];
    $queryString = "propertyID={$propID}";

    $url = getISSHost() . '/search.asmx/lookup?' . $queryString;
    $xmlResult = file_get_contents($url);
    $propXML = new DOMDocument();
    $propXML->loadXML($xmlResult, LIBXML_NOBLANKS);

    $headings = getHeadings();
    $html = getSinglePropertyScaffold();

    $data = $propXML->firstChild->childNodes;

    $html .= "<tr><td>{$propID}</td>";

    for ($i = 0; $i < $data->length; $i++) {
        $node = $data->item($i)->nodeValue;
        $html .= "<td>{$node}</td>";
    }

    $html .= "</tr></table>";

//    $imageUrl = getISSHost() . '/search.asmx/fetchImages?' . $queryString;
//    $xmlResult = file_get_contents($url);
//    $propXML = new DOMDocument();
//    $propXML->loadXML($xmlResult, LIBXML_NOBLANKS);

    $html .= "</body></html>";

    echo $html;
}