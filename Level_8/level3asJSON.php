<?php

include "../common/db.php";
include "../common/functions.php";

$rootNode = "listings";

if (
    isset($_REQUEST['title']) &&
    isset($_REQUEST['desc']) &&
    isset($_REQUEST['loc']) &&
    isset($_REQUEST['addr'])
) {
    $title = trim($_REQUEST['title']);
    $desc = trim($_REQUEST['desc']);
    $loc = trim($_REQUEST['loc']);
    $addr = trim($_REQUEST['addr']);
    $type = trim($_REQUEST['type']);
    $minBeds = trim($_REQUEST['minBeds']);
    $maxBeds = trim($_REQUEST['maxBeds']);
    $minCost = trim($_REQUEST['minCost']);
    $maxCost = trim($_REQUEST['maxCost']);
    $limit = trim($_REQUEST['limit']);
    $offset = trim($_REQUEST['offset']);

    $regex = "/[^\\w \-']|^$/";
    if (
        preg_match($regex, $title) &&
        preg_match($regex, $desc) &&
        preg_match($regex, $loc) &&
        preg_match($regex, $addr) &&
        preg_match($regex, $type) &&
        preg_match($regex, $minBeds) &&
        preg_match($regex, $maxBeds) &&
        preg_match($regex, $minCost) &&
        preg_match($regex, $maxCost) &&
        preg_match($regex, $limit) &&
        preg_match($regex, $offset)
    ) {
        die ("<{$rootNode}/>");
    }
} else {
    showError("incompatible search term");
}

$args = array(
    'title' => $title,
    'desc' => $desc,
    'loc' => $loc,
    'addr' => $addr,
    'type' => $type,
    'minBeds' => $minBeds,
    'maxBeds' => $maxBeds,
    'minCost' => $minCost,
    'maxCost' => $maxCost,
    'limit' => $limit,
    'offset' => $offset
);
$queryString = http_build_query($args);

$url = getLevelFromHost(0, 3) . 'search.php?' . $queryString;
$xml = new DOMDocument();
$xml->load($url);

// return result
header('Content-Type: application/json');
echo transformXMLWithXSLT($xml, 'XML2JSON.xsl');

?>