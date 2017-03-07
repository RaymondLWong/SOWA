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
        $property = $data->item($i)->childNodes;

        // loop through each child node of Property
        for ($j = 0; $j < $property->length; $j++) {
            $tableData = $property->item($j)->nodeValue;
            $tableRow .= "    <td>" . $tableData . "</td>\r\n";
        }

        $html .= $tableRow . "</tr>\r\n";
    }

    echo $html . "</table>";
}

?>