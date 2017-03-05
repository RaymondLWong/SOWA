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
    try {
        $url = 'http://localhost/SOWA/aggregate.php?name=' . $_POST['search'];
        $xml = new DOMDocument();
        $xml->load($url);
        $xslt = new XSLTProcessor();
        $xslDoc = new DOMDocument();
        $xslDoc->load('properties.xsl', LIBXML_NOCDATA);
        $xslt->importStylesheet($xslDoc);
        echo $xslt->transformToXML($xml);
    } catch (exception $e) {
        echo '<p>Unable to contact Web Service</p>';
        echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
    }
}
?>

</html>