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
            $client = new SoapClient('http://localhost:64153/HelloWorld.asmx?WSDL');
            $xmlString = $client->lookup($_POST)->lookupResult->any;

//            echo $xmlString;

            $xmlDoc = new DOMDocument();
            $xmlDoc->loadXML($xmlString);
            $xslt = new XSLTProcessor();
            $xslDoc = new DOMDocument();
            $xslDoc->load('test.xsl', LIBXML_NOCDATA);
            $xslt->importStylesheet($xslDoc);

//            echo "<br/><br/>";
//            echo $xmlDoc->saveXML();
//            echo "<br/><br/>";

            echo $xslt->transformToXML($xmlDoc);
        } catch ( exception $e ) {
            echo '<p>Unable to contact Web Service</p>';
            echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
        }
    }
    ?>
</p>


