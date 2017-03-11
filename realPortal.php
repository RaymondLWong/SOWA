<?php

include "functions.php";

if (isset($_POST['submit'])) {
    echo getScaffoldingPart1(
        $_POST['minBeds'],
        $_POST['maxBeds'],
        $_POST['minCost'],
        $_POST['maxCost']
    );
} else {
    echo getScaffoldingPart1();
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

<?php

if (isset($_POST['submit'])) {
    echo getScaffoldingPart2(
        $_POST['title'],
        $_POST['desc'],
        $_POST['loc'],
        $_POST['addr'],
        $_POST['type'],
        $_POST['limit'],
        $_POST['offset']
    );
} else {
    echo getScaffoldingPart2();
}

if (isset($_POST['submit'])) {

    $typeOfHousing = getHousingAsStr($_POST['type']);

    $args = array(
        'title' => $_POST['title'],
        'desc' => $_POST['desc'],
        'loc' => $_POST['loc'],
        'addr' => $_POST['addr'],
        'type' => $typeOfHousing,
        'minBeds' => $_POST['minBeds'],
        'maxBeds' => $_POST['maxBeds'],
        'minCost' => $_POST['minCost'],
        'maxCost' => $_POST['maxCost'],
        'limit' => $_POST['limit'],
        'offset' => $_POST['offset']
    );
    $queryString = http_build_query($args);

    $url = 'http://localhost/SOWA/aggregate.php?' . $queryString;
    $xml = new DOMDocument();
    $xml->load($url);

    $data = $xml->firstChild->childNodes;

    echo $data->length;

    $html = "
<table>
<tr>
    <th>PropertyID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Type</th>
    <th>Location</th>
    <th>NoOfBeds</th>
    <th>CostPerWeek</th>
    <th>Address</th>
    <th>Email</th>
    <th>Picture</th>
</tr>
";

    /**
     * TODO:
     * - add pagination
     * - reduce content so only brief details
     * - make it clickable (like first term) so see more detail view
     * - show images somewhere (maybe 1 in briefl, all in full - like first term)
     */

    // loop through each child node of root (Property)
    for ($i = 0; $i < $data->length; $i++) {
        $tableRow = "<tr>\r\n";
        $propertyNode = $data->item($i);
        $property = $propertyNode->childNodes;

        // loop through each child node of Property
        for ($j = 0; $j < $property->length; $j++) {
            $node = $property->item($j);
            $tableData = $node->nodeValue;

            // if the field is the image, fetch the image from web service and display it
            if ($node->nodeName == "PictureID" && $tableData != "") {
                $source = $propertyNode->getAttribute("source");
                if ($source == "PHP") {

                    $currentPage = $_SERVER['REQUEST_URI'];
                    $url = getHost() . str_replace('realPortal.php', 'findImage.php?picID=' . $tableData, $currentPage);

                    $xml = new DOMDocument();
                    $xml->load($url);
                    $imagePath = $xml->firstChild->nodeValue;

                    if ($imagePath != null) {
                        $tableData = "<img src='{$imagePath}' />";
                    }
                } else if ($source == "C#") {
                    $args = array(
                        'pictureID' => $tableData
                    );
                    $cUrl = "http://localhost:64153/search.asmx/lookupAll?picID=" . $tableData;
                    $xmlResult = file_get_contents($cUrl);
                    $xmlDom = new DOMDocument();
                    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);
                    $imagePath = $xmlDom->firstChild->nodeValue;

                    if ($imagePath != null) {
                        $tableData = "<img src='{$imagePath}' />";
                    }
                }
            }

            $tableRow .= "    <td>" . $tableData . "</td>\r\n";
        }

        $html .= $tableRow . "</tr>\r\n";
    }

    echo $html . "</table>";
}

?>