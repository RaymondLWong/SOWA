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

function getScaffoldingPart1() {
    return "<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
    <link rel=\"stylesheet\" href=\"/resources/demos/style.css\">
    <script src=\"https://code.jquery.com/jquery-1.12.4.js\"></script>
    <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
    <script src=\"slider.js\"></script>

    <style>
        #NoOfBeds, #cost {
            width: 10%
        }
    </style>
</head>
<body>";
}

function getScaffoldingPart2() {
    return "

    <div>
        <label for=\"title\">Title</label>
        <input type=\"text\" name=\"title\" id=\"title\" value=\"title\"/>
    </div>

    <div>
        <label for=\"desc\">Description</label>
        <input type=\"text\" name=\"desc\" id=\"desc\" value=\"desc\"/>
    </div>

    <div>
        <label for=\"loc\">Location</label>
        <input type=\"text\" name=\"loc\" id=\"loc\" value=\"loc\"/>
    </div>

    <div>
        <label for=\"addr\">Address</label>
        <input type=\"text\" name=\"addr\" id=\"addr\" value=\"addr\"/>
    </div>

    <div>
        <label for=\"type\">Type of housing</label>
        <select name=\"type\" id=\"type\">
            <option value=\"0\" selected=\"selected\">Any</option>
            <option value=\"1\">House</option>
            <option value=\"2\">Flat</option>
            <option value=\"3\">Villa</option>
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
        <input type=\"text\" name=\"limit\" id=\"limit\" value=\"25\"/>
    </div>

    <div>
        <label for=\"offset\">Offset</label>
        <input type=\"text\" name=\"offset\" id=\"offset\" value=\"0\"/>
    </div>

    <input type=\"submit\" name=\"submit\" value=\"Search\">
</form>
</body>
</html>";
}