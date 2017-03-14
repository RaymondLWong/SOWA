<html>
    <body>
        <div>
            <a href="lookupFromMSSQL.php">Static test page with PHP</a>
        </div>
        <div>
            <a href="<?php include "../common/functions.php"; echo getISSHost(); ?>/search.asmx?op=lookupAll">.NET web service</a>
        </div>
    </body>
</html>