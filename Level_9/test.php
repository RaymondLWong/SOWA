<!DOCTYPE html>
<html>
<head>
    <title>Geocoding service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="GoogleMapsAPIs.js"></script>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #floating-panel, #second {
            position: absolute;
            top: 10px;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        #floating-panel {
            left: 15%;
        }

        #second {
            left: 50%;
        }
    </style>
</head>
<body>
<div id="floating-panel">
    <label id="result"></label>
    <input id="address" type="text" value="Sydney, NSW">
    <input id="submit" type="button" value="Geocode">
</div>
<div id="second">
    <label id="curLoc"></label>
    <input id="getLoc" type="button" value="Get location">
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLBVnBeKdCUb_W6q-lfJ6A0jtwuBRv73s&callback=init">
</script>
</body>
</html>