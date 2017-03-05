<?php
header('Content-type:  text/xml');

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

//    $regex = "/[^\\w \-']|^$/";
//    if (
//        preg_match($regex, $title) &&
//        preg_match($regex, $desc) &&
//        preg_match($regex, $loc) &&
//        preg_match($regex, $addr)
//    ) {
//        die ('<ssssssssssss/>');
//    }
} else {
    showError("incompatible search term");
}

$host = "localhost:3306";
$user = "sowa_user";
$passwd = "PqKk6EyCYaJsZQSC";
$dbName = "sowa";

// TODO: change this and .NET version to be more flexible in searching, similar to term 1
$link = mysqli_connect($host, $user, $passwd, $dbName) or showError(mysqli_error($link));
$query = "
SELECT
	Title, Description, Type, Location, NoOfBeds, CostPerWeek, Address, Email
FROM Properties
INNER JOIN users ON users.UserID=properties.UserID
WHERE
	(Title LIKE '%{$title}%' OR
	Description LIKE '%{$desc}%' OR
	Location LIKE '%{$loc}%' OR
	Address LIKE '%{$addr}%')
	
	AND (CostPerWeek BETWEEN 0 AND 1000)
	AND (NoOfBeds BETWEEN 1 AND 4)
	AND Type LIKE '%%'
LIMIT 25
";

// if -1 used then don't add to query

$result = mysqli_query($link,$query) or showError(mysqli_error($link));

//print_r("<pre>" . mysqli_num_rows($result) . "</pre>");

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