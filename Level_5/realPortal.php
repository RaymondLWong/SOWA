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

    $url = getHost() . '/SOWA/Level_4/aggregate.php?' . $queryString;
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

$PHP_SOURCE = "PHP";
$C_SHARP_SOURCE = "CSharp";

$PHP_TARGET = "fetchProperty";
$C_SHARP_TARGET = "fetchPropertyFromCSharp";

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
                if ($source == $PHP_SOURCE) {

                    $currentPage = $_SERVER['REQUEST_URI'];
                    $url = getHost() . str_replace('realPortal.php', 'findImage.php?picID=' . $tableData, $currentPage);

                    $xml = new DOMDocument();
                    $xml->load($url);
                    $imagePath = $xml->firstChild->nodeValue;

                    if ($imagePath != null) {
                        $tableData = "<img src='{$imagePath}' />";
                    }
                } else if ($source == $C_SHARP_SOURCE) {
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
        // set the target destination for the "more information" hyperlink
        // PHP target for PHP source, C# target for C# source
        // blank if the source is unknown / invalid
        $target = ($source == $PHP_SOURCE)
            ? $PHP_TARGET
            : ($source == $C_SHARP_SOURCE)
                ? $C_SHARP_TARGET
                : "";

        // if the target is blank don't create a hyperlink, display an error instead
        $target = ($target != null)
            ? "<a href='{$target}.php?propID={$propID}'>Click here for more information</a>"
            : "Property could not be found.";
        $tableRow .= "<td>{$target}</td>";

        $html .= $tableRow . "</tr>\r\n";
    }

    echo $html . "</table>";
}

?>