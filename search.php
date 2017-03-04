<?php
header('Content-type:  text/xml');

$rootNode = "listings";

function showError($msg) {
    $rootNode = "listings";
    die ('<' . $rootNode . '><error>' . $msg . '</error></' . $rootNode . '>');
}

if ( isset($_REQUEST['name']) ) {
    $nq = trim($_REQUEST['name']);
    if ( preg_match("/[^a-zA-Z0-9 \-']|^$/",$nq) )die ('<' . $rootNode . '/>');
} else {
    showError("incompatible search term");
}

$host = "localhost:3306";
$user = "sowa_user";
$passwd = "PqKk6EyCYaJsZQSC";
$dbName = "sowa";

$link = mysqli_connect($host, $user, $passwd, $dbName) or showError(mysqli_error($link));
$query = 'SELECT
            Title, Description, Type, Location, NoOfBeds, CostPerWeek, Address, users.Email
          FROM Properties
          INNER JOIN users ON users.UserID=properties.UserID
          WHERE properties.Description
          RLIKE "' . $nq . '"';
$result = mysqli_query($link,$query) or showError(mysqli_error($link));

// instantiate DOM container
$xmlDom = new DOMDocument();
$xmlDom->appendChild($xmlDom->createElement($rootNode));
$xmlRoot = $xmlDom->documentElement;

// add rows from the result
while ($row = mysqli_fetch_assoc($result) ) {
    $xmlProperty = appendProperty(
        ['Title', 'Description', 'Type', 'Location', 'NoOfBeds', 'CostPerWeek', 'Address', 'Email'],
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