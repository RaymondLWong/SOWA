<?php

include "../common/functions.php";

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

    // convert the drop-down option into a string value
    $typeOfHousing = getHousingAsStr($_POST['type']);

    // build the GET params
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

    // request the XML from the aggregate web service
    $url = getLevelFromHost(2, 4) . 'aggregate.php?' . $queryString;
    $xml = new DOMDocument();
    $xml->load($url);

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

    // setup the constants for distinguishing between DB sources
    // and the target web service that will display all of a property's information
    $PHP_SOURCE = "PHP";
    $C_SHARP_SOURCE = "CSharp";

    $PHP_TARGET = "fetchProperty";
    $C_SHARP_TARGET = "fetchPropertyFromCSharp";

    $data = $xml->firstChild->childNodes;

    // loop through each child node of root (Property)
    for ($i = 0; $i < $data->length; $i++) {
        $tableRow = "<tr>\r\n";
        $propertyNode = $data->item($i);
        $property = $propertyNode->childNodes;
        $source = $propertyNode->getAttribute("source");

        // loop through each child node of Property
        for ($j = 0; $j < $property->length; $j++) {
            $node = $property->item($j);
            $tableData = trim($node->nodeValue);

            // if the field is the image, fetch the image from web service and display it
            if ($node->nodeName == "PictureID" && $tableData != "") {
                // TODO: tidy up below
                if ($source == $PHP_SOURCE) {
                    $currentPage = $_SERVER['REQUEST_URI'];
                    $url = getApacheHost() . str_replace('realPortal.php', 'findImage.php?picID=' . $tableData, $currentPage);

                    $xml = new DOMDocument();
                    $xml->load($url);
                    $imagePath = $xml->firstChild->nodeValue;

                    if ($imagePath != null) {
                        $tableData = "<img src='{$imagePath}' />";
                    } else {
                        $tableData = getImageNotFoundOnServerError($tableData, getApacheHost());
                    }
                } else if ($source == $C_SHARP_SOURCE) {
                    $cUrl = getISSHost() . "/search.asmx/findImage?pictureID=" . $tableData;
                    $xmlResult = file_get_contents($cUrl);
                    $xmlDom = new DOMDocument();
                    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);
                    $cImagePath = $xmlDom->firstChild->nodeValue;

                    if ($cImagePath != null) {
                        $tableData = "<img src='{$cImagePath}' />";
                    } else {
                        $tableData = getImageNotFoundOnServerError($tableData, getISSHost());
                    }
                }
            }

            // add the property's information to the table
            $tableRow .= "    <td>" . $tableData . "</td>\r\n";
        }

        // set the target destination for the "more information" hyperlink
        // PHP target for PHP source, C# target for C# source
        // blank if the source is unknown / invalid
        $target = "";

        if ($source == $PHP_SOURCE) {
            $target = $PHP_TARGET;
        } else if ($source == $C_SHARP_SOURCE) {
            $target = $C_SHARP_TARGET;
        }

        // get the propoerty's ID
        $propID = $property->item(0)->nodeValue;

        // if the target is blank don't create a hyperlink, display an error instead
        $target = ($target != null) ? "<a href='{$target}.php?propID={$propID}'>Click here for more information</a>"
            : "Property could not be found.";
        $tableRow .= "<td>{$target}</td>";
        // append the row data to the HTML table
        $html .= $tableRow . "</tr>\r\n";
    }

    echo $html . "</table>";
}

?>