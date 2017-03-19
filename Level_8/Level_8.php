<?php
include "../common/functions.php";
?>
<html>
    <head>
        <title>Level 8</title>
    </head>
    <body>
        <div>
            <a href="<?php echo getISSHost() . "/search.asmx?op=lookupAllAsJSON"; ?>">Level 2 IIS web service rewritten to return JSON</a>
        </div>
        <div>
            <a href="level2asJSON.php">Level 2 PHP web service (using preset parameters) rewritten to return JSON</a>
        </div>
        <div>
            <a href="level3asJSON.php">Level 3 web service rewritten to return JSON</a>
        </div>
        <div>
            <a href="level4asJSON.php">Level 4 web service rewritten to return JSON</a>
        </div>
        <div>
            <a href="level7asJSON.php">Level 7 XHR rewritten to utilise JSON (contains scaffolding)</a>
        </div>
        <div>
            <a href="XML2JSON.xsl">XSL file used to convert XML to JSON</a>
        </div>
    </body>
</html>