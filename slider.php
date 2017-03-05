<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Slider - Range slider</title>
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
                    $("#minBeds").val(ui.values[ 0 ]);
                    $("#maxBeds").val(ui.values[ 1 ]);
                }
            });
            $("#minBeds").val($( "#NoOfBeds" ).slider( "values", 0 ));
            $("#maxBeds").val($( "#NoOfBeds" ).slider( "values", 1 ));
        } );

        // http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
        var formatter = new Intl.NumberFormat('en-US', {
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
                    var min = formatter.format(ui.values[ 0 ]);
                    var max = formatter.format(ui.values[ 1 ]);

                    $( "#amount" ).val( `${min} - ${max}` );
                    $("#minCost").val(min);
                    $("#maxCost").val(max);
                }
            });

            var startMin = formatter.format($( "#cost" ).slider( "values", 0 ));
            var startMax = formatter.format($( "#cost" ).slider( "values", 1 ));

            $( "#amount" ).val( `${startMin} - ${startMax}` );
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

<form>
    <div>
        <label for="minBeds">Min:</label>
        <input type="text" id="minBeds">

        <label for="maxBeds">Max:</label>
        <input type="text" id="maxBeds">
    </div>
    <br/>
    <div id="NoOfBeds"></div>
    <br/>

    <div>
        <label for="amount">Price range:</label>
        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
    </div>
    <div>
        <label for="minCost">Min:</label>
        <input type="text" id="minCost">

        <label for="maxCost">Max:</label>
        <input type="text" id="maxCost">
    </div>
    <br/>
    <div id="cost"></div>
    <br/>

</form>

</body>
</html>