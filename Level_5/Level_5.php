<?php

include "../common/functions.php";

$host = getLevelFromHost(0, 5);

?>
<html>
    <head>
        <title>Level 5</title>
    </head>
    <body>
        <div>
            <a href="realPortal.php">Scaffolding that displays aggregated search results in a simple table format</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>findImage.php">Web service that looks for an image (on the local Apache web server) by its ID and returns the location if found</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>findImageTest.php">Scaffolding for above (image finding) web service</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>fetchAllPictures.php">Test Web service that returns all of a property's images (in HTML image tags)</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>fetchProperty.php">Apache Web service that returns all of a property's information (including images) in HTML</a>
        </div>
        <div>
            <a href="<?php echo $host; ?>fetchPropertyFromCSharp.php">Web service that relies on an IIS web service to return all of a property's information (including images) in HTML</a>
        </div>
    </body>
</html>
