<?php

include "db.php";
include "functions.php";

$rootNode = "listings";

function showError($msg) {
    $rootNode = "listings";
    die ('<' . $rootNode . '><error>' . $msg . '</error></' . $rootNode . '>');
}

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
        die ('<{$rootNode}/>');
    }
} else {
    showError("incompatible search term");
}

$query = "
SELECT
	PropertyID, Title, Description, Type, Location, NoOfBeds, CostPerWeek, Address, Email
FROM Properties
INNER JOIN users ON users.UserID=properties.UserID
WHERE
	(Title LIKE '%{$title}%' OR
	Description LIKE '%{$desc}%' OR
	Location LIKE '%{$loc}%' OR
	Address LIKE '%{$addr}%')
	
	AND (CostPerWeek BETWEEN {$minCost} AND {$maxCost})
	AND (NoOfBeds BETWEEN {$minBeds} AND {$maxBeds})
	AND (Type LIKE '%{$type}%')
LIMIT {$limit}
OFFSET {$offset}
";

$result = mysqli_query($link,$query) or showError(mysqli_error($link));

// instantiate DOM container
$xmlDom = new DOMDocument();
$xmlDom->appendChild($xmlDom->createElement($rootNode));
$xmlRoot = $xmlDom->documentElement;

// add rows from the result
while ($row = mysqli_fetch_assoc($result)) {
    // create XML elements with the same name as the database fields
    // TODO: use associative array instead to choose XML element names?
    $xmlProperty = appendProperty(
        ['PropertyID', 'Title', 'Description', 'Type', 'Location', 'NoOfBeds', 'CostPerWeek', 'Address', 'Email'],
        $row, $xmlDom, $link);
    $xmlRoot->appendChild($xmlProperty);
}

// return result
header('Content-type:  text/xml');
echo $xmlDom->saveXML();

?>