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
    <th>More information</th>
</tr>
";

    // loop through each child node of root (Property)
    for ($i = 0; $i < $data->length; $i++) {
        $tableRow = "<tr>\r\n";
        $propertyNode = $data->item($i);
        $property = $propertyNode->childNodes;

        // loop through each child node of Property
        for ($j = 0; $j < $property->length; $j++) {
            $node = $property->item($j);
            $tableData = trim($node->nodeValue);

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
                } else if ($source == "CSharp") {
//                    $tableData = "image: |{$tableData}|";

                    $cUrl = getISSHost() . "/search.asmx/findImage?pictureID=" . $tableData;
                    $xmlResult = file_get_contents($cUrl);
                    $xmlDom = new DOMDocument();
                    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);
                    $cImagePath = $xmlDom->firstChild->nodeValue;

                    if ($cImagePath != null) {
                        $tableData = "<img src='{$cImagePath}' />";
                    }
                }
            }

            $tableRow .= "    <td>" . $tableData . "</td>\r\n";
        }

        $propID = $property->item(0)->nodeValue;
        $tableRow .= "<td><a href='fetchProperty.php?propID={$propID}'>Click here for more information</a></td>";

        $html .= $tableRow . "</tr>\r\n";
    }

    echo $html . "</table>";
}

?>