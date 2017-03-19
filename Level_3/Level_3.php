<?php
include "../common/functions.php";

$host = getLevelFromHost(0, 3);
?>
<html>
    <head>
        <title>Level 3</title>
    </head>
    <body>
        <div>
            <a href="<?php echo $host; ?>search.php">PHP Web Service that returns search results in XML</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>searchTest.php">Scaffolding for above web service</a>
        </div>
    </body>
</html>