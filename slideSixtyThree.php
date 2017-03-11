<h1>SOAP WebSite </h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <p>
        <?php
        $t = ( isset($_POST['title']) ) ? $_POST['title'] : 'title';
        ?>
        <input type="text" name="title" value="<?php echo $t ?>"/>
        <input type="submit" />
    </p>
</form>
<p>
    <?php
    if ( isset($_POST['title']) ){
        try {
            $url = getISSHost() . '/HelloWorld.asmx/lookup?title='.$_POST['title'];
            $xmlString = file_get_contents($url);
            $xmlDoc = new DOMDocument();
            $xmlDoc->loadXML($xmlString, LIBXML_NOBLANKS);
            $xslt = new XSLTProcessor();
            $xslDoc = new DOMDocument();
            $xslDoc->load('test.xsl', LIBXML_NOCDATA);
            $xslt->importStylesheet($xslDoc);
            echo $xslt->transformToXML($xmlDoc);
        } catch ( exception $e ) {
            echo '<p>Unable to contact Web Service</p>';
            echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
        }
    }
    ?>

</p>


