<?php
include "functions.php";

echo getScaffoldingPart1();
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

<?php
echo getScaffoldingPart2();

if (isset($_POST['submit'])) {
    try {
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

        $url = getApacheHost() . '/SOWA/aggregate.php?' . $queryString;
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