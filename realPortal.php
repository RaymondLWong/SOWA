<form action="realPortal.php" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search"/>
</form>
<p>
<?php

if (!empty($_POST)) {
    $url = 'http://localhost/SOWA/aggregate.php?name=' . $_POST['search'];
    $xml = new DOMDocument();
    $xml->load($url);

    $data = $xml->firstChild->childNodes;
//    echo "1: " . $data->item(0)->nodeValue . "\r\n";
//    echo "2: " . $data->item(0)->firstChild->nodeValue . "\r\n";
    $html = "
<table>
<tr>
    <th>Title</th>
    <th>Description</th>
    <th>Type</th>
    <th>Location</th>
    <th>NoOfBeds</th>
    <th>CostPerWeek</th>
    <th>Address</th>
    <th>Email</th>
</tr>";

    for ($i = 0; $i < $data->length; $i++) {
        $tableRow = "<tr>";
        $property = $data->item($i)->childNodes;

        for ($j = 0; $j < $property->length; $j++) {
            $tableData = $property->item($j)->nodeValue;
            $tableRow .= "<td>" . $tableData . "</td>";
        }

        $html .= $tableRow . "</tr>";
    }

    echo $html . "</table>";
}
?>
</p>
