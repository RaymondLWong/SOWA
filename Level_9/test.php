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
        table, th, td {
            border: 1px solid black;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .floating-panel {
            position: absolute;
            top: 10px;
            left: 15%
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        #geocode {
            top: 25%;
        }

        #loc {
            top: 50%;
        }

        #distance {
            top: 75%
        }

        #test {
            top: 90%
        }

    </style>
</head>
<body>
<div id="geocode" class="floating-panel">
    <label id="result"></label>
    <input id="address" type="text" value="London">
    <input id="convert" type="button" value="Geocode">
</div>
<div id="loc" class="floating-panel">
    <label id="curLoc"></label>
    <input id="getLoc" type="button" value="Get location">
</div>
<div id="distance" class="floating-panel">
    <label id="dist"></label>
    <input id="calcDistance" type="button" value="Calculate distance">
</div>
<div id="test" class="floating-panel">
    <input id="calc" type="button" value="Calculate distances from locations">
</div>
<div class="floating-panel">
    <table id="table">
        <tr id="headings">
            <th>PropertyID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Type</th>
            <th>Location</th>
            <th>NoOfBeds</th>
            <th>CostPerWeek</th>
            <th>Address</th>
            <th>Email</th>
        </tr>
        <tr>
            <td>PropertyID Value</td>
            <td>Title Value</td>
            <td>Description Value</td>
            <td>Type Value</td>
            <td>London</td>
            <td>NoOfBeds Value</td>
            <td>CostPerWeek Value</td>
            <td>Address Value</td>
            <td>Email Value</td>
        </tr>
        <tr>
            <td>PropertyID Value</td>
            <td>Title Value</td>
            <td>Description Value</td>
            <td>Type Value</td>
            <td>Tokyo</td>
            <td>NoOfBeds Value</td>
            <td>CostPerWeek Value</td>
            <td>Address Value</td>
            <td>Email Value</td>
        </tr>
        <tr>
            <td>PropertyID Value</td>
            <td>Title Value</td>
            <td>Description Value</td>
            <td>Type Value</td>
            <td>Hornchurch</td>
            <td>NoOfBeds Value</td>
            <td>CostPerWeek Value</td>
            <td>Address Value</td>
            <td>Email Value</td>
        </tr>
    </table>
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLBVnBeKdCUb_W6q-lfJ6A0jtwuBRv73s&callback=init">
</script>
</body>
</html>