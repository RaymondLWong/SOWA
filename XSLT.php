<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>

<form action="realPortal.php" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search"/>
</form>
<?php

if (!empty($_POST)) {
    try {
        $url = 'http://localhost/SOWA/aggregate.php?name=' . $_POST['search'];
        $xml = new DOMDocument();
        $xml->loadXML($url);
        $xslt = new XSLTProcessor();
        $xslDoc = new DOMDocument();
        $xslDoc->load('properties.xsl', LIBXML_NOCDATA);
        $xslt->importStylesheet($xslDoc);
        echo $xslt->transformToXML($xmlDoc);
    } catch (exception $e) {
        echo '<p>Unable to contact Web Service</p>';
        echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
    }
}
?>

</html>