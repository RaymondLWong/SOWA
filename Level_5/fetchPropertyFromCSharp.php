<?php

include "../common/functions.php";

if (isset($_REQUEST['propID'])) {
    $propID = $_REQUEST['propID'];
    $queryString = "propertyID={$propID}";

    $url = getISSHost() . '/search.asmx/lookup?' . $queryString;
    $propXML = queryIISWebService($url);

    $headings = getHeadings();
    $html = getSinglePropertyScaffold();

    $properties = $propXML->firstChild->childNodes;

    $html .= "<tr><td>{$propID}</td>";

    for ($i = 0; $i < $properties->length; $i++) {
        $node = $properties->item($i)->nodeValue;
        $html .= "<td>{$node}</td>";
    }

    $html .= "</tr></table>";

    $imageUrl = getISSHost() . '/search.asmx/fetchImages?' . $queryString;
    $imageXML = queryIISWebService($imageUrl);

    $images = $imageXML->firstChild->childNodes;

    if ($images->length > 0) {
        $html .= getImageTableHTML();

        $findImageUrl = getISSHost() . '/search.asmx/findImage?pictureID=';

        for ($j = 0; $j < $images->length; $j++) {
            $imageNode = $images->item($j)->nodeValue;

            // get the IIS hosted image location (if available)
            $imageLocXML = queryIISWebService($findImageUrl . $imageNode);
            $imageLoc = $imageLocXML->firstChild->nodeValue;
            $imageLoc = ($imageLoc != null) ? returnImageTag($imageLoc) : getImageNotFoundOnServerError($imageNode, getISSHost());

            $html .= "<td>{$imageLoc}</td>";
        }

        $html .= "</table></tr>\r\n";
    } else {
        $html .= getNoImagesAvailable($propID);
    }


    $html .= "</body></html>";

    echo $html;
}