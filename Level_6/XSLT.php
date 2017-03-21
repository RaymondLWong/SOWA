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

        $url = getLevelFromHost(0, 4) . 'aggregate.php?' . $queryString;
        $xml = new DOMDocument();
        $xml->load($url);
        $xslt = new XSLTProcessor();
        $xslDoc = new DOMDocument();
        $xslDoc->load('../common/properties.xsl', LIBXML_NOCDATA);
        $xslt->importStylesheet($xslDoc);
        $table = $xslt->transformToXML($xml);

        echo getScaffoldingPart2(
            $_POST['title'],
            $_POST['desc'],
            $_POST['loc'],
            $_POST['addr'],
            $_POST['type'],
            $_POST['limit'],
            $_POST['offset'],
            "example",
            $table
        );
    } catch (exception $e) {
        echo '<p>Unable to contact Web Service</p>';
        echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
    }
} else {
    echo getScaffoldingPart2();
}

?>