<?php

function getHost() {
    return "http://" . $_SERVER['HTTP_HOST'];
}

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

function findImageAndReturnLocation($picID, $curPage) {
    $picLoc = findImage($picID);

    if ($picLoc != null) {
        $imagePath = "http://" . $_SERVER['HTTP_HOST'] . str_replace($curPage, $picLoc, $_SERVER['PHP_SELF']);
        return "<img src='{$imagePath}' />";
    } else {
        return "";
    }
}

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

function validateXML($rootNode, DOMDocument $domDoc) {
    $dtd = new DOMImplementation;
    $docType = $dtd->createDocumentType($rootNode, null, 'properties.dtd');
    $xml = $dtd->createDocument(null, null, $docType);
    $xml->encoding = "utf-8";

    $oldNode = $domDoc->getElementsByTagName($rootNode)->item(0);
    $newNode = $xml->importNode($oldNode, true);
    $xml->appendChild($newNode);

    return $xml->validate();
}

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
    <script>
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

function getScaffoldingPart2(
    $title = "title",
    $desc = "desc",
    $loc = "loc",
    $addr = "addr",
    $type = 0,
    $limit = 20,
    $offset = 0
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
</body>
</html>
";
}