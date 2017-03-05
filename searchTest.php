<?php

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

if(isset($_POST['submit'])){
    if (
        isset($_POST['title']) &&
        isset($_POST['desc']) &&
        isset($_POST['loc']) &&
        isset($_POST['addr'])
    ) {
        $currentPage = $_SERVER['REQUEST_URI'];

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

        $newPage = str_replace('searchTest.php', 'search.php?' . $queryString, $currentPage);
        header('Location: '. $newPage);
    } else {
        echo "One of the fields are empty, please fill them all in.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#NoOfBeds" ).slider({
                range: true,
                min: 1,
                max: 4,
                values: [ 1, 4 ], // start values
                slide: function( event, ui ) {
                    let bedMin = ui.values[ 0 ];
                    let bedMax = ui.values[ 1 ];

                    $( "#bedRange" ).val( `${bedMin} - ${bedMax}` );
                    $("#minBeds").val(bedMin);
                    $("#maxBeds").val(bedMax);
                }
            });

            let startMin = $( "#NoOfBeds" ).slider( "values", 0 );
            let startMax = $( "#NoOfBeds" ).slider( "values", 1 );

            $( "#bedRange" ).val( `${startMin} - ${startMax}` );
            $("#minBeds").val(startMin);
            $("#maxBeds").val(startMax);
        } );

        // http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
        let formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'GBP',
            minimumFractionDigits: 0
        });

        $( function() {
            $( "#cost" ).slider({
                range: true,
                min: 1,
                max: 10000000,
                values: [ 1, 10000000 ], // start values
                slide: function( event, ui ) {
                    let min = ui.values[ 0 ];
                    let max = ui.values[ 1 ];

                    $( "#costRange" ).val( `${formatter.format(min)} - ${formatter.format(max)}` );
                    $("#minCost").val(min);
                    $("#maxCost").val(max);
                }
            });

            let startMin = $( "#cost" ).slider( "values", 0 );
            let startMax = $( "#cost" ).slider( "values", 1 );

            $( "#costRange" ).val( `${formatter.format(startMin)} - ${formatter.format(startMax)}` );
            $("#minCost").val(startMin);
            $("#maxCost").val(startMax);
        } );
    </script>
    <style>
        #NoOfBeds, #cost {
            width: 10%
        }
    </style>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="title"/>
    </div>

    <div>
        <label for="desc">Description</label>
        <input type="text" name="desc" id="desc" value="desc"/>
    </div>

    <div>
        <label for="loc">Location</label>
        <input type="text" name="loc" id="loc" value="loc"/>
    </div>

    <div>
        <label for="addr">Address</label>
        <input type="text" name="addr" id="addr" value="addr"/>
    </div>

    <div>
        <label for="type">Type of housing</label>
        <select name="type" id="type">
            <option value="0" selected="selected">Any</option>
            <option value="1">House</option>
            <option value="2">Flat</option>
            <option value="3">Villa</option>
        </select>
    </div>

    <div>
        <label for="bedRange">Number of beds:</label>
        <input type="text" id="bedRange" readonly="readonly" style="border:0;">
    </div>
    <div>
        <label for="minBeds">Min:</label>
        <input type="text" id="minBeds" name="minBeds" readonly="readonly">

        <label for="maxBeds">Max:</label>
        <input type="text" id="maxBeds" name="maxBeds" readonly="readonly">
    </div>
    <br/>
    <div id="NoOfBeds"></div>
    <br/>

    <div>
        <label for="costRange">Price range:</label>
        <input type="text" id="costRange" readonly="readonly" style="border:0; color:#f6931f; font-weight:bold;">
    </div>
    <div>
        <label for="minCost">Min:</label>
        <input type="text" id="minCost" name="minCost" readonly="readonly">

        <label for="maxCost">Max:</label>
        <input type="text" id="maxCost" name="maxCost" readonly="readonly">
    </div>
    <br/>
    <div id="cost"></div>
    <br/>

    <div>
        <label for="limit">Limit</label>
        <input type="text" name="limit" id="limit" value="25"/>
    </div>

    <div>
        <label for="offset">Offset</label>
        <input type="text" name="offset" id="offset" value="0"/>
    </div>

    <input type="submit" name="submit" value="Search">
</form>
</body>
</html>