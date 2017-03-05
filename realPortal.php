<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search"/>
</form>
<?php

if (isset($_POST['submit'])) {
    $url = 'http://localhost/SOWA/aggregate.php?name=' . $_POST['search'];
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

</html>