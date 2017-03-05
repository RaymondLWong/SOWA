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
    let maxValue = 10 * 1000;
    $( "#cost" ).slider({
        range: true,
        min: 1,
        max: maxValue,
        values: [ 1, maxValue ], // start values
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