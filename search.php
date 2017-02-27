<?php
header('Content-type:  text/xml');

if ( isset($_REQUEST['name']) ) {
    $nq = trim($_REQUEST['name']);
    if ( preg_match("/[^a-zA-Z0-9 \-']|^$/",$nq) )die ('<listings/>');
} else {
    die ('<listings><error>incompatible search term</error></listings>');
}

$host = "localhost:3306";
$user = "sowa_user";
$passwd = "PqKk6EyCYaJsZQSC";
$dbName = "sowa";


$link = mysqli_connect($host, $user, $passwd, $dbName) or die ('<listings><error>'.mysqli_error($link).'</error></listings>');
$query = 'SELECT Title, Description, Type, Location, NoOfBeds, CostPerWeek, Address FROM Properties WHERE Description RLIKE "' . $nq . '"';
$result = mysqli_query($link,$query) or die ('<listings><error>'.mysqli_error($link).'</error></listings>');

// instantiate DOM container
$xmlDom = new DOMDocument();
$xmlDom->appendChild($xmlDom->createElement('listings'));
$xmlRoot = $xmlDom->documentElement;

// add rows from the result
while ($row = mysqli_fetch_assoc($result) ) {
    $xmlProperty = appendProperty(
        ['Title', 'Description', 'Type', 'Location', 'NoOfBeds', 'CostPerWeek', 'Address'],
        $row, $xmlDom);
    $xmlRoot->appendChild($xmlProperty);
}

// return result
echo $xmlDom->saveXML();

function appendProperty($arrayOfNodes, $row, DOMDocument $xmlDom) {
    $xmlProperty = $xmlDom->createElement('Property');
    foreach ($arrayOfNodes as $node) {
        $xmlProperty->appendChild(appendToDOM($node, $row, $xmlDom));
    }
    return $xmlProperty;
}

function appendToDOM($name, $sqlResultsArray, DOMDocument $xmlDom) {
    $xmlType = $xmlDom->createElement($name);
    $xmlTxt = $xmlDom->createTextNode($sqlResultsArray[$name]);
    $xmlType->appendChild($xmlTxt);
    return $xmlType;
}

?>