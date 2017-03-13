<?php

// get the host address of the local web server
function getHost() {
    return "http://" . $_SERVER['HTTP_HOST'];
}

// get IIS host address
function getISSHost() {
    // TODO: change this on uni servers
    return "http://localhost:64153";
}

function getApacheHost() {
    return "http://localhost";
}

// show an error for no images found
function getNoImagesAvailable($propID) {
    return "No associated images found for property with id {$propID}.";
}

// return the error message when an image isn't found on the server
function getImageNotFoundOnServerError($picID) {
    return "Image with id {$picID} not found on server.";
}

// list of table headings
function getHeadings() {
    return [
        "Title",
        "Description",
        "Type",
        "Location",
        "NoOfBeds",
        "CostPerWeek",
        "Address",
        "Email"
    ];
}

// get table HTML for images (on "display more" / single property screen)
function getImageTableHTML() {
    return "<table>
<tr>
    <caption>Images</caption>
</tr>
    <tr>";
}

// query a web service from IIS and return the XML
function queryIISWebService($url) {
    $result = file_get_contents($url);
    $xml = new DOMDocument();
    $xml->loadXML($result, LIBXML_NOBLANKS);

    return $xml;
}

// scaffolding for lv5 more info
function getSinglePropertyScaffold() {
    return "
<html>

<head>
<style>
        table, th, td {
            border: 1px solid black;
        }
        
        img {
            width: 300px
        }
    </style>
</head>

<body>
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
</tr>\r\n";
}

// find an image on the local web server
function findImage($picID) {
    $pattern = "images/properties/" . $picID . ".{jpeg,jpg,png,gif}";
    $results = glob($pattern, GLOB_BRACE);
    // return the location of the picture if found
    if (count($results) == 1) {
        return $results[0];
    } else {
        return '';
    }
}

// wrap a url with an image tag
function returnImageTag($url) {
    return "<img src='{$url}' />";
}

// find an image on the local web server and return an HTML image if it exists
function findImageAndReturnLocation($picID, $curPage) {
    $picLoc = findImage($picID);

    if ($picLoc != null) {
        $imagePath = getHost() . str_replace($curPage, $picLoc, $_SERVER['PHP_SELF']);
        return returnImageTag($imagePath);
    } else {
        return "";
    }
}

// convert the values of the Housing Type to string
function getHousingAsStr($type) {
    switch ($type) {
        case 0:
            return '';
        case 1:
            return 'House';
        case 2:
            return 'Flat';
        case 3:
            return 'Villa';
        default:
            return '';
    }
}

// validate an XML document with the DTD
function validateXML($rootNode, DOMDocument $domDoc) {
    $dtd = new DOMImplementation;
    $docType = $dtd->createDocumentType($rootNode, null, '../properties.dtd');
    $xml = $dtd->createDocument(null, null, $docType);
    $xml->encoding = "utf-8";

    $oldNode = $domDoc->getElementsByTagName($rootNode)->item(0);
    $newNode = $xml->importNode($oldNode, true);
    $xml->appendChild($newNode);

    return $xml->validate();
}


/*
 * JavaScript and HTML is returned here as a string so PHP can be used inline to retain previous values
 */

// create a scaffold to test the web services (head part)
function getScaffoldingPart1(
    $minBeds = 1,
    $maxBeds = 4,
    $minCost = 1,
    $maxCost = 10 * 1000
) {
    return "<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
    <link rel=\"stylesheet\" href=\"/resources/demos/style.css\">
    <script src=\"https://code.jquery.com/jquery-1.12.4.js\"></script>
    <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
    <script src=\"../Scripts/xslt.js\"></script>
    <script>
        // slider from: https://jqueryui.com/slider/#range 
        $( function() {
            $( \"#NoOfBeds\" ).slider({
                range: true,
                min: 1,
                max: 4,
                values: [ {$minBeds}, {$maxBeds} ], // start values
                slide: function( event, ui ) {
                    let bedMin = ui.values[ 0 ];
                    let bedMax = ui.values[ 1 ];
        
                    $( \"#bedRange\" ).val(bedMin + ' - ' + bedMax);
                    $(\"#minBeds\").val(bedMin);
                    $(\"#maxBeds\").val(bedMax);
                }
            });
        
            let startMin = $( \"#NoOfBeds\" ).slider( \"values\", 0 );
            let startMax = $( \"#NoOfBeds\" ).slider( \"values\", 1 );
        
            $( \"#bedRange\" ).val(startMin + ' - ' + startMax);
            $(\"#minBeds\").val(startMin);
            $(\"#maxBeds\").val(startMax);
        } );
        
        // http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
        let formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'GBP',
            minimumFractionDigits: 0
        });
        
        $( function() {
            let maxValue = 10 * 1000;
            $( \"#cost\" ).slider({
                range: true,
                min: 1,
                max: maxValue,
                values: [ {$minCost}, {$maxCost} ], // start values
                slide: function( event, ui ) {
                    let min = ui.values[ 0 ];
                    let max = ui.values[ 1 ];
        
                    $( \"#costRange\" ).val(formatter.format(min) + ' - ' + formatter.format(max));
                    $(\"#minCost\").val(min);
                    $(\"#maxCost\").val(max);
                }
            });
        
            let startMin = $( \"#cost\" ).slider( \"values\", 0 );
            let startMax = $( \"#cost\" ).slider( \"values\", 1 );
        
            $( \"#costRange\" ).val(formatter.format(startMin) + ' - ' + formatter.format(startMax));
            $(\"#minCost\").val(startMin);
            $(\"#maxCost\").val(startMax);
        } );
    </script>

    <style>
        table, th, td {
            border: 1px solid black;
        }
        
        #NoOfBeds, #cost {
            width: 10%
        }
        
        img {
            width: 300px
        }
    </style>
</head>
<body>";
}

// create a scaffold to test the web services (body part)
function getScaffoldingPart2(
    $title = "title",
    $desc = "desc",
    $loc = "loc",
    $addr = "addr",
    $type = 0,
    $limit = 20,
    $offset = 0,
    $divID = "example",
    $endOfBody = ""
) {

    $bedType0 = ($type == 0) ? ' selected="selected"' : '';
    $bedType1 = ($type == 1) ? ' selected="selected"' : '';
    $bedType2 = ($type == 2) ? ' selected="selected"' : '';
    $bedType3 = ($type == 3) ? ' selected="selected"' : '';

    return "

    <div>
        <label for=\"title\">Title</label>
        <input type=\"text\" name=\"title\" id=\"title\" value=\"{$title}\"/>
    </div>

    <div>
        <label for=\"desc\">Description</label>
        <input type=\"text\" name=\"desc\" id=\"desc\" value=\"{$desc}\"/>
    </div>

    <div>
        <label for=\"loc\">Location</label>
        <input type=\"text\" name=\"loc\" id=\"loc\" value=\"{$loc}\"/>
    </div>

    <div>
        <label for=\"addr\">Address</label>
        <input type=\"text\" name=\"addr\" id=\"addr\" value=\"{$addr}\"/>
    </div>

    <div>
        <label for=\"type\">Type of housing</label>
        <select name=\"type\" id=\"type\">
            <option value=\"0\"{$bedType0}>Any</option>
            <option value=\"1\"{$bedType1}>House</option>
            <option value=\"2\"{$bedType2}>Flat</option>
            <option value=\"3\"{$bedType3}>Villa</option>
        </select>
    </div>

    <div>
        <label for=\"bedRange\">Number of beds:</label>
        <input type=\"text\" id=\"bedRange\" readonly=\"readonly\" style=\"border:0;\">
    </div>
    <div>
        <label for=\"minBeds\">Min:</label>
        <input type=\"text\" id=\"minBeds\" name=\"minBeds\" readonly=\"readonly\">

        <label for=\"maxBeds\">Max:</label>
        <input type=\"text\" id=\"maxBeds\" name=\"maxBeds\" readonly=\"readonly\">
    </div>
    <br/>
    <div id=\"NoOfBeds\"></div>
    <br/>

    <div>
        <label for=\"costRange\">Price range:</label>
        <input type=\"text\" id=\"costRange\" readonly=\"readonly\" style=\"border:0; color:#f6931f; font-weight:bold;\">
    </div>
    <div>
        <label for=\"minCost\">Min:</label>
        <input type=\"text\" id=\"minCost\" name=\"minCost\" readonly=\"readonly\">

        <label for=\"maxCost\">Max:</label>
        <input type=\"text\" id=\"maxCost\" name=\"maxCost\" readonly=\"readonly\">
    </div>
    <br/>
    <div id=\"cost\"></div>
    <br/>

    <div>
        <label for=\"limit\">Limit</label>
        <input type=\"text\" name=\"limit\" id=\"limit\" value=\"{$limit}\"/>
    </div>

    <div>
        <label for=\"offset\">Offset</label>
        <input type=\"text\" name=\"offset\" id=\"offset\" value=\"{$offset}\"/>
    </div>

    <input type=\"submit\" name=\"submit\" value=\"Search\">
</form>
<div id='{$divID}'></div>
{$endOfBody}
</body>
</html>
";
}

function appendProperty($arrayOfNodes, $row, DOMDocument $xmlDom, $link) {
    // http://php.net/manual/en/domdocument.createattribute.php
    $xmlProperty = $xmlDom->createElement('Property');
    $attr = $xmlDom->createAttribute('source');
    $attr->value = 'PHP';
    $xmlProperty->appendChild($attr);

    foreach ($arrayOfNodes as $node) {
        $xmlProperty->appendChild(appendToDOM($node, $row, $xmlDom));
    }

    // add a Picture ID (if it exists)
    $imageQuery = "SELECT PictureID FROM gallery WHERE PropertyId={$row['PropertyID']} LIMIT 1";

    if ($imageResult = mysqli_query($link, $imageQuery)) {
        $imageRow = mysqli_fetch_assoc($imageResult);
        $xmlProperty->appendChild(appendToDOM('PictureID', $imageRow, $xmlDom));
    } else {
        showError(mysqli_error($link));
    }

    return $xmlProperty;
}

function appendToDOM($name, $sqlResultsArray, DOMDocument $xmlDom) {
    $xmlType = $xmlDom->createElement($name);
    $xmlTxt = $xmlDom->createTextNode($sqlResultsArray[$name]);
    $xmlType->appendChild($xmlTxt);
    return $xmlType;
}